<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Log\Log;
use Cake\I18n\FrozenTime;

/**
 * CureCallbackController
 *
 * Receives extraction-result callbacks from the CURE Flask app.
 *
 * Endpoint:  POST /api/nat/cure-result
 *
 * Headers:
 *   X-Cure-Auth: <shared secret> (validated against Configure::read('Cure.authToken'))
 *
 * Body:
 *   {
 *     "nat_file_number": "NAT-2026-00042",
 *     "status":          "Success" | "Failure",
 *     "status_reason":   null | "...",
 *     "data":            { ... full extracted O&E data ... },
 *     "report_files":    [ ... PDF / MD paths or base64 ... ]
 *   }
 *
 * Behavior:
 *   1. Validates the X-Cure-Auth header (skipped if no token configured).
 *   2. Validates required body fields (nat_file_number, status, data).
 *   3. Looks up the matching files_main_data row by NATFileNumber.
 *   4. Persists the payload to cure_exam_results (data + report_files as JSON).
 *   5. Returns 200 OK with {success, nat_file_number, cure_result_id, message}.
 *
 * Phase 2 scope: Storage only. UI mapping into "Receipt of Exam" comes in Phase 3.
 */
class CureCallbackController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('FilesMainData');
        $this->loadModel('CureExamResults');
        $this->loadComponent('RequestHandler');
    }

    /**
     * POST /api/nat/cure-result
     */
    public function receive()
    {
        $this->request->allowMethod(['post']);
        $this->RequestHandler->renderAs($this, 'json');
        $this->viewBuilder()->setClassName('Json');

        // ---- 1. Auth check ----
        $expectedToken = (string) Configure::read('Cure.authToken', '');
        $providedToken = $this->request->getHeaderLine('X-Cure-Auth');

        if ($expectedToken !== '' && $providedToken !== $expectedToken) {
            $this->response = $this->response->withStatus(401);
            $this->set([
                'success' => false,
                'error'   => 'Unauthorized',
                'message' => 'Missing or invalid X-Cure-Auth header',
            ]);
            $this->viewBuilder()->setOption('serialize', ['success', 'error', 'message']);
            return;
        }

        // ---- 2. Validate body ----
        $body = $this->request->getData();

        $natFileNumber = trim((string) ($body['nat_file_number'] ?? ''));
        $status        = trim((string) ($body['status'] ?? ''));
        $data          = $body['data'] ?? null;

        $missing = [];
        if ($natFileNumber === '') {
            $missing[] = 'nat_file_number';
        }
        if ($status === '') {
            $missing[] = 'status';
        }
        if ($data === null) {
            $missing[] = 'data';
        }

        if (!empty($missing)) {
            $this->response = $this->response->withStatus(400);
            $this->set([
                'success' => false,
                'error'   => 'Bad Request',
                'message' => 'Missing required field(s): ' . implode(', ', $missing),
            ]);
            $this->viewBuilder()->setOption('serialize', ['success', 'error', 'message']);
            return;
        }

        // ---- 3. Look up files_main_data row ----
        $fmdRow = $this->FilesMainData->find()
            ->where(['NATFileNumber' => $natFileNumber])
            ->first();

        if (!$fmdRow || !$fmdRow->Id) {
            $this->response = $this->response->withStatus(404);
            $this->set([
                'success' => false,
                'error'   => 'Not Found',
                'message' => "No files_main_data row matched NATFileNumber={$natFileNumber}",
            ]);
            $this->viewBuilder()->setOption('serialize', ['success', 'error', 'message']);
            return;
        }

        // ---- 4. Persist to cure_exam_results ----
        $statusReason = $body['status_reason'] ?? null;
        $reportFiles  = $body['report_files'] ?? [];
        $requestType  = (is_array($data) && isset($data['_meta']['request_type']))
            ? $data['_meta']['request_type']
            : null;

        $entity = $this->CureExamResults->newEntity([
            'rec_id'            => $fmdRow->Id,
            'nat_file_number'   => $natFileNumber,
            'status'            => $status,
            'status_reason'     => is_string($statusReason) ? $statusReason : null,
            'request_type'      => is_string($requestType) ? $requestType : null,
            'data_json'         => json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'report_files_json' => json_encode($reportFiles, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'received_at'       => FrozenTime::now(),
        ]);

        if (!$this->CureExamResults->save($entity)) {
            Log::error(
                'CURE callback save failed — NATFileNumber: ' . $natFileNumber
                . ', errors: ' . json_encode($entity->getErrors()),
                ['scope' => 'cure']
            );

            $this->response = $this->response->withStatus(500);
            $this->set([
                'success' => false,
                'error'   => 'Internal Server Error',
                'message' => 'Failed to persist CURE result',
                'errors'  => $entity->getErrors(),
            ]);
            $this->viewBuilder()->setOption('serialize', ['success', 'error', 'message', 'errors']);
            return;
        }

        Log::info(
            'CURE callback received — NATFileNumber: ' . $natFileNumber
            . ', status: ' . $status
            . ', cure_exam_results.id: ' . $entity->id,
            ['scope' => 'cure']
        );

        // ---- 5. Success ----
        $this->set([
            'success'         => true,
            'nat_file_number' => $natFileNumber,
            'cure_result_id'  => $entity->id,
            'message'         => 'CURE result received and persisted',
        ]);
        $this->viewBuilder()->setOption('serialize', [
            'success', 'nat_file_number', 'cure_result_id', 'message',
        ]);
    }
}
