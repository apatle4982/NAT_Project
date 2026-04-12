<?php
declare(strict_types=1);

namespace App\Service;

use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;

/**
 * DataTraceService
 *
 * Handles all communication with the DataTrace external API.
 * Builds payload from files_main_data fields, submits the order,
 * and persists the response into datatrace_api_logs.
 */
class DataTraceService
{
    private string $apiUrl;
    private string $apiKey;
    private bool   $mockMode;

    public function __construct()
    {
        $this->apiUrl    = Configure::read('DataTrace.apiUrl', 'https://api.datatrace.com/v1/orders');
        $this->apiKey    = Configure::read('DataTrace.apiKey', '');
        $this->mockMode  = (bool) Configure::read('DataTrace.mockMode', false);
    }

    /**
     * Submit a single order to the DataTrace API.
     * Returns a mock response when DataTrace.mockMode = true in config.
     *
     * @param array $orderData  Row from files_main_data (as array).
     * @return array ['success' => bool, 'data' => array|null, 'error' => string|null]
     */
    public function submitOrder(array $orderData): array
    {
        $payload = $this->buildPayload($orderData);

        Log::info(
            'DataTrace submitOrder — RecId: ' . ($orderData['Id'] ?? 'N/A') .
            ', PartnerFileNumber: ' . ($orderData['PartnerFileNumber'] ?? 'N/A') .
            ($this->mockMode ? ' [MOCK MODE]' : ''),
            ['scope' => 'datatrace']
        );

        // Return a mock response without hitting the real API
        if ($this->mockMode) {
            $mockResponse = $this->buildMockResponse($orderData);
            Log::info(
                'DataTrace mock response — examReceiptId: ' . $mockResponse['examReceiptId'],
                ['scope' => 'datatrace']
            );
            return ['success' => true, 'data' => $mockResponse, 'error' => null];
        }

        // Live API call
        try {
            $http = new Client();
            $response = $http->post(
                $this->apiUrl,
                json_encode($payload),
                [
                    'type'    => 'json',
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey,
                        'Content-Type'  => 'application/json',
                        'Accept'        => 'application/json',
                    ],
                ]
            );

            if ($response->isOk()) {
                $body = $response->getJson();
                Log::info(
                    'DataTrace success — examReceiptId: ' . ($body['examReceiptId'] ?? 'N/A'),
                    ['scope' => 'datatrace']
                );
                return ['success' => true, 'data' => $body, 'error' => null];
            }

            $errorMsg = 'DataTrace API returned HTTP ' . $response->getStatusCode()
                      . ': ' . $response->getStringBody();
            Log::error($errorMsg, ['scope' => 'datatrace']);
            return ['success' => false, 'data' => null, 'error' => $errorMsg];

        } catch (\Exception $e) {
            Log::error('DataTrace exception: ' . $e->getMessage(), ['scope' => 'datatrace']);
            return ['success' => false, 'data' => null, 'error' => $e->getMessage()];
        }
    }

    /**
     * Map NAT files_main_data fields to the DataTrace request payload.
     *
     * @param array $orderData
     * @return array
     */
    private function buildPayload(array $orderData): array
    {
        return [
            'partnerFileNumber'  => $orderData['PartnerFileNumber'] ?? '',
            'transactionType'    => $orderData['TransactionType']   ?? '',
            'loanAmount'         => $orderData['LoanAmount']        ?? '',
            'purchasePrice'      => $orderData['PurchasePriceConsideration'] ?? '',
            'loanNumber'         => $orderData['LoanNumber']        ?? '',
            'apnParcelNumber'    => $orderData['APNParcelNumber']   ?? '',
            'propertyAddress'    => [
                'streetNumber' => $orderData['StreetNumber'] ?? '',
                'streetName'   => $orderData['StreetName']   ?? '',
                'city'         => $orderData['City']         ?? '',
                'state'        => $orderData['State']        ?? '',
                'county'       => $orderData['County']       ?? '',
                'zip'          => $orderData['Zip']          ?? '',
            ],
            'grantor' => [
                'type'      => $orderData['Grantors']          ?? '',
                'firstName' => $orderData['GrantorFirstName1'] ?? '',
                'lastName'  => $orderData['GrantorLastName1']  ?? '',
            ],
            'grantee' => [
                'type'      => $orderData['Grantees']          ?? '',
                'firstName' => $orderData['GranteeFirstName1'] ?? '',
                'lastName'  => $orderData['GranteeLastName1']  ?? '',
            ],
            'mortgagor' => [
                'type'      => $orderData['MortgagorGrantors']              ?? '',
                'firstName' => $orderData['MortgagorGrantorFirstName1']     ?? '',
                'lastName'  => $orderData['MortgagorGrantorLastName1']      ?? '',
            ],
            'mortgagee' => [
                'companyName' => $orderData['MortgageeLenderCompanyName'] ?? '',
                'firstName'   => $orderData['MortgageeFirstName1']        ?? '',
                'lastName'    => $orderData['MortgageeLastName1']         ?? '',
            ],
        ];
    }

    /**
     * Build a realistic mock exam receipt response using actual order data.
     * All fields match what a real DataTrace title examination would return.
     *
     * @param array $orderData  Row from files_main_data (as array).
     * @return array
     */
    private function buildMockResponse(array $orderData): array
    {
        $examId       = 'DT-' . strtoupper(substr(md5(uniqid('', true)), 0, 9));
        $submittedAt  = date('Y-m-d H:i:s');
        $searchToDate = date('Y-m-d');

        // Use real order data where available
        $streetNum    = trim($orderData['StreetNumber']    ?? '');
        $streetName   = trim($orderData['StreetName']      ?? '');
        $city         = trim($orderData['City']            ?? '');
        $state        = trim($orderData['State']           ?? '');
        $county       = trim($orderData['County']          ?? '');
        $zip          = trim($orderData['Zip']             ?? '');
        $apn          = trim($orderData['APNParcelNumber'] ?? '');
        $loanAmount   = trim($orderData['LoanAmount']      ?? '0');
        $lenderName   = trim($orderData['MortgageeLenderCompanyName'] ?? 'Unknown Lender');
        $grantorFirst = trim($orderData['GrantorFirstName1'] ?? '');
        $grantorLast  = trim($orderData['GrantorLastName1']  ?? '');
        $granteeFirst = trim($orderData['GranteeFirstName1'] ?? '');
        $granteeLast  = trim($orderData['GranteeLastName1']  ?? '');
        $currentOwner = trim($grantorFirst . ' ' . $grantorLast) ?: 'Current Owner';
        $newOwner     = trim($granteeFirst . ' ' . $granteeLast) ?: 'New Owner';
        $fullAddress  = trim($streetNum . ' ' . $streetName . ', ' . $city . ', ' . $state . ' ' . $zip);

        $formattedLoan = '$' . number_format((float) str_replace([',','$'], '', $loanAmount), 2);

        // Realistic acquisition and recording dates (simulate prior transaction)
        $acqYear   = (int)date('Y') - rand(4, 8);
        $acqDate   = $acqYear . '-' . str_pad((string)rand(1,12), 2, '0', STR_PAD_LEFT) . '-' . str_pad((string)rand(1,28), 2, '0', STR_PAD_LEFT);
        $recDate   = date('Y-m-d', strtotime($acqDate . ' +1 day'));
        $matDate   = ((int)date('Y') + 30) . '-' . substr($acqDate, 5, 2) . '-01';
        $instNum   = date('Y', strtotime($acqDate)) . '-' . str_pad((string)rand(10000,99999), 5, '0', STR_PAD_LEFT);
        $deedBook  = (string) rand(3800, 5200);
        $deedPage  = (string) rand(100, 450);
        $mtgBook   = (string) rand(2000, 2800);
        $mtgPage   = (string) rand(300, 600);
        $taxAmt    = '$' . number_format(rand(2100, 6800), 2);
        $halfTax   = '$' . number_format(rand(1050, 3400), 2);
        $nextTax   = ((int)date('Y') + 1) . '-06-30';

        // Fabricate 3-step chain of title (current owner + 2 prior)
        $prevAcqYear = $acqYear - rand(5,9);
        $prevAcqDate = $prevAcqYear . '-' . str_pad((string)rand(1,12), 2, '0', STR_PAD_LEFT) . '-' . str_pad((string)rand(1,28), 2, '0', STR_PAD_LEFT);
        $prev2AcqYear = $prevAcqYear - rand(4,7);
        $prev2AcqDate = $prev2AcqYear . '-' . str_pad((string)rand(1,12), 2, '0', STR_PAD_LEFT) . '-' . str_pad((string)rand(1,28), 2, '0', STR_PAD_LEFT);

        return [
            // ── Header ────────────────────────────────────────────────────────
            'examReceiptId'  => $examId,
            'status'         => 'success',
            'message'        => 'Title examination completed successfully',
            'eta'            => '24-48 hours',
            'submittedAt'    => $submittedAt,
            'examiner'       => 'DataTrace Title Services, LLC',
            'partnerFileNo'  => $orderData['PartnerFileNumber'] ?? 'N/A',
            'natFileNo'      => $orderData['NATFileNumber']     ?? 'N/A',

            // ── Property Information ───────────────────────────────────────────
            'property' => [
                'fullAddress'      => $fullAddress,
                'streetNumber'     => $streetNum,
                'streetName'       => $streetName,
                'city'             => $city,
                'state'            => $state,
                'county'           => $county . ' County',
                'zip'              => $zip,
                'apn'              => $apn,
                'legalDescription' => 'LOT 14, BLOCK 3, ' . strtoupper($streetName) . ' ESTATES SUBDIVISION, PLAT VOL 22 PG 14, ' . strtoupper($county) . ' COUNTY, ' . strtoupper($state),
                'propertyType'     => 'Single Family Residential',
                'lotSize'          => rand(18, 75) . ',' . rand(100, 900) . ' Sq Ft',
                'yearBuilt'        => (string) rand(1978, 2010),
            ],

            // ── Title Search Scope ─────────────────────────────────────────────
            'titleSearch' => [
                'searchPeriod' => '60 Years',
                'searchFrom'   => ((int)date('Y') - 60) . '-01-01',
                'searchTo'     => $searchToDate,
                'county'       => $county . ' County, ' . $state,
                'examDate'     => $submittedAt,
            ],

            // ── Vesting / Current Ownership ───────────────────────────────────
            'vesting' => [
                'currentOwner'    => $currentOwner,
                'ownershipType'   => 'Fee Simple Absolute',
                'acquisitionDate' => $acqDate,
                'recordedDate'    => $recDate,
                'deedType'        => 'General Warranty Deed',
                'deedBook'        => $deedBook,
                'deedPage'        => $deedPage,
                'instrumentNo'    => $instNum,
                'grantedTo'       => $newOwner,
                'consideration'   => '$' . number_format(rand(150000, 750000), 2),
            ],

            // ── Open Mortgages / Deeds of Trust ───────────────────────────────
            'mortgages' => [
                [
                    'index'          => 1,
                    'lenderName'     => $lenderName,
                    'borrower'       => $currentOwner,
                    'originalAmount' => $formattedLoan,
                    'dateExecuted'   => $acqDate,
                    'dateRecorded'   => $recDate,
                    'book'           => $mtgBook,
                    'page'           => $mtgPage,
                    'instrumentNo'   => $instNum,
                    'status'         => 'Open / Unreleased',
                    'maturityDate'   => $matDate,
                    'type'           => 'Conventional Mortgage',
                ],
            ],

            // ── Judgment Search ────────────────────────────────────────────────
            'judgments' => [
                'status'          => 'Clear — No Open Judgments Found',
                'searchedAgainst' => [$currentOwner, $grantorLast . ', ' . $grantorFirst],
                'records'         => [],
            ],

            // ── Property Tax Status ────────────────────────────────────────────
            'taxes' => [
                'parcelNumber'       => $apn,
                'taxingAuthority'    => $county . ' County Treasurer',
                'taxYear'            => date('Y'),
                'status'             => 'Current — Paid in Full',
                'annualAmount'       => $taxAmt,
                'firstInstallment'   => $halfTax,
                'secondInstallment'  => $halfTax,
                'nextDueDate'        => $nextTax,
                'specialAssessments' => 'None Found',
            ],

            // ── Liens ──────────────────────────────────────────────────────────
            'liens' => [
                'status'  => 'Clear — No Open Liens Found',
                'records' => [],
            ],

            // ── Easements & Encumbrances ───────────────────────────────────────
            'encumbrances' => [
                [
                    'type'        => 'Utility Easement',
                    'description' => '10-foot utility easement along the rear property line per Plat Book 22, Page 14',
                    'grantee'     => strtoupper($county) . ' COUNTY ELECTRIC COOPERATIVE',
                    'book'        => (string)((int)$deedBook - rand(500, 1200)),
                    'page'        => (string)rand(15, 45),
                ],
                [
                    'type'        => 'Building Setback Line',
                    'description' => '25-foot front setback, 10-foot side setback per subdivision restrictions',
                    'grantee'     => 'N/A — Plat Restriction',
                    'book'        => 'Plat Vol 22',
                    'page'        => 'Page 14',
                ],
            ],

            // ── Standard Exceptions ───────────────────────────────────────────
            'standardExceptions' => [
                'Rights of parties in possession not shown by public records',
                'Facts a correct survey and inspection of the premises would disclose',
                'Easements or claims of easements not shown by public records',
                'Any lien or right to a lien for services, labor, or material not shown by public records',
                'Discrepancies, conflicts in boundary lines, shortage in area, or encroachments',
                'Taxes or special assessments not shown as existing liens by public records',
            ],

            // ── Chain of Title (last 3 conveyances) ───────────────────────────
            'chainOfTitle' => [
                [
                    'grantor'       => 'Robert A. & Mary L. Johnson',
                    'grantee'       => $currentOwner,
                    'date'          => $acqDate,
                    'type'          => 'General Warranty Deed',
                    'consideration' => '$' . number_format(rand(180000, 480000), 2),
                    'book'          => $deedBook,
                    'page'          => $deedPage,
                ],
                [
                    'grantor'       => strtoupper($county) . ' COUNTY LAND TRUST',
                    'grantee'       => 'Robert A. & Mary L. Johnson',
                    'date'          => $prevAcqDate,
                    'type'          => "Trustee's Deed",
                    'consideration' => '$' . number_format(rand(95000, 220000), 2),
                    'book'          => (string)((int)$deedBook - rand(200,600)),
                    'page'          => (string)rand(50, 200),
                ],
                [
                    'grantor'       => 'FIRST NATIONAL PROPERTIES CORP.',
                    'grantee'       => strtoupper($county) . ' COUNTY LAND TRUST',
                    'date'          => $prev2AcqDate,
                    'type'          => 'Quit Claim Deed',
                    'consideration' => '$0 (Love and Affection)',
                    'book'          => (string)((int)$deedBook - rand(800,1500)),
                    'page'          => (string)rand(10, 80),
                ],
            ],
        ];
    }

    /**
     * Persist a DataTrace API call log to datatrace_api_logs table.
     *
     * @param array $logData
     * @return bool
     */
    public function saveLog(array $logData): bool
    {
        try {
            $table  = TableRegistry::getTableLocator()->get('DatatraceApiLogs');
            $entity = $table->newEmptyEntity();
            $entity = $table->patchEntity($entity, $logData);
            return (bool) $table->save($entity);
        } catch (\Exception $e) {
            Log::error('DataTrace saveLog failed: ' . $e->getMessage(), ['scope' => 'datatrace']);
            return false;
        }
    }
}
