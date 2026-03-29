<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Datasource\Exception\RecordNotFoundException;
use App\Controller\PdfController;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;

class NatApiController extends AppController
{
    private $jwtSecret = 'NLPS59003PYO'; // Replace with secure key
    public $setmaxLRSno='';
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel("FilesMainData");
	   $this->loadModel("CompanyFieldsMap");
	   $this->loadModel("CompanyMst");
	   $this->loadModel('CompanyExportFields');
	   $this->loadModel("DocumentTypeMst");
	   $this->loadModel('CountyMst');
	   $this->loadModel('FilesQcData');
	   $this->loadModel('PublicNotes');
	   $this->loadModel('States');
	   $this->loadModel('FilesVendorAssignment');
	   $this->loadModel('FilesAolAssignment');
	   $this->loadModel('FilesAttorneyAssignment');
	   $this->loadModel('FilesEscrowAssignment');
	   $this->loadModel("TransactionTypeMst");
	   $this->loadComponent('GeneratePDF');
       $this->loadComponent('RequestHandler');
       $this->loadModel('CompanyImportFields');
       $this->loadModel('CompanyApiKeys');
    }

    // Common method to verify token and allow access
    private function verifyJwtToken()
    {
        $authHeader = $this->request->getHeaderLine('Authorization');

        /**
         * Custom verify API Key Start Code
         */
        $authHeader = str_replace('Bearer ','',$authHeader);
        $partner_key_data = $this->CompanyApiKeys->find()->where(['secret_key' => $authHeader,'is_active'=>'1'])->first();

        if($partner_key_data->secret_key !== $authHeader){
            return false;
        }
        else{
            return true;
        }
        /**
         * End Custom verify API Key Code
         */

        /* if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            //throw new \Cake\Http\Exception\UnauthorizedException('Token not provided.');
            return false;
        }

        try {
            $decoded = \Firebase\JWT\JWT::decode($matches[1], new \Firebase\JWT\Key($this->jwtSecret, 'HS256'));
            return true;
            // You can access $decoded->sub if needed
        } catch (\Exception $e) {
            //throw new \Cake\Http\Exception\UnauthorizedException('Token is invalid or expired.');
            return false;
        } */
    }

    // GET /api/getPreAol (Get Preliminary AOL Downloadlink)
    public function getPreAol($PartnerFileNumber=null)
    {
        $this->request->allowMethod(['get']);
        $this->RequestHandler->renderAs($this, 'json');
        $this->viewBuilder()->setClassName('Json');

        if (! $this->verifyJwtToken()) {
            // 1a) Invalid token → set 401 headers and JSON payload
            $this->response = $this->response->withStatus(401);

            $this->set([
                'status'  => false,
                'error'   => 'Unauthorized',
                'message' => 'Token is invalid or in-active',
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','error','message']);
            // 1b) Stop further processing and return JSON
            return;
        }

        if (!$PartnerFileNumber || $PartnerFileNumber == '') {

            $this->set([
                'status' => "failed",
                'document_type' => "preliminary",
                'message' => "Missing required field: PartnerFileNumber",
                '_serialize' => ['status', 'data']
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','document_type','message']);
            return;
        }

        $aol_data = $this->FilesMainData->find()->where(['PartnerFileNumber' => $PartnerFileNumber])->first();

        if (!$aol_data->Id) {

            $this->set([
                'status' => "failed",
                'document_type' => "preliminary",
                'message' => "No record found, Please try again with another PartnerFileNumber",
                '_serialize' => ['status', 'data']
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','document_type','message']);
            return;
        } 
        $aloAssignmentData = $this->FilesAolAssignment->find()->where(['RecId' => $aol_data->Id])->first();
        $request = new ServerRequest();
        $pdfController = new PdfController($request);

        if($aloAssignmentData->pre_aol_status == 'Y'){
            $pdfPath = $pdfController->generateApiPdf($aol_data->Id, "pre");

            $this->set([
                'status' => "success",
                'document_type' => "preliminary",
                'download_url' => $pdfPath,
                "generated_at" => $aloAssignmentData->pre_aol_date,
                '_serialize' => ['status', 'data']
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','document_type','download_url','generated_at']);
        }
        else{
            $this->set([
                'status' => "pending",
                'document_type' => "preliminary",
                'message' => "Preliminary AOL is pending.",
                '_serialize' => ['status', 'data']
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','document_type','message']);
        }
    }
    // GET /api/getFinalAol (Get Final AOL Downloadlink)
    public function getFinalAol_Only_Final($PartnerFileNumber=null)
    {
        $this->request->allowMethod(['get']);
        $this->RequestHandler->renderAs($this, 'json');
        $this->viewBuilder()->setClassName('Json');

        if (! $this->verifyJwtToken()) {
            // 1a) Invalid token → set 401 headers and JSON payload
            $this->response = $this->response->withStatus(401);

            $this->set([
                'status'  => false,
                'error'   => 'Unauthorized',
                'message' => 'Token is invalid or expired',
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','error','message']);

            // 1b) Stop further processing and return JSON
            return;
        }

        if (!$PartnerFileNumber || $PartnerFileNumber == '') {

            $this->set([
                'status' => "failed",
                'document_type' => "final",
                'message' => "Missing required field: PartnerFileNumber",
                '_serialize' => ['status', 'data']
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','document_type','message']);
            return;
        }

        $aol_data = $this->FilesMainData->find()->where(['PartnerFileNumber' => $PartnerFileNumber])->first();

        if (!$aol_data->Id) {

            $this->set([
                'status' => "failed",
                'document_type' => "final",
                'message' => "No record found",
                '_serialize' => ['status', 'data']
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','document_type','message']);

            return;
        } 
        $aloAssignmentData = $this->FilesAolAssignment->find()->where(['RecId' => $aol_data->Id])->first();
        $request = new ServerRequest();
        $pdfController = new PdfController($request);

        if($aloAssignmentData->final_aol_status == 'Y'){
            $pdfPath = $pdfController->generateApiPdf($aol_data->Id, "final");

            $this->set([
                'status' => "success",
                'document_type' => "final",
                'download_url' => $pdfPath,
                "generated_at" => $aloAssignmentData->pre_aol_date,
                '_serialize' => ['status', 'data']
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','document_type','download_url','generated_at']);
        }
        else{
            $this->set([
                'status' => "pending",
                'document_type' => "final",
                'message' => "Final AOL is pending.",
                '_serialize' => ['status', 'data']
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','document_type','message']);
        }
    }
    // GET /api/getSignedAol (Get Final AOL Downloadlink)
    public function getFinalAol($PartnerFileNumber=null)
    {
        $this->request->allowMethod(['get']);
        $this->RequestHandler->renderAs($this, 'json');
        $this->viewBuilder()->setClassName('Json');

        if (! $this->verifyJwtToken()) {
            // 1a) Invalid token → set 401 headers and JSON payload
            $this->response = $this->response->withStatus(401);

            $this->set([
                'status'  => false,
                'error'   => 'Unauthorized',
                'message' => 'Token is invalid or expired',
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','error','message']);

            // 1b) Stop further processing and return JSON
            return;
        }

        if (!$PartnerFileNumber || $PartnerFileNumber == '') {

            $this->set([
                'status' => "failed",
                'document_type' => "signed aol",
                'message' => "Missing required field: PartnerFileNumber",
                '_serialize' => ['status', 'data']
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','document_type','message']);
            return;
        }

        $aol_data = $this->FilesMainData->find()->where(['PartnerFileNumber' => $PartnerFileNumber])->first();

        if (!$aol_data->Id) {

            $this->set([
                'status' => "failed",
                'document_type' => "signed aol",
                'message' => "No record found",
                '_serialize' => ['status', 'data']
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','document_type','message']);

            return;
        } 
        $aloAssignmentData = $this->FilesAolAssignment->find()->where(['RecId' => $aol_data->Id])->first();
        $request = new ServerRequest();
        $pdfController = new PdfController($request);

        if($aloAssignmentData->submit_aol_status == 'Y'){
            $fileUrl = Router::url('/files/export/aol_assignment/pdf/aol_signed/' . "AssignmentDetails-" . $aol_data->Id . ".pdf", true);
            
            $this->set([
                'status' => "success",
                'document_type' => "signed aol",
                'download_url' => $fileUrl,
                "generated_at" => $aloAssignmentData->pre_aol_date,
                '_serialize' => ['status', 'data']
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','document_type','download_url','generated_at']);
        }
        else{
            $this->set([
                'status' => "pending",
                'document_type' => "signed aol",
                'message' => "Signed AOL is pending.",
                '_serialize' => ['status', 'data']
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','document_type','message']);
        }
    }
    // POST /api/createOrders
    public function createOrders()
    {
        //$this->verifyJwtToken();
        $this->request->allowMethod(['post']);
        $this->RequestHandler->renderAs($this, 'json');
        $this->viewBuilder()->setClassName('Json');
        $errorArr = [];

        if (! $this->verifyJwtToken()) {
            // 1a) Invalid token → set 401 headers and JSON payload
            $this->response = $this->response->withStatus(401);

            $this->set([
                'status'  => false,
                'error'   => 'Unauthorized',
                'message' => 'Token is invalid or expired',
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','error','message']);

            // 1b) Stop further processing and return JSON
            return;
        }

        $order_details = $this->FilesVendorAssignment->newEmptyEntity();
        $order_details = $this->FilesVendorAssignment->patchEntity($order_details, $this->request->getData(),['validate' => 'api']);
        /**
         * Temprory hardcoded
         */
        
        if ($this->request->is('post')) {
            
            /**
            * Validations
            */
            if ($order_details->getErrors()) {
                // Validation failed
                $this->response = $this->response->withStatus(422); // Unprocessable Entity

                $this->set([
                    'status'  => false,
                    'message' => 'Validation failed',
                    'code' => '400',
                    'errors'  => $order_details->getErrors(), // returns array like ['field' => ['error message']]
                    '_serialize' => ['status', 'message', 'code', 'errors']
                ]);
                
                return;
            }

            // check State and County for record    s
            $CountyDetails = $this->CountyMst->getCountyTitleByStateCounty($this->request->getData('State'),$this->request->getData('County'));

            $CountyDetailsCount = ((is_array($CountyDetails) || $CountyDetails instanceof Countable) ? count($CountyDetails) : 0);

            if($CountyDetailsCount >= 1)
            {
                // ADD NEW RECORDS
                $NATFileNumber = $this->setNATFileNumber();
                $postData = $this->request->getData();
                $postData['user_id'] = null;
                $postData['vendor_id'] = 0;

                $sqlmainInt = $this->FilesVendorAssignment->sqlDataInsertByForm($postData, null,$CountyDetails['cm_file_enabled'],$NATFileNumber);

                // new add
                $filesMainDataEnter = $this->FilesMainData->newEmptyEntity();
                $filesMainDataEnter = $this->FilesMainData->patchEntity($filesMainDataEnter, $sqlmainInt);
                
                /**
                 * Verify Partner/Company ID
                 */
                if($this->request->getData('company_id') && $this->request->getData('company_id') !== ''){
                    
                    $company_data = $this->CompanyMst->find()->where(['cm_id' => $this->request->getData('company_id')])->first();

                    if (!$company_data->cm_id) {

                        $this->set([
                            'status' => "failed",
                            'message' => "Partner Id invalid, Please try with another partner Id",
                            '_serialize' => ['status', 'data']
                        ]);
                        $this->viewBuilder()->setOption('serialize', ['status','message']);
                        return;
                    }
                }
                /**
                 * Verify Duplicate PartnerFileNumber
                 */
                if($this->request->getData('PartnerFileNumber') && $this->request->getData('PartnerFileNumber') !== ''){
                    
                    $fileMainData = $this->FilesMainData->find()->where(['PartnerFileNumber' => $this->request->getData('PartnerFileNumber')])->first();

                    if (isset($fileMainData->PartnerFileNumber)) {

                        $this->set([
                            'status' => "failed",
                            'message' => "PartnerFileNumber is already exist, Please try with another PartnerFileNumber",
                            '_serialize' => ['status', 'data']
                        ]);
                        $this->viewBuilder()->setOption('serialize', ['status','message']);
                        return;
                    }
                }
                /**
                 * Verify Company/Partner Import Sheet Mapping Fields With API Fields
                 */
                //Get all api post data
                $allApiPostData = $this->request->getData();
                $columnArray = [];
                //Loop through all api post data & store the column name in array
                foreach($allApiPostData as $key=>$val){
                    if($key !== 'company_id'){
                        $columnArray[] = $key;
                    }
                }
                
                // set all mapping fields from database and CSV header 
                $mappingsFields 	 = $this->setCompanyMappingsFields($allApiPostData['company_id'], $columnArray);
                //echo '<pre>';
                //print_r($mappingsFields); exit;
                $partnerImportFields = $mappingsFields['partnerImportFields'];
                $mapCSVFieldsTitle	 = $mappingsFields['mapCSVFieldsTitle'];
                $duplicate_validColomns	 = $mappingsFields['duplicate_validColomns'];

                // check errors from CSV headers
                if(isset($duplicate_validColomns['duplicate']) && sizeof($duplicate_validColomns['duplicate']) > 0){
                    $errorArr['isDuplicate'] = $duplicate_validColomns['duplicate']; //"Dumplicate values";
                }
                if(isset($duplicate_validColomns['errcols']) && sizeof($duplicate_validColomns['errcols']) > 0){
                    $errorArr['isNotMatch'] = $duplicate_validColomns['errcols']; //"Not Match columns";
                }
                if($duplicate_validColomns['isEmptyColumn']){
                    $errorArr['isEmpty'] = $duplicate_validColomns['isEmptyColumn']; //true //"Empty columns";
                }
                
                if(!empty(array_filter($errorArr))){
                    goto errordisplay;
                }

                errordisplay:{
                    if(!empty(array_filter($errorArr))){ 
                        $this->fieldsMapErrorMsg($errorArr, $partnerImportFields);
                        return;
                    }
                }
            
                if($this->FilesMainData->save($filesMainDataEnter))
                {
                    $insId = $filesMainDataEnter->Id;

                    $docTypesarr = [DOCTYPE]; // set default doc type if not present 99
                    $TransactionType = $this->request->getData('TransactionType');
                    if( isset($TransactionType) && !empty($TransactionType)) // && strpos($this->request->data['TransactionType'], ',')
                    {
                        $docTypesarr =$this->explodeDocType($TransactionType);
                    }
                    foreach($docTypesarr as $docType){
                        // document type not equal to 0
                        $docType = $this->setDocType($docType);
                        // check for extension NEW
                        //$extensionDT  = $this->FilesVendorAssignment->getMainDataByMultiDocType($insId, $doctype, 'Id');
                        //Insert in CheckIn with TransactionType
                        $vendorid=0; 
                        //$criteria = array();
                        //if(!empty($postData['search_criteria']) && count($postData['search_criteria'])>0){ $criteria = $postData['search_criteria']; }
                        $criteria = [];

                        if (!empty($postData['search_criteria']) && is_array($postData['search_criteria']) && count($postData['search_criteria']) > 0) {
                            $criteria = $postData['search_criteria'];
                        }
                        if($postData['vendorid']){ $vendorid = $postData['vendorid']; }
                        
                        $this->FilesVendorAssignment->insertNewCheckinData($insId, $docType, '', $this->request->getData('DocumentReceived'), 0, $vendorid, $criteria);
                        
                        // need to ask
                        if($this->request->getData('Regarding')){
                            $regarding = (empty(trim($this->request->getData('Regarding')))) ? 'Checkin: Record Added': trim($this->request->getData('Regarding'));
                            $this->PublicNotes->insertNewPublicNotes($insId, $docType, $this->currentUser->user_id, $regarding, 'Fva'); //$this->request->getData('Public_Internal')
                            //##### End of Coding for adding/updating -public_notes
                        }
                        
                    }

                    $this->set([
                        'status'  => true,
                        'message' => 'Order received and is being processed',
                        'tracking_link'    => '"https://nat.example.com/orders/'.$this->request->getData('PartnerFileNumber'),
                        '_serialize' => ['status', 'message', 'data','tracking_link']
                    ]);

                    return;
                }
                
                $this->set([
                    'status'  => false,
                    'error'   => 'File data save error',
                    'message' => 'The files data could not be saved. Please, try again.',
                ]);
                $this->viewBuilder()->setOption('serialize', ['status','error','message']);
            }
            else
            {
                $this->set([
                    'status'  => false,
                    'error'   => 'Bad Request',
                    'message' => 'Please Enter Correct County Name',
                ]);
                $this->viewBuilder()->setOption('serialize', ['status','error','message']);
            }
        } 
        else{
            $this->set([
                'status'  => false,
                'error'   => 'Bad Request',
                'message' => 'Bad Request',
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','error','message']);
        }
        
        /* if ($this->FilesVendorAssignment->save($order_details)) {
            $this->set([
                'status' => true,
                'message' => 'User added successfully',
                'data' => $order_details,
                '_serialize' => ['status', 'message', 'data']
            ]);
        } else {
            $this->set([
                'status' => false,
                'errors' => $order_details->getErrors(),
                '_serialize' => ['status', 'errors']
            ]);
        } */
    }
	public function setNATFileNumber($is_loop = false)
	{
		$dbLRSnumber = '';
		if($is_loop == false){  $this->setmaxLRSno = ''; }
		
		if(empty($this->setmaxLRSno)){ 
			$lrsFilenoList = $this->FilesMainData->getMaxLRSfileno();
			$dbLRSnumber = ((is_array($lrsFilenoList)) ? $lrsFilenoList['NATFileNumber'] : '');
		}else{
			//$existMaxLRS = $this->FilesVendorAssignment->FilesMainData->exists(['NATFileNumber'=>$this->setmaxLRSno]);
			$dbLRSnumber = $this->setmaxLRSno;
		}

		$NATFileNumber = 300000;
		if(!empty($dbLRSnumber)){
			if(intval($dbLRSnumber) < 300000){
				$NATFileNumber = 300000;
			}else{
				$NATFileNumber = $dbLRSnumber+1;
			}
			$this->setmaxLRSno = $NATFileNumber;
		}
		return $NATFileNumber;
	}
    private function explodeDocType($TransactionType){
		
		if(is_int($TransactionType)){ 
			$docTypesarr =[$TransactionType]; 
		}else{ 
			$docTypesarr =[$TransactionType]; 
			if(strpos($TransactionType, ',') !== false){
				$docTypesarr = @explode(',', $TransactionType);
			}
		}
		return $docTypesarr;
	}
    private function setDocType($docType=''){
		if(($docType==0) || (empty($docType))){ 
			$docType=DOCTYPE; 
		}
		return $docType;
	}


	public function sampleImport($filename='',$folder=''){
		 // set page title
         $pageTitle = 'Download Sample Import CSV';
         $this->set(compact('pageTitle')); 
	}
	
	public function downloadSamplefile() {
		
		$table = 'CenterBranch,LoanAmount,FileStartDate,ClientId,NATFileNumber,PartnerFileNumber,Grantors,GrantorFirstName1,GrantorFirstName2,Grantees,GranteeFirstName1,GranteeLastName2,StreetName,StreetName,City,State,APNParcelNumber';
		$name = 'upload_fields.csv';
		header('Pragma: public');
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");                  // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');     // HTTP/1.1
		header('Cache-Control: pre-check=0, post-check=0, max-age=0');    // HTTP/1.1
		header("Pragma: no-cache");
		header("Expires: 0");
		header('Content-Transfer-Encoding: none');
		header('Content-type: application/ms-excel');
		header('Content-Disposition: attachment; filename="' . basename($name) . '"');
		echo $table;
		exit;
	}
    public function setCompanyMappingsFields($companyid,$columnData)
	{
		 
		// all fiels from import sheet table for company Id
		$this->loadModel('CompanyImportFields');
		$partnerImportFields = $this->CompanyImportFields->companyMapImportFields($companyid);
       
		$this->loadModel('CompanyFieldsMap');
		// original mapping fields
		$partnerFieldsError = $this->CompanyFieldsMap->mapFieldsByCompanyId($companyid, $columnData);
        
       
		if(empty(array_filter($partnerImportFields))){
			// if company id blank then add default fields name ****** IMP
            $this->loadModel('FilesMainData');
			$partnerImportFields = $this->FilesMainData->getTableFileds();
		}
     
		// need to sent one by one column name to search
		$mapCSVFieldsTitle = [];
		 
		foreach($columnData as $col){
			//if(is_int($col))
			$mapCSVFieldsTitle[] = $this->CompanyFieldsMap->checkMapFieldsTitle($companyid, $col);
		}
		
		//echo '<pre>';
		//print_r($mapCSVFieldsTitle);
		//print_r($columnData);
		//print_r($partnerImportFields); //exit;
 
        // get duplicate values and is_empty flag and other valid column check
		$duplicate_validColomns = $this->checkDuplicateAndValidColumn($mapCSVFieldsTitle, $columnData, $partnerImportFields);
       // print_r($duplicate_validColomns); 
        //print_r($partnerFieldsError); 
		
		//exit;
		return ['partnerImportFields'=>$partnerFieldsError,'mapCSVFieldsTitle'=>$mapCSVFieldsTitle,'duplicate_validColomns'=>$duplicate_validColomns];
 
    }
    private function checkDuplicateAndValidColumn(array $mapArray, array $columnData, array $importFields)
	{
      
		$duplicateError =['transtypecolno'=>'','ClientFlNocolno'=>'','partnerIDcolno'=>'','NATFlNo'=>0,'County'=>'','State'=>'','isEmptyColumn'=>false];
 
		$arrValCount = array_count_values($mapArray);
 
		$id ='';
//echo '<pre>';
		  //print_r($arrValCount); exit;
		foreach($arrValCount as $value => $count)
		{
		    $id = array_search($value, $mapArray);

			// check duplicate values in column
			if($count > 1 && !empty($value))
				$duplicateError['duplicate'][]  = $columnData[$id]; // search key of value
			
			// check empty values in column
			if(empty($value)){
				$duplicateError['isEmptyColumn']  = true;
			}
			//check not match values in column
           
			if(!empty($value) && !in_array($value, $importFields)){
                $duplicateError['errcols'][] = $columnData[$id];  // column which are not match 
			}

			if($value == "TransactionType"){ //TransactionType
				$duplicateError['transtypecolno'] = $id;
			}
			if($value == "PartnerFileNumber"){ // PartnerFileNumber
				$duplicateError['ClientFlNocolno'] = $id;
			}
			if($value == "NATFileNumber"){ // NATFileNumber
				$duplicateError['NATFlNo'] = 1;
			}

			if($value == "State"){
				$duplicateError['State'] = $id;
			}

			if($value == "County"){
				$duplicateError['County'] = $id;
			}
			 
			if($value == "PartnerID"){ //PartnerID
				$duplicateError['partnerIDcolno'] = $id;
				$duplicateError['partneridcolname'] = $value;
			}

			/* if($value == "PartnerID"){ //PartnerID
				$duplicateError['partnerIDcolno'] = $id;
				$duplicateError['partneridcolname'] = 'company_mst_id';
			} */

		}
		
		return $duplicateError ;

	}
    public function fieldsMapErrorMsg(array $errorArr, $partnerImportFields=[])
	{  
        
        if(isset($errorArr['isNotMatch']) && $errorArr['isNotMatch'] != "" && empty($partnerImportFields)){
            $this->set([
                'status' => "failed",
                'error' => "The column titles not allowed are",
                'not_allowed_columns' => implode(', ',$errorArr['isNotMatch'])
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','error','not_allowed_columns']);
        }
        if(isset($errorArr['isNotMatch']) && $errorArr['isNotMatch'] != "" && !empty($partnerImportFields)){
            $this->set([
                'status' => "failed",
                'error' => "The column titles are not allowed",
                'not_allowed_columns' => implode(', ',$errorArr['isNotMatch']),
                'allowed_column_titles_are' =>implode(', ',$partnerImportFields),
                'suggestions'=>'Remove spaces between column titles, Check spelling of column titles, Remove empty columns'
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','error','not_allowed_columns','allowed_column_titles_are','suggestions']);
        }
        if(isset($errorArr['isEmpty']) && ($errorArr['isEmpty'])){
            $this->set([
                'status' => "failed",
                'error' => "Some columns have empty titles."
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','error','not_allowed_columns']);
        }
        if(isset($errorArr['isDuplicate']) &&  $errorArr['isDuplicate'] != ""){
            $this->set([
                'status' => "failed",
                'error' => "The spreadsheet (CSV) contains duplicate columns.",
                'duplicate_columns' => implode(', ',$errorArr['isDuplicate'])
            ]);
            $this->viewBuilder()->setOption('serialize', ['status','error','not_allowed_columns']);
        }
	}
}
