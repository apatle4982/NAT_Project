<?php
// src/Controller/ReviewsController.php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Routing\Router;
use Cake\Core\Configure;
use App\Controller\PdfController;
use DocuSign\eSign\Client\ApiClient;
use DocuSign\eSign\Configuration as DocusignConfig;
use DocuSign\eSign\Api\EnvelopesApi;
use DocuSign\eSign\Model\Document;
use DocuSign\eSign\Model\Signer;
use DocuSign\eSign\Model\SignHere;
use DocuSign\eSign\Model\Tabs;
use DocuSign\eSign\Model\Recipients;
use DocuSign\eSign\Model\EnvelopeDefinition;
use DocuSign\eSign\Model\RecipientViewRequest;
use DocuSign\eSign\Configuration;
use DocuSign\eSign\ApiException;
use DocuSign\eSign\Model\RecipientSigningViewRequest;
use Smalot\PdfParser\Parser;

class ReviewsController extends AppController
{
    private $columnHeaders = ["RecId","status","comment","created_date"];

	private $columns_alise = [
                                "ID" => "Id",
								"RecId" => "RecId",
								'Status'=>'status',
								'Comment'=>'comment',
								'Created date'=>'created_date',
								"Actions" => ""
                            ];
	private $columnsorder = ['Id','RecId','status','comment','created_date'];
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel("FilesMainData");
        $this->loadModel('FilesVendorAssignment');
        $this->loadModel('FilesAolAssignment');
        $this->loadModel('FilesAttorneyAssignment');
        $this->loadModel('FilesEscrowAssignment');
        $this->loadComponent('GeneratePDF');
        $this->loadModel('AttorneyReviews');
        $this->loadModel('FilesExamReceipt');
        $this->loadModel("CompanyFieldsMap");
        $this->loadModel("CompanyMst");
        $this->loadModel("Vendors");
        $this->loadModel('PublicNotes');
        $this->loadComponent('RequestHandler');
        $this->viewBuilder()->setLayout('default');
        $this->autoRender = true;
        //$this->Authentication->allowUnauthenticated(['index', 'add']);
    }

    public function index($id = null){

        if ($id !== null) {
            $id = (int) $id;
            $this->set('reviewId', $id);
            
           // echo $id; exit;
            
            $fmd_data = $this->FilesMainData->find()->where(['Id' => $id])->first();
            
        } else {
            $aol_data = null; // Set a default value to avoid query errors
        }
        
        
        $this->set(compact('fmd_data'));
        //echo "<pre>";print_r($fmd_data);echo "</pre>";
        $review = $this->AttorneyReviews->newEmptyEntity();
        $FilesMainData = $fmd_data; // file main data id
        $fmd_id = $fmd_data['Id']; // file main data id
    	$companyId = $fmd_data['company_id']; // need to discuss
    	$examReceiptFields = $this->FilesExamReceipt->getMainDataAll($id);
        $examReceiptFields1 = $this->FilesExamReceipt->find()->where(['RecId' => $id])->first();
    	$partnerMapFields = $this->CompanyFieldsMap->partnerMapFields($companyId);
    	
        $attorney = $this->FilesAttorneyAssignment->find()->where(['RecId' => $id])->first(); 
        $attorney_dtl = [];
        if(!empty($attorney)){
            $attorney_dtl = $this->Vendors->find()->where(['Id' => $attorney['vendorid']])->first(); 
        }
        
        $attorneyReviewDtl = $this->AttorneyReviews->find()->where(['RecId' => $id])->first();
        //print_r($attorneyReviewDtl  );exit;
        //echo "<pre>";print_r($attorney_dtl['name']);echo "</pre>";
        $this->set(compact('FilesMainData','examReceiptFields', 'attorney_dtl', 'examReceiptFields1','attorneyReviewDtl'));

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            /*if(count($this->request->getData('answer'))>0){
                $data['answer'] = json_encode($data['answer']);
            }*/
        //echo "<pre>";print_r($data);echo "</pre>";exit;
            $review = $this->AttorneyReviews->patchEntity($review, $data);
            if ($review->getErrors()) {
                debug($review->getErrors()); // Show validation errors
                exit;
            }
            /*SIGN*/
            $RecId = $this->request->getData('RecIdSign');
            $signatureData = $this->request->getData('signature');

            if (!empty($signatureData)) {

                list($type, $data) = explode(';', $signatureData);
                list(, $data) = explode(',', $data);
                $decodedData = base64_decode($data);
                $signaturePath = WWW_ROOT . "files/signature_{$clientId}.png";
                file_put_contents($signaturePath, $decodedData);
            }
            
            if ($this->AttorneyReviews->save($review)) {
                /* $fullUrl = Router::url(['controller' => 'Reviews', 'action' => 'index', $id], true);

                $currentUserId = $this->currentUser->user_id;
                $FmdData = $this->FilesMainData->find()->where(['Id' => $id])->first();
                $this->PublicNotes->insertNewPublicNotes($id, $FmdData['TransactionType'], $currentUserId, "Review has been submitted by Attorney", 'Aol',true, "Aol Review Submission");

                $this->Flash->success(__('Your review has been submitted.'));
                return $this->redirect($fullUrl); */

                $currentUserId = $this->currentUser->user_id;
                $FmdData = $this->FilesMainData->find()->where(['Id' => $id])->first();
                $this->PublicNotes->insertNewPublicNotes($id, $FmdData['TransactionType'], $currentUserId, "Review has been submitted by Attorney", 'Aol',true, "Aol Review Submission");

                // Docusign Url
                $url = Router::url(['controller' => 'Reviews', 'action' => 'docusign', $id], true);
                $this->redirect($url);
            }
            //$this->Flash->error(__('Unable to submit your review.'));
        }

        //$docuSignPdfPath = 'https://google.com/';
        //$docuSignPdfPath = $this->docusign($id,$attorney_dtl);
        $this->set(compact('review','docuSignPdfPath'));
    }

    public function saveSignature() {
        
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $RecId = $this->request->getData('RecIdSign');

        // Return redirect URL as JSON
        $url = Router::url(['controller' => 'Reviews', 'action' => 'docusign', $RecId], true);

        return $this->response->withType('application/json')->withStringBody(json_encode([
            'redirect' => $url
        ]));
        
        if ($this->request->is('post')) {
            $RecId = $this->request->getData('RecIdSign');
            $signatureData = $this->request->getData('signature');

            if (!empty($signatureData)) {
                // Extract base64 image data
                list($type, $data) = explode(';', $signatureData);
                list(, $data) = explode(',', $data);
                $decodedData = base64_decode($data);

                // Save Signature Image
                $signaturePath = WWW_ROOT.'files'.DS.'signature'.DS.'aol'.DS.'signature_'.$RecId.'.png';

                file_put_contents($signaturePath, $decodedData);

                $pdfController = new PdfController();
                $pdfController->generatePdf($RecId, "final", true);
                $pdfController->generatePdf($RecId, "signature", true);

                $response = ['status' => 'success', 'message' => 'Signature saved successfully.'];
                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode($response));

            } else {
                $this->Flash->error(__('Signature is required.'));
            }
        }

        return $this->redirect(['controller' => 'Reviews', 'action' => 'index', $RecId]);
    }

    public function list(){
        // set page title
		$pageTitle = 'Attorney Reviews List';
        $this->set(compact('pageTitle'));

		$AttorneyReviews = $this->AttorneyReviews->newEmptyEntity();

		// step for datatable config : 3
		$this->set('dataJson',$this->CustomPagination->setDataJson($this->columns_alise,['Actions']));

		// step for datatable config : 4

		$isSearch = 0;
		$formpostdata = '';
		if ($this->request->is(['patch', 'post', 'put'])) {
			$formpostdata = $this->request->getData();
			$isSearch = 1;
		}
		$this->set('formpostdata', $formpostdata);
		//end step
		$this->set('isSearch', $isSearch);

		$this->set(compact('AttorneyReviews'));
    }

    public function ajaxListIndex(){
		$this->autoRender = false;
		$modelname = "AttorneyReviews";
		array_pop($this->columns_alise);

        $this->CustomPagination->setPaginationData(['request'=>$this->request->getData(),
                                                     'columns'=>$this->columnsorder,
                                                     'columnAlise'=>$this->columns_alise,
                                                     'modelName'=>$modelname
                                                   ]);

		$pdata = $this->CustomPagination->getQueryData();

		// Remove query limit for all records
		if($pdata['condition']['limit'] == -1){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']);
		} // END

		$query = $this->$modelname->find('search',$pdata['condition']);

		if($pdata['is_search'] === false){
		    $recordsTotal = $this->$modelname->find('all',['fields'=>['id']])->count();
		}else{
			unset($pdata['condition']['limit'], $pdata['condition']['offset']);
			$recordsTotal = $this->$modelname->find('all')->count();
		}

        $results = $query->disableHydration()->all();

        $data = $results->toArray();
		$data = $this->getParsingData($data);
        $i=0;
        foreach($data as $k=>$v){
            $fmd_data = $this->FilesMainData->find()->where(['Id' => $v['RecId']])->first();
            $data[$i]['RecId'] = $fmd_data->NATFileNumber;
            $i++;
        }
        //echo "<pre>";print_r($data);echo "</pre>";
        $response = array(
            "draw" => intval($pdata['draw']),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsTotal),
            "data" => $data
        );

		echo json_encode($response);
        exit;
    }

    private function getParsingData(array $data){
        $text = '';

        foreach ($data as $key => $value) {
            $fileUrl = Router::url('/files/export/aol_assignment/pdf/aol_signed/' . "AssignmentDetails-" . $value['RecId'] . ".pdf", true);

            //$data[$key]['Actions'] =  $this->CustomPagination->getActionButtons($this->name,$value,['RecId','Name']);
            $data[$key]['Actions'] .=  '<a href="'.Router::url(['controller' => 'reviews','action' => 'edit/'.$value['RecId']]).'" title="Edit" class="link-success fs-15"><i class="ri-edit-2-line"></i></a> ';
            $data[$key]['Actions'] .=  '<a download href="'.$fileUrl.'" title="Download Signed PDF" class="link-success fs-15"><i class="ri-file-pdf-line" aria-hidden="true"></i></a> ';;
        }
		return $data;
	}

    /*public function edit($id = null){
        $AttorneyReviews = $this->AttorneyReviews->get($id);
        $fmd_data = $this->FilesMainData->find()->where(['Id' => $id])->first();

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            // Set correct primary key field
            $data['RecId'] = $id;

            // Define upload directory
            $uploadPath = WWW_ROOT . 'uploads' . DS;

            // Ensure the uploads directory exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Handle file upload
            if (!empty($data['supporting_documentation']) && $data['supporting_documentation'] instanceof \Laminas\Diactoros\UploadedFile) {
                if ($data['supporting_documentation']->getClientFilename()) {
                    $file = $data['supporting_documentation'];
                    $fileName = time() . '_' . $file->getClientFilename();
                    $file->moveTo($uploadPath . $fileName);
                    $data['supporting_documentation'] = $fileName;
                }
            } else {
                // Retain existing file if no new file is uploaded
                unset($data['supporting_documentation']);
            }

            // Debugging output to verify patched entity
            //debug($data);

            $AttorneyReviews = $this->AttorneyReviews->patchEntity($AttorneyReviews, $data);

            // Check if entity contains modified data
            debug($AttorneyReviews);

            // Save the record
            if ($this->AttorneyReviews->save($AttorneyReviews)) {
                $this->Flash->success(__('The Attorney review has been updated.'));
                return $this->redirect(['action' => 'list']);
            }

            $this->Flash->error(__('Unable to update the review.'));
        }

        $this->set(compact('AttorneyReviews'));
        $this->set(compact('fmd_data'));
        $this->render('add');
    }*/

    public function edit($id = null){
        // Fetch the existing review record
        $AttorneyReviews = $this->AttorneyReviews->get($id);
        $fmd_data = $this->FilesMainData->find()->where(['Id' => $id])->first();
        $AttData = $this->FilesAttorneyAssignment->find()->where(['RecId' => $id])->first();
        $AolData = $this->FilesAolAssignment->find()->where(['RecId' => $id])->first();

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            // Set primary key
            $data['Id'] = $id;

            // Define upload directory
            $uploadPath = WWW_ROOT . 'uploads' . DS;

            // Ensure uploads directory exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Handle file upload properly
            if (
                isset($data['supporting_documentation']) &&
                $data['supporting_documentation'] instanceof \Laminas\Diactoros\UploadedFile
            ) {
                if ($data['supporting_documentation']->getClientFilename()) {
                    $file = $data['supporting_documentation'];
                    $fileName = time() . '_' . $file->getClientFilename();

                    try {
                        // Move the file
                        $file->moveTo($uploadPath . $fileName);

                        // Save only the filename as a string
                        $data['supporting_documentation'] = $fileName;
                    } catch (\Exception $e) {
                        $this->Flash->error(__('File upload failed: ' . $e->getMessage()));
                        return $this->redirect(['action' => 'edit', $id]);
                    }
                } else {
                    // If no file uploaded, keep existing file name
                    $data['supporting_documentation'] = $AttorneyReviews->supporting_documentation;
                }
            } else {
                // Keep the existing file name if no new file is uploaded
                unset($data['supporting_documentation']);
            }

            // Ensure RecId is included
            $data['RecId'] = $id;

            // Debugging: Check what data is being passed
            //debug($data);

            // Patch and save entity
            $AttorneyReviews = $this->AttorneyReviews->patchEntity($AttorneyReviews, $data);

            // Debugging: Check for validation errors
            if ($AttorneyReviews->getErrors()) {
                debug($AttorneyReviews->getErrors()); // Output validation errors
                $this->Flash->error(__('Validation failed! Please check the form inputs.'));
                return;
            }

            if ($this->AttorneyReviews->save($AttorneyReviews)) {
                $this->Flash->success(__('The Attorney review has been updated.'));
                return $this->redirect(['action' => 'list']);
            } else {
                $this->Flash->error(__('Unable to update the review.'));
            }
        }

        $this->set(compact('AttorneyReviews', 'fmd_data', 'AttData', 'AolData'));
        $this->render('add');
    }

    public function docusign_send()
    {
            /* $config = [
            'integration_key' => 'af2be383-ee06-4f01-a3e9-75bb60335f98',
            'user_id' => 'ee574ee2-9b74-47c7-b012-4f2b88aa7b9c',
            'rsa_key_path' => CONFIG . 'docusign/private.key',
            'base_uri' => 'https://demo.docusign.net/restapi',
            ];

            
            try {
                $privateKey = file_get_contents(CONFIG . 'docusign/private.key');
                if (!$privateKey) {
                    throw new \Exception('Private key not found');
                }

                // Double-check OpenSSL accepts it
                $check = openssl_pkey_get_private($privateKey);
                if (!$check) {
                    throw new \Exception('OpenSSL rejected key');
                }

                // Init API Client
                $apiClient = new ApiClient();
                $apiClient->getOAuth()->setOAuthBasePath('account-d.docusign.com');

                // Request JWT token
                $response = $apiClient->requestJWTUserToken(
                    $config['integration_key'],
                    $config['user_id'],
                    ['signature', 'impersonation'],
                    $privateKey,
                    3600
                );

                $accessToken = $response[0]->getAccessToken();
                echo "<h3>✅ Access Token:</h3><pre>" . h($accessToken) . "</pre>";
            } catch (\Exception $e) {
                echo "<h3>❌ Error:</h3><pre>" . h($e->getMessage()) . "</pre>";
            }

            exit; */

            /* $privateKey = file_get_contents(CONFIG . 'docusign/private.key');
        
            if (!$privateKey) {
                throw new \Exception('❌ Private key file not found or empty.');
            }

            $opensslKey = openssl_pkey_get_private($privateKey);
            if (!$opensslKey) {
                throw new \Exception('❌ OpenSSL rejected the private key. Format may be invalid.');
            }

            echo '✅ Private key loaded and OpenSSL accepted it.'; */

            $integrationKey = '515b1714-f1ea-4354-b28c-dee577f78c56'; // your Integration Key
            $userId = 'ee574ee2-9b74-47c7-b012-4f2b88aa7b9c';          // your User ID (GUID)
            $privateKeyPath = CONFIG . 'docusign/private.key';
            
            $privateKey = trim(file_get_contents($privateKeyPath));
            // Normalize line endings
            $privateKey = str_replace(["\r\n", "\r"], "\n", $privateKey);

            // Fix encoding (some WAMP setups mess up encoding)
            $privateKey = utf8_encode($privateKey);
            $keyResource = openssl_pkey_get_private($privateKey);

            if (!$keyResource) {
                echo "❌ openssl_pkey_get_private() failed.";
                return;
            }

            echo "✅ OpenSSL accepted key as resource. Now trying to get token...\n";

            $apiClient = new ApiClient();
            $apiClient->getOAuth()->setOAuthBasePath('account-d.docusign.com');

            try {
                /* $response = $apiClient->requestJWTUserToken(
                    $integrationKey,
                    $userId,
                    ['signature', 'impersonation'],
                    $keyResource,
                    3600
                ); */

                $response = $apiClient->requestJWTUserToken(
                    $integrationKey, // integration key
                    $userId, // user ID
                    $privateKey,                            // ✅ correct: private key is 3rd
                    ['signature','impersonation'],         // ✅ scope array (4th arg)
                    3600                                    // optional expiration
                );

                echo "<pre>✅ Access Token: " . $response[0]->getAccessToken() . "</pre>";
            } catch (\Exception $e) {
                echo "<pre>❌ Error:\n" . $e->getMessage() . "</pre>";
            }
             /* $privateKey = trim(file_get_contents($privateKeyPath));
            if (!$privateKey) {
                echo '❌ Key not found or empty.';
                return;
            }

            $opensslKey = openssl_pkey_get_private($privateKey);
            if (!$opensslKey) {
                echo '❌ OpenSSL rejected key. Format may be invalid.';
                return;
            }

            echo "✅ OpenSSL accepted key. Trying to get token...\n";

            $apiClient = new ApiClient();
            $apiClient->getOAuth()->setOAuthBasePath('account-d.docusign.com');

            try {
                $response = $apiClient->requestJWTUserToken(
                    $integrationKey,
                    $userId,
                    ['signature', 'impersonation'],
                    $privateKey,
                    3600
                );

                echo "<pre>✅ Access Token: " . $response[0]->getAccessToken() . "</pre>";
            } catch (\Exception $e) {
                echo "<pre>❌ Error:\n" . $e->getMessage() . "</pre>";
            } */

            exit;
    }
    
    // Send the generated PDF for signature
    public function docusign($aolId = null,$attorney_dtl=[])
    {

        $attorney = $this->FilesAttorneyAssignment->find()->where(['RecId' => $aolId])->first(); 
        $attorney_dtl = [];
        if(!empty($attorney)){
            $attorney_dtl = $this->Vendors->find()->where(['Id' => $attorney['vendorid']])->first(); 
        }

        // Load configuration
        $config = [
            'integration_key' => '515b1714-f1ea-4354-b28c-dee577f78c56',
            'user_id' => 'ee574ee2-9b74-47c7-b012-4f2b88aa7b9c',
            'rsa_key_path' => CONFIG . 'docusign/private.key',
            'account_id' => 'baaa357b-cf8e-4418-98ca-ff5a95be8df5',
            'base_uri' => 'https://demo.docusign.net/restapi',
            //'redirect_uri' => 'http://localhost/nat/reviews/callback',
            'redirect_uri' => 'https://nat.tiuconsulting.us/reviews/callback',
        ];

        $privateKey = file_get_contents($config['rsa_key_path']);

        $apiClient = new ApiClient();
        $apiClient->getOAuth()->setOAuthBasePath('account-d.docusign.com');

        // Authenticate using JWT
        $response = $apiClient->requestJWTUserToken(
            $config['integration_key'],
            $config['user_id'],
            $privateKey,
            ['signature'],
            3600
        );
              
        $accessToken = $response[0]->getAccessToken();

        // Set access token
        $apiClient->getConfig()->setHost($config['base_uri']);
        $apiClient->getConfig()->addDefaultHeader('Authorization', "Bearer {$accessToken}");

        // Load your AOL PDF file (adjust path as per your app)
        //$filePath = WWW_ROOT . "files/aol/aol_{$aolId}.pdf";
        //$filePath = WWW_ROOT . "files/export/aol_assignment/pdf/pre/AssignmentDetails-718.pdf";
        $filePath = WWW_ROOT . "files/export/aol_assignment/pdf/final/AssignmentDetails-".$aolId.".pdf";

        if (!file_exists($filePath)) {
            $this->Flash->error("PDF file not found.");
            return $this->redirect(['action' => 'index']);
        }

        $fileContent = file_get_contents($filePath);
        $base64File = base64_encode($fileContent);

        // Create the DocuSign Document
        $document = new Document([
            'document_base64' => $base64File,
            'name' => "AOL Document - #{$aolId}",
            'file_extension' => 'pdf',
            'document_id' => 1,
        ]);

        // Create Signer (replace email/name dynamically if needed)
        $signer = new Signer([
            'email' => $attorney_dtl['main_contact_email'],
            'name' => $attorney_dtl['name'],
            'recipient_id' => $attorney_dtl['id'],
            'routing_order' => '1',
            'client_user_id' => $attorney_dtl['id'], // For embedded signing
        ]);

        // Signature placement using anchor
        /* $signHere = new SignHere([
            'anchor_string' => '/sign_here/',
            'anchor_units' => 'pixels',
            'anchor_x_offset' => '0',
            'anchor_y_offset' => '0',
        ]); */

        $signHereTabs = [];

        /**
         * Dynamic Page Count
         */
        $parser = new Parser();
        $pdf = $parser->parseFile($filePath);
        $pageCount = count($pdf->getPages());

        for ($i = 1; $i <= $pageCount; $i++) {
            $signHereTabs[] = new SignHere([
                'document_id' => '1',
                'page_number' => "$i",
                'recipient_id' => '2',
                'x_position' => '450', // adjust as needed
                'y_position' => '750', // adjust as needed
            ]);
        }

        //$tabs = new Tabs(['sign_here_tabs' => [$signHere]]);
        $tabs = new Tabs([
            'sign_here_tabs' => $signHereTabs
        ]);
        $signer->setTabs($tabs);
        $recipients = new Recipients(['signers' => [$signer]]);

        // Create the Envelope
        $envelope = new EnvelopeDefinition([
            'email_subject' => 'Please sign the AOL document',
            'documents' => [$document],
            'recipients' => $recipients,
            'status' => 'sent', // Or 'created' for draft
        ]);

        // Send the Envelope
        $envelopeApi = new EnvelopesApi($apiClient);
        $envelopeSummary = $envelopeApi->createEnvelope($config['account_id'], $envelope);

        $envelopeId = $envelopeSummary->getEnvelopeId();

        // Create embedded signing view
        $recipientViewRequest = new RecipientViewRequest([
            'authentication_method' => 'none',
            'client_user_id' => $attorney_dtl['id'],
            'recipient_id' => $attorney_dtl['id'],
            //'return_url' => 'http://localhost/nat/reviews/callback?envelopeId='.$envelopeId.'&aolId='.$aolId,
            'return_url' => 'https://nat.tiuconsulting.us/reviews/callback?envelopeId='.$envelopeId.'&aolId='.$aolId,
            'user_name' => $attorney_dtl['name'],
            'email' => $attorney_dtl['main_contact_email'],
            'ui_options' => [
                'hide_tabs' => true,
                'hide_toolbar' => true,
            ],
            'signing_ui_version' => '1.0',
        ]);

        /* $uiOptions = [
            'hide_tabs' => true,         // Hide "Other Actions" tab options
            'hide_toolbar' => true,      // Hide top bar and 3-dot menu
        ]; */
        /*$recipientViewRequest = new RecipientViewRequest([
            'authentication_method' => 'none',
            'client_user_id' => $attorney_dtl['id'],
            'recipient_id' => $attorney_dtl['id'],
            'return_url' => 'http://localhost/nat/reviews/callback?envelopeId=' . $envelopeId . '&aolId=' . $aolId,
            'user_name' => $attorney_dtl['name'],
            'email' => $attorney_dtl['main_contact_email'],
            'ui_options' => [
                'hide_tabs' => true,
                'hide_toolbar' => true,
            ],
            'signing_ui_version' => '1.0',
            //'ping_url' => 'http://localhost/nat/ping', // optional, keep user session alive
            //'ping_frequency' => 600, // in seconds
        ]);*/

        // For embedded signing
        $signingView = $envelopeApi->createRecipientView($config['account_id'], $envelopeId, $recipientViewRequest);

        $signingUrl = $signingView->getUrl(); // <-- you embed this

        // Redirect to DocuSign signing URL
        return $this->redirect($signingView->getUrl());

        ///return $signingUrl;
    }

    // After signing, redirect comes here
    /* public function callback()
    {
        $envelopeId = $this->request->getQuery('envelopeId');
        $this->Flash->success("Document signed successfully. Envelope ID: " . h($envelopeId));
        return $this->redirect(['controller' => 'Aol', 'action' => 'index']);
    } */

    public function callback($aolId=null)
    {
        $envelopeId = $this->request->getQuery('envelopeId');
        $aolId = $this->request->getQuery('aolId');

        if (!$envelopeId) {
            $this->Flash->error("No envelope ID found.");
            return $this->redirect(['controller' => 'Reviews', 'action' => 'index', $aolId]);
        }

        // Step 1: DocuSign Config
        $config = [
            'integration_key' => '515b1714-f1ea-4354-b28c-dee577f78c56',
            'user_id' => 'ee574ee2-9b74-47c7-b012-4f2b88aa7b9c',
            'rsa_key_path' => CONFIG . 'docusign/private.key',
            'account_id' => 'baaa357b-cf8e-4418-98ca-ff5a95be8df5',
            'base_uri' => 'https://demo.docusign.net/restapi',
            'auth_server' => 'account-d.docusign.com', // required for demo env
        ];

        // Step 2: Generate Access Token (JWT Flow)
        $privateKey = file_get_contents($config['rsa_key_path']);
        $scopes = ['signature', 'impersonation'];

        $apiClient = new ApiClient();
        $apiClient->getOAuth()->setOAuthBasePath($config['auth_server']);

        try {
            $response = $apiClient->requestJWTUserToken(
                $config['integration_key'],
                $config['user_id'],
                $privateKey,
                $scopes,
                3600
            );
        } catch (ApiException $e) {
            $this->Flash->error("JWT Token error: " . $e->getMessage());
            return $this->redirect(['controller' => 'Reviews', 'action' => 'index', $aolId]);
        }

        $accessToken = $response[0]->getAccessToken();

        // Step 3: Configure API Client with Auth Token
        $configObj = new Configuration();
        $configObj->setHost($config['base_uri']);
        $configObj->addDefaultHeader("Authorization", "Bearer " . $accessToken);

        $apiClient = new ApiClient($configObj);

        $envelopeApi = new EnvelopesApi($apiClient);

        try {
            // Fetch the signed document (documentId = 'combined' gives merged final PDF)
            //$pdfContents = $envelopeApi->getDocument($config['account_id'], 'combined', $envelopeId);

            // Save to local file system
            //$filePath = WWW_ROOT . 'docs' . DS . 'signed_' . $envelopeId . '.pdf';
            $pdf_folder = "aol_signed";
            $filePath = WWW_ROOT . 'files' . DS . 'export' . DS . 'aol_assignment' . DS . 'pdf' . DS . $pdf_folder . DS . "AssignmentDetails-$aolId.pdf";

            //file_put_contents($filePath, $pdfContents);
            $response = $envelopeApi->getDocument($config['account_id'], 'combined', $envelopeId);
            $pdfContents = file_get_contents($response->getRealPath()); // ✅ Properly reads stream
            file_put_contents($filePath, $pdfContents);

            $pdf_folder = "final";
            $filePath_2 = WWW_ROOT . 'files' . DS . 'export' . DS . 'aol_assignment' . DS . 'pdf' . DS . $pdf_folder . DS . "AssignmentDetails-$aolId.pdf";
            file_put_contents($filePath_2, $pdfContents);


            //$this->Flash->success("✅ Document signed. Envelope ID: " . h($envelopeId));
            //$this->Flash->success("📄 Signed PDF saved to: " . $filePath);

            /**
             * Update AttorneyReviews table "is_signature_added" column
             */
            $entity = $this->AttorneyReviews->find()->where(['RecId' => $aolId])->first();
            if ($entity) {
                $entity->is_signature_added = 'Yes'; 
                $this->AttorneyReviews->save($entity); // Save the updated entity
            }

            $this->Flash->success("The signature has been successfully added, and the AOL PDF has been updated.");
        } catch (ApiException $e) {
            $this->Flash->error("❌ Failed to download signed PDF: " . $e->getMessage());
        }

        return $this->redirect(['controller' => 'Reviews', 'action' => 'index', $aolId]);
    }
} 
?>