<?php
declare(strict_types=1);

namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Mailer\Mailer;
use App\Controller\PdfController;
use Cake\Http\ServerRequest;
/**
 * FilesCheckinData Controller
 *
 * @method \App\Model\Entity\FilesCheckinData[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilesVendorAssignmentController extends AppController
{
  
	private $orig_fields = ['FileStartDate','PartnerID','NATFileNumber','PartnerFileNumber','Grantors','GrantorFirstName1','GrantorFirstName2','Grantees','StreetNumber','StreetName','City','County','State','Zip','TransactionType','CheckInDateTime','CountyRecordingFee','Taxes','AdditionalFees','Total','CarrierName','CarrierTrackingNo','RecordingDate','RecordingTime','InstrumentNumber','Book','Page','PublicNotes','LoanAmount','File'];

    // step for datatable config : 1

    /*private $columns_alise = [  "Checkbox" => "",
                                "FileNo" => "fmd.NATFileNumber",
                                "PartnerFileNumber" => "fmd.PartnerFileNumber",								
                                "TransactionType" => "fva.TransactionType",
                                "Grantors" => "fmd.Grantors",
                                "StreetName" => "fmd.StreetName",
                                "County" => "fmd.County",
                                "State" => "fmd.State",
                                "DocStatus" => "fva.vendor",                                
                                "DateAdded" => "fva.date_updated",
								"Actions" => ""
								
                            ];

	private  $columnsorder = [0=>'fmd.Id', 1=>'fmd.NATFileNumber', 2=>'fmd.PartnerFileNumber', 3=>'fva.TransactionType', 4=>'fmd.Grantors', 5=>'fmd.StreetName', 6=>'fmd.County', 7=>'fmd.State', 8=>'fva.vendor', 9=>'fva.date_updated'];
	
	*/
	private $columns_alise = [  "Checkbox" => "",
                                "FileNo" => "fmd.NATFileNumber",
                                "PartnerFileNumber" => "fmd.PartnerFileNumber",
                                "TransactionType" => "fva.TransactionType",
                                "Grantors" => "fmd.Grantors",
                                "StreetName" => "fmd.StreetName",
                                "County" => "fmd.County",
                                "State" => "fmd.State",
                                "DocStatus" => "fva.DocumentReceived",
                                "DateAdded" => "fva.date_updated",
								"Actions" => ""								
                            ];

	private  $columnsorder = [0=>'fmd.Id', 1=>'fmd.NATFileNumber', 2=>'fmd.PartnerFileNumber',  4=>'fva.TransactionType', 5=>'fmd.Grantors', 6=>'fmd.StreetName', 7=>'fmd.County', 8=>'fmd.State', 9=>'fva.DocumentReceived', 11=>'fva.date_updated'];
	

	//user these model for update delete cammands
	//private $otherModelName = ['FilesQcData','FilesAccountingData','FilesShiptoCountyData','FilesRecordingData','FilesReturned2partner','PublicNotes'];
	private $otherModelName = ['FilesQcData','FilesAccountingData','FilesRecordingData','FilesReturned2partner','PublicNotes'];
	
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
	  
   }
   
	public function beforeFilter(\Cake\Event\EventInterface $event)
    {
		parent::beforeFilter($event);
		$this->loginAccess(); 
	}

	public function generateBarcode()
	{ 
        $fileno = $this->request->getData('fileno'); //NATFileNumber
        $doctype = $this->request->getData('doctype');
       
        $query =  $this->FilesMainData->find()
                ->select('Id')
                ->where(['NATFileNumber' => $fileno]);

        $fmdId = $query->isEmpty() ? null : $query->first()->Id; //exit;
		
		// generate qr code image and return true/false
		// call from component GeneratePDF
		//$barcodeGenerated = $this->GeneratePDF->generateQRcode($fileno,$doctype);
		 
        if(!is_null($fmdId) && $barcodeGenerated){
			$filesQcData = $this->FilesCheckinData->find()->where(['RecId'=>$fmdId])->first();
 			$filesQcData->barcode_generated = 'Y';  
			$this->FilesCheckinData->save($filesQcData);
        }
	
        exit();
    }

	 /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
	 
	public function indexPartner(){
		$this->index();
		// set page title
		$pageTitle = 'Check In Status';
		$this->set(compact('pageTitle'));
		
	}

    public function index()
    {
		// set page title
		$pageTitle = 'Record Listing';
		$this->set(compact('pageTitle'));
		
		// IF DOCUMENT RECEIVED BUTTON CLICKED
		$csvFileName = '';$townshipRecordsTable = '';
		$docstatus = $this->request->getData('docstatus');
		
		if(isset($docstatus) && (!($this->user_Gateway))){
			 $pd = $this->request->getData();
			
			$fmd_township_division = $this->request->getData('fmd_township_division');
			$postData = ['sno'=>$this->request->getData('sno'), 'company_id'=>$this->request->getData('company_id'),'fmd_township_division'=>isset($fmd_township_division) ? $this->request->getData('fmd_township_division'): ''];
			//pr($postData);exit;	
			// physical document received process
            if($this->request->getData('docstatus') == "dr"){ 
                $processDocument = $this->_documentReceived($postData, 'Y');
            }

            if($this->request->getData('docstatus') == "dnr"){
				$processDocument = $this->_documentReceived($postData);
            }
		
			if(isset($processDocument) && is_array($processDocument)){
				$townshipRecordsTable = $this->townshipErrorTable($processDocument['townshipFmdError']);
				$csvFileName = $processDocument['csvFileName'];
			}
		}  

		$this->set('townshipRecordsTable', $townshipRecordsTable);
		$this->set('csvFileName', $csvFileName);

		 // set company Id in app controller
		 $requestData = $this->request->getData();
		 $company_mst_id = $this->setCompanyId($requestData); 
  
		if($this->user_Gateway){
			unset($this->columns_alise["FileNo"]);
			// remove and rearrange order for number key array
			array_splice($this->columnsorder,1,1); // 1-> key number, 1->count
		}

        // step for datatable config : 3
        $this->set('dataJson', $this->CustomPagination->setDataJson($this->columns_alise,['Checkbox','Actions']));

        // step for datatable config : 4 
		//end step
		$isSearch = 0;
        $formpostdata = '';
        if ($this->request->is(['patch', 'post', 'put'])) {
            $formpostdata = $this->request->getData();
			$isSearch = 1;
        }
		
        $this->set('formpostdata', $formpostdata);
        //end step
		$this->set('isSearch', $isSearch);
        //$this->set('isSearch', $this->FilesCheckinData->isSearch());

        $FilesVendorAssignment = $this->FilesVendorAssignment->newEmptyEntity();
         /* Added by Vinit - Start */
        $this->loadModel('Vendors');
        $vendorlist = $this->Vendors->ListArray("V");
        $vendor_id = 12;
        $vendor_services = $this->Vendors->get_vendor_services($vendor_id);
        //echo "<pre>";print_r($vendor_services);echo "</pre>";exit;
        /* Added by Vinit - End */
      
        //$mapArray = $this->_getMappingFields($company_mst_id);
		$partnerMapField =  $this->CompanyFieldsMap->partnerMapFields($company_mst_id,1);
	  
        $DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
       // $fileCsvMasterData =  $this->_getCsvFileListing();,'fileCsvMasterData'
        $companyMsts = $this->CompanyMst->companyListArray()->toArray();
		
		// for common data_documentReceivedtable element
		$is_index = 'Y';
		$this->set('is_index', $is_index);
		
        $this->set(compact('FilesVendorAssignment','companyMsts','DocumentTypeData','partnerMapField', 'vendorlist', 'vendor_services'));
        $this->set('_serialize', ['FilesVendorAssignment']);
      
	  // for partner section 
	   $checkinDataSheet = $this->request->getData('checkinDataSheet');
		if(isset($checkinDataSheet))
		{
			$this->checkinRecordsSheet($this->request->getData());
		}
    }

    public function aolindex(){
		// set page title
		$pageTitle = 'Create AOL template';
		$this->set(compact('pageTitle'));

        $request = new ServerRequest();
        $pdfController = new PdfController($request);

		// IF DOCUMENT RECEIVED BUTTON CLICKED
		$csvFileName = '';$townshipRecordsTable = '';
		$docstatus = $this->request->getData('docstatus');
        //echo "<pre>";print_r($this->request->getData());echo "</pre>";exit;
		if(isset($docstatus) && (!($this->user_Gateway))){
			 $pd = $this->request->getData();
             //echo "<pre>";print_r($pd);echo "</pre>";exit;
             if(isset($pd['checkAll'])){
             foreach($pd['checkAll'] as $key=>$value){
                $aol['RecId'] = $value;
                if($pd['pre_aol']){ 
					$aol['pre_aol_status'] = "Y";
					$aol['pre_aol_date'] = date('Y-m-d H:i:s');; 
					$pdfController->generatePdf($aol['RecId'], "pre");
				}else if($pd['final_aol']){ 
					$aol['final_aol_status'] = "Y";
					$aol['final_aol_date'] = date('Y-m-d H:i:s');;
					$pdfController->generatePdf($aol['RecId'],"final");
                }else if($pd['submit_aol']){
                    $aol['submit_aol_status'] = "Y";
					$aol['submit_aol_date'] = date('Y-m-d H:i:s');;
                    $partner = $this->loadModel('FilesMainData')->find()->where(['Id' => $aol['RecId']])->first();
                    $company = $this->CompanyMst->find()->select(['cm_email'])->where(['cm_id' => $partner->company_id])->first();
                    $filePath = WWW_ROOT . 'files' . DS . 'export' . DS . 'aol_assignment' . DS . 'pdf' . DS . 'aol_signed' . DS . "AssignmentDetails-".$aol['RecId'].".pdf";

                    if (file_exists($filePath)) {
                        //echo "File exists: " . $filePath;
                        $this->sendEmailToClient($company->cm_email, $filePath);
                    } else {
                        $this->Flash->success(__('The Signed AOL is not generated yet. Please generate and proceed.'));
                        return $this->redirect(['action' => 'aolindex']);
                    }
                    //echo "<pre>";print_r($company);echo "</pre>";exit;
                }
                if ($this->request->is('post')) {
                  $existingRecord = $this->FilesAolAssignment->find()->where(['RecId' => $aol['RecId']])->first();
                  //echo "<pre>";print_r($existingRecord);echo "</pre>";
                  if ($existingRecord) {
                      // If record exists, patch data for editing
                      $filesAolAssignment = $this->FilesAolAssignment->patchEntity($existingRecord, $aol);
                  } else {
                      // If record doesn't exist, create a new one
                      $filesAolAssignment = $this->FilesAolAssignment->newEmptyEntity();
                      $filesAolAssignment = $this->FilesAolAssignment->patchEntity($filesAolAssignment, $aol);
                  }
                  // Save the record
                  if ($this->FilesAolAssignment->save($filesAolAssignment)) {
                      //$this->Flash->success(__('The file AOL assignment has been saved.'));
                  }
              }
              $this->set(compact('filesAolAssignment'));
            }
            //Code to generate csv start
            $this->generateCsv($pd['checkAll']);
            //Code to generate csv end
            }else if(isset($pd['pre_aol']) || isset($pd['final_aol']) || isset($pd['submit_aol'])){
                $this->Flash->error(__('Please select records to proceed.'));
                //return $this->redirect(['action' => 'aolindex']);
            }

			$fmd_township_division = $this->request->getData('fmd_township_division');
			$postData = ['sno'=>$this->request->getData('sno'), 'company_id'=>$this->request->getData('company_id'),'fmd_township_division'=>isset($fmd_township_division) ? $this->request->getData('fmd_township_division'): ''];
			//pr($postData);exit;
			// physical document received process
            if($this->request->getData('docstatus') == "assigned"){
                $processDocument = $this->_documentReceived($postData, 'Y');
            }

            if($this->request->getData('docstatus') == "pending"){
				$processDocument = $this->_documentReceived($postData);
            }

			if(isset($processDocument) && is_array($processDocument)){
				$townshipRecordsTable = $this->townshipErrorTable($processDocument['townshipFmdError']);
				$csvFileName = $processDocument['csvFileName'];
			}
		}

		$this->set('townshipRecordsTable', $townshipRecordsTable);
		$this->set('csvFileName', $csvFileName);

		 // set company Id in app controller
		 $requestData = $this->request->getData();
		 $company_mst_id = $this->setCompanyId($requestData);

		if($this->user_Gateway){
			unset($this->columns_alise["FileNo"]);
			// remove and rearrange order for number key array
			array_splice($this->columnsorder,1,1); // 1-> key number, 1->count
		}

        // step for datatable config : 3
        $this->set('dataJson', $this->CustomPagination->setDataJson($this->columns_alise,['Checkbox','Actions']));

        // step for datatable config : 4
		//end step
		$isSearch = 0;
        $formpostdata = '';
        if ($this->request->is(['patch', 'post', 'put'])) {
            $formpostdata = $this->request->getData();
			$isSearch = 1;
        }

        $this->set('formpostdata', $formpostdata);
        //end step
		$this->set('isSearch', $isSearch);
        //$this->set('isSearch', $this->FilesCheckinData->isSearch());

        $FilesVendorAssignment = $this->FilesVendorAssignment->newEmptyEntity();
         /* Added by Vinit - Start */
        $this->loadModel('Vendors');
        $vendorlist = $this->Vendors->ListArray();
        $vendor_id = 12;
        $vendor_services = $this->Vendors->get_vendor_services($vendor_id);
        //echo "<pre>";print_r($vendor_services);echo "</pre>";exit;
        /* Added by Vinit - End */

        //$mapArray = $this->_getMappingFields($company_mst_id);
		$partnerMapField =  $this->CompanyFieldsMap->partnerMapFields($company_mst_id,1);

        $DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
       // $fileCsvMasterData =  $this->_getCsvFileListing();,'fileCsvMasterData'
        $companyMsts = $this->CompanyMst->companyListArray()->toArray();

		// for common data_documentReceivedtable element
		$is_index = 'Y';
		$this->set('is_index', $is_index);

        $this->set(compact('FilesVendorAssignment','companyMsts','DocumentTypeData','partnerMapField', 'vendorlist', 'vendor_services'));
        $this->set('_serialize', ['FilesVendorAssignment']);

	  // for partner section
	   $checkinDataSheet = $this->request->getData('checkinDataSheet');
		if(isset($checkinDataSheet))
		{
			$this->checkinRecordsSheet($this->request->getData());
		}
    }

    public function attindex()
    {
		// set page title
		$pageTitle = 'Record Listing - Assign Attorney';
		$this->set(compact('pageTitle'));

		// IF DOCUMENT RECEIVED BUTTON CLICKED
		$csvFileName = '';$townshipRecordsTable = '';
		$docstatus = $this->request->getData('docstatus');

		if(isset($docstatus) && (!($this->user_Gateway))){
			 $pd = $this->request->getData();

			$fmd_township_division = $this->request->getData('fmd_township_division');
			$postData = ['sno'=>$this->request->getData('sno'), 'company_id'=>$this->request->getData('company_id'),'fmd_township_division'=>isset($fmd_township_division) ? $this->request->getData('fmd_township_division'): ''];
			//pr($postData);exit;
			// physical document received process
            if($this->request->getData('docstatus') == "assigned"){
                $processDocument = $this->_documentReceived($postData, 'Y');
            }

            if($this->request->getData('docstatus') == "pending"){
				$processDocument = $this->_documentReceived($postData);
            }

			if(isset($processDocument) && is_array($processDocument)){
				$townshipRecordsTable = $this->townshipErrorTable($processDocument['townshipFmdError']);
				$csvFileName = $processDocument['csvFileName'];
			}
		}

		$this->set('townshipRecordsTable', $townshipRecordsTable);
		$this->set('csvFileName', $csvFileName);

		 // set company Id in app controller
		 $requestData = $this->request->getData();
		 $company_mst_id = $this->setCompanyId($requestData);

		if($this->user_Gateway){
			unset($this->columns_alise["FileNo"]);
			// remove and rearrange order for number key array
			array_splice($this->columnsorder,1,1); // 1-> key number, 1->count
		}

        // step for datatable config : 3
        $this->set('dataJson', $this->CustomPagination->setDataJson($this->columns_alise,['Checkbox','Actions']));

        // step for datatable config : 4
		//end step
		$isSearch = 0;
        $formpostdata = '';
        if ($this->request->is(['patch', 'post', 'put'])) {
            $formpostdata = $this->request->getData();
			$isSearch = 1;
        }

        $this->set('formpostdata', $formpostdata);
        //end step
		$this->set('isSearch', $isSearch);
        //$this->set('isSearch', $this->FilesCheckinData->isSearch());

        $FilesVendorAssignment = $this->FilesVendorAssignment->newEmptyEntity();
         /* Added by Vinit - Start */
        $this->loadModel('Vendors');
        $vendorlist = $this->Vendors->ListArray("A");
        $vendor_id = 12;
        $vendor_services = $this->Vendors->get_att_services($vendor_id);
        //echo "<pre>";print_r($vendor_services);echo "</pre>";exit;
        /* Added by Vinit - End */

        //$mapArray = $this->_getMappingFields($company_mst_id);
		$partnerMapField =  $this->CompanyFieldsMap->partnerMapFields($company_mst_id,1);

        $DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
       // $fileCsvMasterData =  $this->_getCsvFileListing();,'fileCsvMasterData'
        $companyMsts = $this->CompanyMst->companyListArray()->toArray();

		// for common data_documentReceivedtable element
		$is_index = 'Y';
		$this->set('is_index', $is_index);

        $this->set(compact('FilesVendorAssignment','companyMsts','DocumentTypeData','partnerMapField', 'vendorlist', 'vendor_services'));
        $this->set('_serialize', ['FilesVendorAssignment']);

	  // for partner section
	   $checkinDataSheet = $this->request->getData('checkinDataSheet');
		if(isset($checkinDataSheet))
		{
			$this->checkinRecordsSheet($this->request->getData());
		}
    }
    public function essindex(){
		// set page title
		$pageTitle = 'Record Listing - Assign Escrow Service';
		$this->set(compact('pageTitle'));

		// IF DOCUMENT RECEIVED BUTTON CLICKED
		$csvFileName = '';$townshipRecordsTable = '';
		$docstatus = $this->request->getData('docstatus');

		if(isset($docstatus) && (!($this->user_Gateway))){
			 $pd = $this->request->getData();

			$fmd_township_division = $this->request->getData('fmd_township_division');
			$postData = ['sno'=>$this->request->getData('sno'), 'company_id'=>$this->request->getData('company_id'),'fmd_township_division'=>isset($fmd_township_division) ? $this->request->getData('fmd_township_division'): ''];
			//pr($postData);exit;
			// physical document received process
            if($this->request->getData('docstatus') == "assigned"){
                $processDocument = $this->_documentReceived($postData, 'Y');
            }

            if($this->request->getData('docstatus') == "pending"){
				$processDocument = $this->_documentReceived($postData);
            }

			if(isset($processDocument) && is_array($processDocument)){
				$townshipRecordsTable = $this->townshipErrorTable($processDocument['townshipFmdError']);
				$csvFileName = $processDocument['csvFileName'];
			}
		}

		$this->set('townshipRecordsTable', $townshipRecordsTable);
		$this->set('csvFileName', $csvFileName);

		 // set company Id in app controller
		 $requestData = $this->request->getData();
		 $company_mst_id = $this->setCompanyId($requestData);

		if($this->user_Gateway){
			unset($this->columns_alise["FileNo"]);
			// remove and rearrange order for number key array
			array_splice($this->columnsorder,1,1); // 1-> key number, 1->count
		}

        // step for datatable config : 3
        $this->set('dataJson', $this->CustomPagination->setDataJson($this->columns_alise,['Checkbox','Actions']));

        // step for datatable config : 4
		//end step
		$isSearch = 0;
        $formpostdata = '';
        if ($this->request->is(['patch', 'post', 'put'])) {
            $formpostdata = $this->request->getData();
			$isSearch = 1;
        }

        $this->set('formpostdata', $formpostdata);
        //end step
		$this->set('isSearch', $isSearch);
        //$this->set('isSearch', $this->FilesCheckinData->isSearch());

        $FilesVendorAssignment = $this->FilesVendorAssignment->newEmptyEntity();
         /* Added by Vinit - Start */
        $this->loadModel('Vendors');
        $vendorlist = $this->Vendors->ListArray("E");
        $vendor_id = 12;
        $vendor_services = $this->Vendors->get_ess_services($vendor_id);
        //echo "<pre>";print_r($vendor_services);echo "</pre>";exit;
        /* Added by Vinit - End */

        //$mapArray = $this->_getMappingFields($company_mst_id);
		$partnerMapField =  $this->CompanyFieldsMap->partnerMapFields($company_mst_id,1);

        $DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
       // $fileCsvMasterData =  $this->_getCsvFileListing();,'fileCsvMasterData'
        $companyMsts = $this->CompanyMst->companyListArray()->toArray();

		// for common data_documentReceivedtable element
		$is_index = 'Y';
		$this->set('is_index', $is_index);

        $this->set(compact('FilesVendorAssignment','companyMsts','DocumentTypeData','partnerMapField', 'vendorlist', 'vendor_services'));
        $this->set('_serialize', ['FilesVendorAssignment']);

	  // for partner section
	   $checkinDataSheet = $this->request->getData('checkinDataSheet');
		if(isset($checkinDataSheet))
		{
			$this->checkinRecordsSheet($this->request->getData());
		}
    }

    public function generateCsv($rec_ids) {
        $rec_ids = array_map('intval', $rec_ids);
        //$csv_output = $this->FilesAolAssignment->find()->where(['RecId IN' => $rec_ids])->all();
        $csv_output = $this->FilesAolAssignment->find()
        ->where(['FilesAolAssignment.RecId IN' => $rec_ids])
        ->innerJoin(
            ['FilesMainData' => 'files_main_data'],
            'FilesMainData.id = FilesAolAssignment.RecId'
        )
        ->select(['FilesMainData.PartnerFileNumber', 'FilesAolAssignment.pre_aol_status', 'FilesAolAssignment.final_aol_status', 'FilesAolAssignment.submit_aol_status', 'FilesAolAssignment.date_updated']) // include whatever fields you want
        ->enableHydration(false) // optional: returns array instead of entity objects
        ->all();

        $filePath = WWW_ROOT . 'files/export/aol_assignment/aol_assignment_export.csv';
        $csvFile = fopen($filePath, 'w');
        fputcsv($csvFile, ['PartnerFileNumber', 'PreAolStatus', 'FinalAolStatus', 'SubmitAolStatus', 'DateUpdated']);

        foreach ($csv_output as $record) {
            $row = [
                $record['FilesMainData']['PartnerFileNumber'],
                ($record['pre_aol_status'] ?? '') == 'Y' ? 'Yes' : 'No',  // Default to empty string if null
                ($record['final_aol_status'] ?? '') == 'Y' ? 'Yes' : 'No',  // Default to empty string if null
                ($record['submit_aol_status'] ?? '') == 'Y' ? 'Yes' : 'No',  // Default to empty string if null
                $record['date_updated'] ?? ''  // Default to empty string if null
            ];
            fputcsv($csvFile, $row); // Write the row to the CSV file
        }
        fclose($csvFile);
        $this->Flash->success(__('<b>The CSV file has been created and saved. <a class="btn btn-primary" href="'.$this->request->getAttribute('webroot').'files/export/aol_assignment/aol_assignment_export.csv" target="_blank" download>Please click here to download the CSV</a> </b>'), ['escape' => false]);
    //return $this->redirect(['action' => 'aolindex']);
    }

    public function generateAttCsv($rec_ids) {
        $rec_ids = array_map('intval', $rec_ids);
        $csv_output = $this->FilesAttorneyAssignment->find()->where(['RecId IN' => $rec_ids])->all();
        $filePath = WWW_ROOT . 'files/export/aol_assignment/aol_assignment_export.csv';
        $csvFile = fopen($filePath, 'w');
        fputcsv($csvFile, ['Id', 'RecId', 'PreAolStatus', 'FinalAolStatus', 'SubmitAolStatus', 'DateUpdated']);

        foreach ($csv_output as $record) {
            $row = [
                $record->Id,
                $record->RecId,
                $record->pre_aol_status ?? 'N',  // Default to empty string if null
                $record->final_aol_status ?? 'N',  // Default to empty string if null
                $record->submit_aol_status ?? 'N',  // Default to empty string if null
                $record->date_updated ?? ''  // Default to empty string if null
            ];
            fputcsv($csvFile, $row); // Write the row to the CSV file
        }
        fclose($csvFile);
        //$this->Flash->success(__('<b>The CSV file has been created and saved. Click <a href="'.$this->request->getAttribute('webroot').'files/export/aol_assignment/aol_assignment_export.csv" target="_blank">here</a> to download the CSV.</b>'), ['escape' => false]);
        $this->Flash->success(__('<b>The CSV file has been created and saved. <a class="btn btn-primary" href="'.$this->request->getAttribute('webroot').'files/export/aol_assignment/aol_assignment_export.csv" target="_blank" download>Please click here to download the CSV</a> </b>'), ['escape' => false]);
    }

    /*public function aolindex()
    {
		// set page title
		$pageTitle = 'Record Listing';
		$this->set(compact('pageTitle'));

		// IF DOCUMENT RECEIVED BUTTON CLICKED
		$csvFileName = '';$townshipRecordsTable = '';
		$docstatus = $this->request->getData('docstatus');

		if(isset($docstatus) && (!($this->user_Gateway))){
			 $pd = $this->request->getData();

			$fmd_township_division = $this->request->getData('fmd_township_division');
			$postData = ['sno'=>$this->request->getData('sno'), 'company_id'=>$this->request->getData('company_id'),'fmd_township_division'=>isset($fmd_township_division) ? $this->request->getData('fmd_township_division'): ''];
			//pr($postData);exit;
			// physical document received process
            if($this->request->getData('docstatus') == "dr"){
                $processDocument = $this->_documentReceived($postData, 'Y');
            }

            if($this->request->getData('docstatus') == "dnr"){
				$processDocument = $this->_documentReceived($postData);
            }

			if(isset($processDocument) && is_array($processDocument)){
				$townshipRecordsTable = $this->townshipErrorTable($processDocument['townshipFmdError']);
				$csvFileName = $processDocument['csvFileName'];
			}
		}

		$this->set('townshipRecordsTable', $townshipRecordsTable);
		$this->set('csvFileName', $csvFileName);

		 // set company Id in app controller
		 $requestData = $this->request->getData();
		 $company_mst_id = $this->setCompanyId($requestData);

		if($this->user_Gateway){
			unset($this->columns_alise["FileNo"]);
			// remove and rearrange order for number key array
			array_splice($this->columnsorder,1,1); // 1-> key number, 1->count
		}

        // step for datatable config : 3
        $this->set('dataJson', $this->CustomPagination->setDataJson($this->columns_alise,['Checkbox','Actions']));

        // step for datatable config : 4
		//end step
		$isSearch = 0;
        $formpostdata = '';
        if ($this->request->is(['patch', 'post', 'put'])) {
            $formpostdata = $this->request->getData();
			$isSearch = 1;
        }

        $this->set('formpostdata', $formpostdata);
        //end step
		$this->set('isSearch', $isSearch);
        //$this->set('isSearch', $this->FilesCheckinData->isSearch());

        $FilesVendorAssignment = $this->FilesVendorAssignment->newEmptyEntity();
         // Added by Vinit - Start
        $this->loadModel('Vendors');
        $vendorlist = $this->Vendors->ListArray();
        $vendor_id = 12;
        $vendor_services = $this->Vendors->get_vendor_services($vendor_id);
        //echo "<pre>";print_r($vendor_services);echo "</pre>";exit;
        // Added by Vinit - End

        //$mapArray = $this->_getMappingFields($company_mst_id);
		$partnerMapField =  $this->CompanyFieldsMap->partnerMapFields($company_mst_id,1);

        $DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
       // $fileCsvMasterData =  $this->_getCsvFileListing();,'fileCsvMasterData'
        $companyMsts = $this->CompanyMst->companyListArray()->toArray();

		// for common data_documentReceivedtable element
		$is_index = 'Y';
		$this->set('is_index', $is_index);

        $this->set(compact('FilesVendorAssignment','companyMsts','DocumentTypeData','partnerMapField', 'vendorlist', 'vendor_services'));
        $this->set('_serialize', ['FilesVendorAssignment']);

	  // for partner section
	   $checkinDataSheet = $this->request->getData('checkinDataSheet');
		if(isset($checkinDataSheet))
		{
			$this->checkinRecordsSheet($this->request->getData());
		}
    }*/
    /*public function aolindex(){
		// set page title
		$pageTitle = 'Create AOL Template';
		$this->set(compact('pageTitle'));

		// IF DOCUMENT RECEIVED BUTTON CLICKED
		$csvFileName = '';$townshipRecordsTable = '';
		$docstatus = $this->request->getData('docstatus');

		if(isset($docstatus) && (!($this->user_Gateway))){
			 $pd = $this->request->getData();
             foreach($pd['checkAll'] as $key=>$value){
                $aol['RecId'] = $value;
                if($pd['pre_aol']){ $aol['pre_aol_status'] = "Y";}else if($pd['final_aol']){ $aol['final_aol_status'] = "Y";
                }else if($pd['submit_aol']){ $aol['submit_aol_status'] = "Y"; }
                if ($this->request->is('post')) {
                  $existingRecord = $this->FilesAolAssignment->find()->where(['RecId' => $aol['RecId']])->first();
                  //echo "<pre>";print_r($existingRecord);echo "</pre>";
                  if ($existingRecord) {
                      // If record exists, patch data for editing
                      $filesAolAssignment = $this->FilesAolAssignment->patchEntity($existingRecord, $aol);
                  } else {
                      // If record doesn't exist, create a new one
                      $filesAolAssignment = $this->FilesAolAssignment->newEmptyEntity();
                      $filesAolAssignment = $this->FilesAolAssignment->patchEntity($filesAolAssignment, $aol);
                  }
                  // Save the record
                  if ($this->FilesAolAssignment->save($filesAolAssignment)) {
                      //$this->Flash->success(__('The file AOL assignment has been saved.'));
                  }
              }
              $this->set(compact('filesAolAssignment'));
            }
            //Code to generate csv start
            $this->generateCsv($pd['checkAll']);
            //Code to generate csv end
			$fmd_township_division = $this->request->getData('fmd_township_division');
			$postData = ['sno'=>$this->request->getData('sno'), 'company_id'=>$this->request->getData('company_id'),'fmd_township_division'=>isset($fmd_township_division) ? $this->request->getData('fmd_township_division'): ''];
			//pr($postData);exit;
			// physical document received process
            if($this->request->getData('docstatus') == "dr"){
                $processDocument = $this->_documentReceived($postData, 'Y');
            }

            if($this->request->getData('docstatus') == "dnr"){
				$processDocument = $this->_documentReceived($postData);
            }

			if(isset($processDocument) && is_array($processDocument)){
				$townshipRecordsTable = $this->townshipErrorTable($processDocument['townshipFmdError']);
				$csvFileName = $processDocument['csvFileName'];
			}
		}

		$this->set('townshipRecordsTable', $townshipRecordsTable);
		$this->set('csvFileName', $csvFileName);

		 // set company Id in app controller
		 $requestData = $this->request->getData();
		 $company_mst_id = $this->setCompanyId($requestData);

		if($this->user_Gateway){
			unset($this->columns_alise["FileNo"]);
			// remove and rearrange order for number key array
			array_splice($this->columnsorder,1,1); // 1-> key number, 1->count
		}

        // step for datatable config : 3
        $this->set('dataJson', $this->CustomPagination->setDataJson($this->columns_alise,['Checkbox','Actions']));

        // step for datatable config : 4
		//end step
		$isSearch = 0;
        $formpostdata = '';
        if ($this->request->is(['patch', 'post', 'put'])) {
            $formpostdata = $this->request->getData();
			$isSearch = 1;
        }

        $this->set('formpostdata', $formpostdata);
        //end step
		$this->set('isSearch', $isSearch);
        //$this->set('isSearch', $this->FilesCheckinData->isSearch());

        $FilesVendorAssignment = $this->FilesVendorAssignment->newEmptyEntity();
        //$mapArray = $this->_getMappingFields($company_mst_id);
		$partnerMapField =  $this->CompanyFieldsMap->partnerMapFields($company_mst_id,1);

        $DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
       // $fileCsvMasterData =  $this->_getCsvFileListing();,'fileCsvMasterData'
        $companyMsts = $this->CompanyMst->companyListArray()->toArray();

		// for common data_documentReceivedtable element
		$is_index = 'Y';

        // Added by Vinit - Start
        $this->loadModel('Vendors');
        $vendorlist = $this->Vendors->ListArray();
        $vendor_id = 12;
        $vendor_services = $this->Vendors->get_vendor_services($vendor_id);
        // Added by Vinit - End

		$this->set('is_index', $is_index);

        $this->set(compact('FilesVendorAssignment','companyMsts','DocumentTypeData','partnerMapField', 'vendorlist', 'vendor_services'));
        $this->set('_serialize', ['FilesVendorAssignment']);

	  // for partner section
	   $checkinDataSheet = $this->request->getData('checkinDataSheet');
		if(isset($checkinDataSheet))
		{
			$this->checkinRecordsSheet($this->request->getData());
		}
    }*/
	

	private function townshipErrorTable($townErrorRecArr=[]){
	 
		$towstxt='';

		if(empty($townErrorRecArr)) return $towstxt;

		if(count($townErrorRecArr)>0){
			$listTownError = $this->FilesMainData->getFileMainTownShipData($townErrorRecArr);
		 
			$i = 1;
			
			if(!empty($listTownError)){ 
		
				foreach($listTownError as $listTown){
					$checkboxdisabled = (($listTown["lock_status"] == 1) ? 'disabled' : '');
					$listTownshipDivision = $this->CountyMst->listTownshipDivision($listTown['State'],$listTown['County'], $listTown['Id']);

					$towstxt .='<tr>
									<td><input type="checkbox" '.$checkboxdisabled.' name="checkAll[]" value="'.$listTown['Id'].'" class="checkSingle"/><input type="hidden" name="documentTypeHidden" value="'.$listTown['fva']['TransactionType'].'"><input type="hidden" name="docTypeInput" class="docinput" value="'.$listTown['fva']['TransactionType'].'" /></td>
									<td>'.(($listTown['NATFileNumber']) ? substr($listTown['NATFileNumber'],0,65) : '').'</td>
									<td>'.$listTown['PartnerFileNumber'].'<font size=1> ( '.$listTown['comp_mst']['cm_comp_name'].' )</font>'.'</td>
									<td>'.$listTown['dtm']['Title'].'</td>
									<td>'.$listTown['Grantors'].'</td>
									<td>'.$listTown['StreetName'].'</td>
									<td>'.$listTown['State'].'</td>
									<td>'.$listTown['County'].'</td>	
									<td>'.$listTownshipDivision.'</td>	
									
								</tr>';
							$i++;
				}
			}
			
			return $towstxt; 
		}
	}

	private function checkTownShip($fmdTownshipDivision=[], $fileDocId){
		$township = '';
		if(!empty($fmdTownshipDivision)){
			foreach($fmdTownshipDivision as $fmdTownship){
				if(!empty($fmdTownship)){
					$exp_townshipDivision = explode("_",$fmdTownship);
					if($fileDocId == $exp_townshipDivision[0]){
						$township = isset($exp_townshipDivision[1]) ? $exp_townshipDivision[1] : '';
					}
				}
			}
		}
		return $township;
	}
	

	// $DocumentReceived is blank couse database entry is blank
	public function _documentReceived($postdata, $DocumentReceived=''){

		$value = $postdata['sno'];
		$companyId = $postdata['company_id'];
		$csvFileName = '';
		$townshipFmdError = [];
		if(!empty($value)){
			$fileDocIdArray = explode(",",$value);

			foreach ($fileDocIdArray as $key => $value) {
				$fileDocId = explode("_",$value);
				$processData[$fileDocId[0]]['docType'][] = isset($fileDocId[1]) ? $fileDocId[1]: '';
				$processData[$fileDocId[0]]['hiddenDocType'] = isset($fileDocId[2]) ? $fileDocId[2]: '';
				//fmd_township_division
				$processData[$fileDocId[0]]['townshipDivisionValue'] = $this->checkTownShip($postdata['fmd_township_division'], $fileDocId[0]);
			
				//$fileMainDataId[] = isset($fileDocId[0]) ? $fileDocId[0]: '';
				//$fileDocType[] = isset($fileDocId[1]) ? $fileDocId[1]: '';
			}

			// data process
			$processRecords = $this->phisicalDocumentUpdates($processData, $DocumentReceived);

			if(is_array($processRecords))
			{
				//===================== generete csv file data & name to export data====================//

				$townshipFmdError = isset($processRecords['townshipFmdError']) ? $processRecords['townshipFmdError'] : '';
				$fileDocType = isset($processRecords['processDocType']) ? $processRecords['processDocType'] : '';
				$fileMainDataId = isset($processRecords['processFmdId']) ? $processRecords['processFmdId'] : '';

				// get unique comapnyid from post records file main data
				if(empty($companyId)){
					$companyId = $this->FilesMainData->distinctCompanyByfilesId($fileMainDataId);
				}
				
				$partnerMapData = $this->FilesVendorAssignment->partnerExportFields($companyId,'cef_fieldid4CHI','checkinsheet');
				$partnerMapFields = $partnerMapData['partnerMapFields'];
				$csvNamePrifix = $partnerMapData['csvNamePrifix'];

				//$querymapfields for both condition map fields found or not
				$listRecord = $this->FilesVendorAssignment->searchByFileMainIdDocType($fileMainDataId,$fileDocType, $partnerMapFields);

				if(array_key_exists(0,$listRecord['records'])){
					//send only headers from headerParams
					$csvFileName = $this->CustomPagination->recordExport($listRecord['records'],array_keys($listRecord['headerParams']),$csvNamePrifix,'export');
				}
				//===================== generete csv file to export====================//	
				
				if($DocumentReceived == 'Y')
				{
					$this->Flash->success(__('Physical document received !! <br> Download sheet from blue Download bar!!'), ['escape'=>false]);
				}
				if($DocumentReceived == '')
				{
					$this->Flash->success(__('Sheet generated for documents not received!! <br> Download sheet from blue Download bar!!'), ['escape'=>false]);
				}
				
				if(!empty($townshipFmdError)){
					$this->Flash->error(__('Please select township/division for below records. The County has multiple township/division!!'), ['escape'=>false]);
				}
				
			}
		}
		
		return ['csvFileName'=>$csvFileName, 'townshipFmdError'=>$townshipFmdError];
		
	}

 
	private function phisicalDocumentUpdates(array $processData, $DocumentReceived='')
	{

		$processRecords = [];$fmd_township_division = '';
		 
		foreach($processData as $fmd_id=>$docTypesarr)
		{
			// township division check for records
			$fmd_township_division = isset($docTypesarr['townshipDivisionValue']) ? $docTypesarr['townshipDivisionValue'] : '';
 
			$townShipData = $this->fileTownshipData($fmd_id); 
 
			$townShipCondition = ($townShipData['CountyTownship'] < 2 || $fmd_township_division != "" || $townShipData['TownshipDivision'] != "");

			if($townShipCondition){
	
				// update township
				if($townShipData['TownshipDivision'] != ""){
					$this->FilesMainData->updateFMDByFmdId($fmd_id, ['TownshipDivision' =>$fmd_township_division]);
				}
 
				// update document 
				if(count($docTypesarr['docType']) > 1){

					if(in_array($docTypesarr['hiddenDocType'], $docTypesarr['docType'])){

						foreach($docTypesarr['docType'] as $newdt)
						{
							$newdt = $this->setDocType($newdt);
							$processRecords['processFmdId'][] = $fmd_id;
							$processRecords['processDocType'][] = $newdt;
							
							// One same , and other differant
							if($newdt != $docTypesarr['hiddenDocType'])
							{
								// doc type not same
								$exists = $this->FilesVendorAssignment->exists(['RecId' => $fmd_id, 'TransactionType' => $newdt]);
								if(!$exists){
									//new value NOT exist
									// insert checkin data
									$this->FilesVendorAssignment->insertNewCheckinData($fmd_id,$newdt,$this->currentUser->user_id,$DocumentReceived);
									// insert public 
									$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, 'Checkin: Record Inserted','Fva',true);

								}else{
									// new value but exist // update same rows
									$arr = $this->FilesVendorAssignment->updateCheckInData($newdt,$DocumentReceived,$fmd_id);

									// update others
									$this->updateOtherRecords($fmd_id, $newdt, $docTypesarr['hiddenDocType']);

									// public data 
									$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, 'Checkin: Record Updated','Fva',true);
								}
							}
							else
							{
								// same doctype
								$arr = $this->FilesVendorAssignment->updateCheckInData($newdt,$DocumentReceived,$fmd_id,$docTypesarr['hiddenDocType']);
								// public data 
								$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, 'Checkin: Record Updated','Fva',true);
							}

							if($DocumentReceived == 'Y'){ 
								$this->FilesQcData->insertNewQcData($fmd_id, $newdt, $this->currentUser->user_id);
								$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, 'Checkin: Record Document Received Status','Fqcd',true);
							}else{
								// remove punblic note model
								$this->deleteOtherRecords($fmd_id, $newdt, $is_pop=true);
							}
						}

					}else{  //if(in_array)

						foreach($docTypesarr['docType'] as $newdt)
						{
							$newdt = $this->setDocType($newdt);
							$processRecords['processFmdId'][] = $fmd_id;
							$processRecords['processDocType'][] = $newdt;
							// All other differant
							 $this->FilesVendorAssignment->insertNewCheckinData($fmd_id,$newdt,$this->currentUser->user_id,$DocumentReceived);

							//delete record with doctype	
							$this->deleteOtherRecords($fmd_id, $docTypesarr['hiddenDocType']);

							// public data 
							$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, 'Checkin: Record Updated','Fva',true);

							if($DocumentReceived == 'Y'){ 
								$this->FilesQcData->insertNewQcData($fmd_id, $newdt, $this->currentUser->user_id);
								$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, 'Checkin: Record Document Received','Fqcd',false);
							}else{
								// pop public note model
								$this->deleteOtherRecords($fmd_id, $newdt, $is_pop=true);
							}
						}
					}

				} //if(count($docTypesarr))
				else{

					// doc type value is one 
					foreach($docTypesarr['docType'] as $newdt)
					{
						$newdt = $this->setDocType($newdt);
						$processRecords['processFmdId'][] = $fmd_id;
						$processRecords['processDocType'][] = $newdt;
						
						if($newdt != $docTypesarr['hiddenDocType'])
						{
					 
							//if(!$exists){
								 // update checkin data couse only one value pass
								$this->FilesVendorAssignment->updateCheckInData($newdt,$DocumentReceived,$fmd_id,$docTypesarr['hiddenDocType']);

								// update others
								$this->updateOtherRecords($fmd_id, $newdt, $docTypesarr['hiddenDocType']);

								// public data 
								$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, 'Checkin: Record Updated','Fva',true);
							//}
						}
						else
						{
							// same doctype
							$arr = $this->FilesVendorAssignment->updateCheckInData($newdt,$DocumentReceived,$fmd_id,$docTypesarr['hiddenDocType']);
							// public data 
							$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, 'Checkin: Record Updated','Fva',true);
						}

						if($DocumentReceived == 'Y'){ 
							$this->FilesQcData->insertNewQcData($fmd_id, $newdt, $this->currentUser->user_id);
							$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, 'Checkin: Record Document Received','Fqcd',true);
						}else{
							// pop public note model
							$this->deleteOtherRecords($fmd_id, $newdt, $is_pop=true);
						}
					}
				} // else
	
			} // townshipDataCondition
			else{
				$processRecords['townshipFmdError'][] = $fmd_id;
				//$townshipError = true;
			}
		}

		// return processed filemainId and docType
		return $processRecords;
		
	}

	// old data delete from table using fmdId and docType(old)
	public function deleteOtherRecords($fmdId, $doctype, $is_pop=false){
		 
		($is_pop) ? array_pop($this->otherModelName) : $this->otherModelName;
 
		$doctypeArr =$this->explodeDocType($doctype); 
		 
		foreach($this->otherModelName as $modelName){
			$this->loadModel($modelName); 

			$entity = '';
			if(!empty($doctypeArr)){
				foreach($doctypeArr as $doc){
					$entity = $this->$modelName->find()->where(['RecId'=>$fmdId, 'TransactionType'=>$doc])->first();
					 
					 if(!empty($entity)){
						try {
							$this->$modelName->deleteOrFail($entity);
						} catch (\Cake\ORM\Exception\PersistenceFailedException $e) {
							echo $e->getEntity();
						}
					 }
					
				}  
			}
			 
		}
		return true;
	}
	

    /**
     * Delete method
     *
     * @param string|null $id Files Checkin Data id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        //$this->request->allowMethod(['post', 'delete']);
		$FilesVendorAssignment = $this->FilesVendorAssignment->get($id);

          if ($this->FilesVendorAssignment->delete($FilesVendorAssignment)) {
			// delete row from main data if deleted records is last records from check in.
			$countMainData = $this->FilesVendorAssignment->countByFileId($FilesVendorAssignment->RecId);
			if($countMainData < 1){
				$this->FilesMainData->deleteAll(['Id'=>$FilesVendorAssignment->RecId]);
			}
			
			// delete related records from other table.
			$this->deleteOtherRecords($FilesVendorAssignment->RecId,  $FilesVendorAssignment->TransactionType);
			
            $this->Flash->success(__('The files checkin data has been deleted.'));
        } else {
            $this->Flash->error(__('The files checkin data could not be deleted. Please, try again.'));
        } 
		
        return $this->redirect(['action' => 'index']);
    }

	// new doc type  Update from table using fmdId and docType(old)
	public function updateOtherRecords($fmdId, $doctype, $oldDocType, $is_pop=false){
		 
		$oldDocType =$this->explodeDocType($oldDocType); 
		($is_pop) ? array_pop($this->otherModelName) : $this->otherModelName;
		foreach($this->otherModelName as $modelName){
			$this->loadModel($modelName);
			$this->$modelName->updateAll(['TransactionType' => $doctype], ['RecId'=>$fmdId, 'TransactionType IN'=>$oldDocType]);
		}
		return true;
	}

	private function fileTownshipData($fmdId=null){
		 
		$fileTownshipData = $this->FilesMainData->getFieldsByfileId($fmdId, ['County', 'State','TownshipDivision']);
		 
		$countTownship = $this->CountyMst->countTownshipDivision($fileTownshipData['State'], $fileTownshipData['County']);

		$fileTownshipData['CountyTownship'] = $countTownship;

		return $fileTownshipData;
	}


	public function checkinRecordsSheet(array $postData = [],  $documentRecieved ='all')
	{
		//from url
		$getQuery = $this->request->getQuery();
		if(isset($getQuery) && !empty($getQuery) && empty($postData)){
			$this->autoRender = false;
			$postData = $this->request->getQuery();
			$getLimit = explode('-',$postData['limit']);
			unset($postData['limit']);
		}
		
		if(isset($postData['generateSheetBtn'])){ unset($postData['generateSheetBtn']); }
		
		$companyId = $this->setCompanyId($postData);
		$fromdate  = $postData['fromdate'];
		$todate    = $postData['todate'];
		
		// send only company id and search field
		//$querymapfields for both condition map fields found or not
		$pdata = $this->postDataCondition(['formdata'=>$postData, 'draw' => 1, 'order'=>null], true);
		
		//========== generate csv file data & name to export data ===============//	
		
		if(isset($postData['checkAll']) && !empty($postData['checkAll'])){
			$selectedIds = $postData['checkAll'];
			$query = $this->setFilterQuery($postData, $pdata, $documentRecieved, $selectedIds);
		}else{
			$query = $this->setFilterQuery($postData, $pdata, $documentRecieved);
		}
		
		/********************* NEW CHANGE *******************************/
		$callType = 'form';
		// call from link
		$limitPrifix = '';
		
		if(!empty($getQuery) && is_array($getLimit)){
			// add limit prifix to csv file name
			$limitPrifix = "_".($getLimit[0]+1)."-".($getLimit[0] + $getLimit[1]);

			$callType = 'link';
			
			// add limit to query
			$query = $query->limit($getLimit[1])->offset($getLimit[0]);
		}
		
		$resultQuery = $this->FilesVendorAssignment->generateQuery($query);
		
		$countRows = 0; // link 
		if($callType == 'form'){
			$countRows = $this->FilesVendorAssignment->getQueryCountResult($resultQuery['query'], 'count');
		}
		
		// add csvNamePrifix to result array
		if($countRows <= ROWLIMIT){
			$resultQuery['companyId'] = $companyId;
			$resultQuery['limitPrifix'] = $limitPrifix;
			// generate CSV sheet to download
			$this->generateCsvSheet($resultQuery, $callType);
			
		}else{
			$pagelink = Router::url(['controller'=>$this->name,'action'=>'checkinRecordsSheet', '?'=>['companyId'=>$companyId ,'fromdate'=>$fromdate, 'todate'=>$todate]]);
			// generate CSV link to download call from component
			$pdfDownloadLinks = '1'; //$this->CustomPagination->generateCsvLink($countRows,$pagelink);

			if(!empty($pdfDownloadLinks)){
				$this->set('pdfDownloadLinks',$pdfDownloadLinks);
				$this->Flash->success(__('Records sheet links listed!!'));
			}else{
				$this->Flash->error(__('Records not found!!'));
			}
		}
	}
	
	
	private function setFilterQuery($requestFormdata, $pdata, $documentReceived='', $selectedIds=null){
		//=====================filter conditions===============================================
		//------DocumentReceived -------------
		$whereCondition = ['fva.vendorid in' => ['0']];
		
		if($documentReceived == "dr"){
			$whereCondition = ['fva.vendorid > ' => '0'];
		}
		if($documentReceived == "rejected"){
			$whereCondition = ['fqcd.status !=' => 'OK'];
		}
		if($documentReceived == "all"){
			$whereCondition = [];
		} 
		//------ DocumentReceived End -------------

		// date fields start
		if(isset($requestFormdata['fromdate'])){ // && !empty($requestFormdata['fromdate'])
			$fromdate = $requestFormdata['fromdate'];
		}
		if(isset($requestFormdata['todate'])){ // && !empty($requestFormdata['todate'])
			$todate = $requestFormdata['todate'];
		}
	
		/* if(isset($requestFormdata['FileStartDate'])){ // && !empty($requestFormdata['FileStartDate'])
			$FileStartDate = $requestFormdata['FileStartDate'];
		}
		if(isset($requestFormdata['FileEndDate'])){ // && !empty($requestFormdata['FileEndDate'])
			$FileEndDate = $requestFormdata['FileEndDate'];
		} */
		
		$cm_partner_cmp = ($this->user_Gateway) ? 'Yes': '';
		if(isset($requestFormdata['cm_partner_cmp']) && !empty($requestFormdata['cm_partner_cmp'])){
			$cm_partner_cmp = $requestFormdata['cm_partner_cmp'];
		}
		
		// for records sheet of only selected records
		if(!is_null($selectedIds)){
			$selectedIds = $this->CustomPagination->setOnlyRecordIds($selectedIds, $requestFormdata);
			$whereCondition = 	array_merge($whereCondition, ['fva.RecId IN' => $selectedIds['fmd'], 'fva.TransactionType IN' => $selectedIds['doc']]);
		}

		// date fields end
		//=====================filter conditions===============================================
		// set condtion for partner view 
		$whereCondition = $this->addCompanyToQuery($whereCondition);
		//if($documentReceived == "rejected"){$pdata['condition']['fields'][] = 'fqcd.status';}
		$query = $this->FilesVendorAssignment->filecheckinQuery($whereCondition, $pdata, $cm_partner_cmp);
		
		if(isset($fromdate) && isset($todate)){
 
			//$query = $this->FilesVendorAssignment->dateBetween($query, $fromdate, $todate, 'fcd.CheckInProcessingDate');
			$query = $this->FilesVendorAssignment->dateBetween($query, $fromdate, $todate, 'fva.date_updated');
			//debug($query); 
 
		}

		return $query;
	}

    private function setFilterQueryAol($requestFormdata, $pdata, $documentReceived='', $selectedIds=null){
		//$whereCondition = [];
		$whereCondition = ['faol.RecId IS' => null];
		if($documentReceived == "pending"){
			$whereCondition = ['faol.RecId IS' => null];
		}
		if($documentReceived == "pre_aol_status"){
			$whereCondition = ['faol.pre_aol_status' => 'Y'];
		}
		if($documentReceived == "final_aol_status"){
			$whereCondition = ['faol.final_aol_status' => 'Y'];
		}

		// date fields start
		if(isset($requestFormdata['fromdate'])){ // && !empty($requestFormdata['fromdate'])
			$fromdate = $requestFormdata['fromdate'];
		}
		if(isset($requestFormdata['todate'])){ // && !empty($requestFormdata['todate'])
			$todate = $requestFormdata['todate'];
		}

		$cm_partner_cmp = ($this->user_Gateway) ? 'Yes': '';
		if(isset($requestFormdata['cm_partner_cmp']) && !empty($requestFormdata['cm_partner_cmp'])){
			$cm_partner_cmp = $requestFormdata['cm_partner_cmp'];
		}

		// for records sheet of only selected records
		if(!is_null($selectedIds)){
			$selectedIds = $this->CustomPagination->setOnlyRecordIds($selectedIds, $requestFormdata);
			$whereCondition = 	array_merge($whereCondition, ['fva.RecId IN' => $selectedIds['fmd'], 'fva.TransactionType IN' => $selectedIds['doc'], 'fva.vendorid <>' => 0]);
		}
		$whereCondition = $this->addCompanyToQuery($whereCondition);

	    $query = $this->FilesVendorAssignment->filecheckinQueryAol($whereCondition, $pdata, $cm_partner_cmp);

		if(isset($fromdate) && isset($todate)){
			$query = $this->FilesVendorAssignment->dateBetween($query, $fromdate, $todate, 'fva.date_updated');
		}
		return $query;
	}

    private function setFilterQueryAtt($requestFormdata, $pdata, $documentReceived='', $selectedIds=null){
		$whereCondition = ['IFNULL(faa.vendorid, 0) = ' => '0'];

		if($documentReceived == "pending"){
			$whereCondition = ['IFNULL(faa.vendorid, 0) = ' => '0'];
		}
		if($documentReceived == "assigned"){
			$whereCondition = ['faa.vendorid >' => '0'];
		}
		if($documentReceived == "all"){
			$whereCondition = [];
		}

		// date fields start
		if(isset($requestFormdata['fromdate'])){ // && !empty($requestFormdata['fromdate'])
			$fromdate = $requestFormdata['fromdate'];
		}
		if(isset($requestFormdata['todate'])){ // && !empty($requestFormdata['todate'])
			$todate = $requestFormdata['todate'];
		}

		$cm_partner_cmp = ($this->user_Gateway) ? 'Yes': '';
		if(isset($requestFormdata['cm_partner_cmp']) && !empty($requestFormdata['cm_partner_cmp'])){
			$cm_partner_cmp = $requestFormdata['cm_partner_cmp'];
		}

		// for records sheet of only selected records
		if(!is_null($selectedIds)){
			$selectedIds = $this->CustomPagination->setOnlyRecordIds($selectedIds, $requestFormdata);
			$whereCondition = 	array_merge($whereCondition, ['fva.RecId IN' => $selectedIds['fmd'], 'fva.TransactionType IN' => $selectedIds['doc']]);
		}
		$whereCondition = $this->addCompanyToQuery($whereCondition);

		$query = $this->FilesVendorAssignment->filecheckinQueryAtt($whereCondition, $pdata, $cm_partner_cmp);

		if(isset($fromdate) && isset($todate)){
			$query = $this->FilesVendorAssignment->dateBetween($query, $fromdate, $todate, 'fva.date_updated');
		}
		return $query;
	}

    private function setFilterQueryEss($requestFormdata, $pdata, $documentReceived='', $selectedIds=null){
		$whereCondition = ['IFNULL(fea.vendorid, 0) = ' => '0'];

		if($documentReceived == "pending"){
			$whereCondition = ['IFNULL(fea.vendorid, 0) = ' => '0'];
		}
		if($documentReceived == "assigned"){
			$whereCondition = ['fea.vendorid >' => '0'];
		}
		if($documentReceived == "all"){
			$whereCondition = [];
		}

		// date fields start
		if(isset($requestFormdata['fromdate'])){ // && !empty($requestFormdata['fromdate'])
			$fromdate = $requestFormdata['fromdate'];
		}
		if(isset($requestFormdata['todate'])){ // && !empty($requestFormdata['todate'])
			$todate = $requestFormdata['todate'];
		}

		$cm_partner_cmp = ($this->user_Gateway) ? 'Yes': '';
		if(isset($requestFormdata['cm_partner_cmp']) && !empty($requestFormdata['cm_partner_cmp'])){
			$cm_partner_cmp = $requestFormdata['cm_partner_cmp'];
		}

		// for records sheet of only selected records
		if(!is_null($selectedIds)){
			$selectedIds = $this->CustomPagination->setOnlyRecordIds($selectedIds, $requestFormdata);
			$whereCondition = 	array_merge($whereCondition, ['fva.RecId IN' => $selectedIds['fmd'], 'fva.TransactionType IN' => $selectedIds['doc']]);
		}
		$whereCondition = $this->addCompanyToQuery($whereCondition);

		$query = $this->FilesVendorAssignment->filecheckinQueryEss($whereCondition, $pdata, $cm_partner_cmp);

		if(isset($fromdate) && isset($todate)){
			$query = $this->FilesVendorAssignment->dateBetween($query, $fromdate, $todate, 'fva.date_updated');
		}
		return $query;
	}

	public function postDataCondition(array $postData, $fields=false){ 
		//remove/pop extra fields

	   if(!$fields){
		   array_shift($this->columns_alise);
		   unset($this->columns_alise['Actions']);

		   $this->columns_alise["SrNo"] = "fmd.Id";
		   $this->columns_alise["checkinId"] = "fva.Id";
		   $this->columns_alise["DocumentTitle"] = "dtm.Title";
		   
	   }else{
		   $this->columns_alise = [];
		   $this->columns_alise["checkinId"] = "fva.Id";
		   
	   }
	   $this->columns_alise["ClientCompName"] = "cpm.cm_comp_name";
	   //$this->columns_alise["lock_status"] = "fva.Id";
	   
	   $this->CustomPagination->setPaginationData(['request'=>$postData,
													'columns'=>$this->columnsorder, 
													'columnAlise'=>$this->columns_alise,
													'modelName'=>$this->name
												   ]);
	   
	   $pdata = $this->CustomPagination->getQueryData();

	   if($fields){
		   unset($pdata['condition']['limit']);
		   unset($pdata['condition']['offset']);
		   //$pdata['condition']['limit'] = MAXLIMIT;
	   }

	   return $pdata;
   }
   
	// step for datatable config : 5 main step
	public function ajaxListIndex(){

		$this->autoRender = false;
		 
		$documentReceived = '';
		$formdata = $this->request->getData('formdata');
		//$DocumentReceived = $formdata['DocumentReceived'];
	 
		if(isset($formdata['DocumentReceived'])){
			$documentReceived = $formdata['DocumentReceived'];
			unset($formdata['DocumentReceived']);
		} 
 
		$pdata = $this->postDataCondition($this->request->getData()); 
		// Remove query limit for all records
		if($pdata['condition']['limit'] == -1){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']);
		} // END
		$query = $this->setFilterQuery($formdata, $pdata, $documentReceived);
 	 	//print_r($query);exit;
		// no groupby add
		$recordsTotal = $this->FilesVendorAssignment->getQueryCountResult($query, 'count', false);
		
		$data  =  $this->FilesVendorAssignment->getQueryCountResult($query);
		//pr($data);
		// customise as per condition for differant datatable use.
		$data = $this->getCustomParshingData($data);
		//echo '<pre>';
		//print_r($data); exit;
		$response = array(
						"draw" => intval($pdata['draw']),
						"recordsTotal" => intval($recordsTotal),
						"recordsFiltered" => intval($recordsTotal),
						"data" => $data
					);

		echo json_encode($response); 
		exit;
	}

    public function ajaxListAolindex(){
		$this->autoRender = false;

		$documentReceived = '';
		$formdata = $this->request->getData('formdata');
		//$DocumentReceived = $formdata['DocumentReceived'];

		if(isset($formdata['DocumentReceived'])){
			$documentReceived = $formdata['DocumentReceived'];
			unset($formdata['DocumentReceived']);
		}

		$pdata = $this->postDataCondition($this->request->getData());
		// Remove query limit for all records
		if($pdata['condition']['limit'] == -1){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']);
		} // END
		$query = $this->setFilterQueryAol($formdata, $pdata, $documentReceived);

		// no groupby add
		$recordsTotal = $this->FilesVendorAssignment->getQueryCountResult($query, 'count', false);

		$data  =  $this->FilesVendorAssignment->getQueryCountResult($query);

		// customise as per condition for differant datatable use.
		$data = $this->getCustomParshingDataAol($data);

		$response = array(
						"draw" => intval($pdata['draw']),
						"recordsTotal" => intval($recordsTotal),
						"recordsFiltered" => intval($recordsTotal),
						"data" => $data
					);

		echo json_encode($response);
		exit;
	}

    public function ajaxListAttindex(){
		$this->autoRender = false;

		$documentReceived = '';
		$formdata = $this->request->getData('formdata');
		//$DocumentReceived = $formdata['DocumentReceived'];

		if(isset($formdata['DocumentReceived'])){
			$documentReceived = $formdata['DocumentReceived'];
			unset($formdata['DocumentReceived']);
		}

		$pdata = $this->postDataCondition($this->request->getData());
		// Remove query limit for all records
		if($pdata['condition']['limit'] == -1){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']);
		} // END
		$query = $this->setFilterQueryAtt($formdata, $pdata, $documentReceived);

		// no groupby add
		$recordsTotal = $this->FilesVendorAssignment->getQueryCountResult($query, 'count', false);

		$data  =  $this->FilesVendorAssignment->getQueryCountResult($query);

		// customise as per condition for differant datatable use.
		$data = $this->getCustomParshingDataAtt($data);

		$response = array(
						"draw" => intval($pdata['draw']),
						"recordsTotal" => intval($recordsTotal),
						"recordsFiltered" => intval($recordsTotal),
						"data" => $data
					);

		echo json_encode($response);
		exit;
	}

    public function ajaxListEssindex(){
		$this->autoRender = false;

		$documentReceived = '';
		$formdata = $this->request->getData('formdata');
		//$DocumentReceived = $formdata['DocumentReceived'];

		if(isset($formdata['DocumentReceived'])){
			$documentReceived = $formdata['DocumentReceived'];
			unset($formdata['DocumentReceived']);
		}

		$pdata = $this->postDataCondition($this->request->getData());
		// Remove query limit for all records
		if($pdata['condition']['limit'] == -1){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']);
		} // END
		$query = $this->setFilterQueryEss($formdata, $pdata, $documentReceived);

		// no groupby add
		$recordsTotal = $this->FilesVendorAssignment->getQueryCountResult($query, 'count', false);

		$data  =  $this->FilesVendorAssignment->getQueryCountResult($query);

		// customise as per condition for differant datatable use.
		$data = $this->getCustomParshingDataEss($data);

		$response = array(
						"draw" => intval($pdata['draw']),
						"recordsTotal" => intval($recordsTotal),
						"recordsFiltered" => intval($recordsTotal),
						"data" => $data
					);

		echo json_encode($response);
		exit;
	}
 
	// step for datatable config : 6 custome data action
    private function getCustomParshingData(array $data){

		// manual
		foreach ($data as $key => $value) {

			$checkboxdisabled = (($value["lock_status"] == 1) ? 'disabled' : '');
			if($this->user_Gateway){
				$value['Checkbox'] = '<input type="checkbox" '.$checkboxdisabled.' id="checkAll[]" name="checkAll[]" value="'.$key.'_'.$value["checkinId"].'" class="checkSingle"/><input type="hidden" id="fmdId_'.$key.'" name="fmdId[]" value="'.$value["SrNo"].'"/><input type="hidden" id="docTypeId_'.$key.'" name="docTypeId[]" value="'.$value["TransactionType"].'" />';
				
				
				
				$value['Actions'] = $this->CustomPagination->getUserActionButtons($this->name,$value,['checkinId','SrNo','TransactionType'], 'common');
				
				$value['TransactionType'] = $value["TransactionType"].' ( '.$value["DocumentTitle"].' )';    

			}else{
				$value['Checkbox'] = '<input type="checkbox" '.$checkboxdisabled.' name="checkAll[]" value="'.$value["SrNo"].'" class="checkSingle"  />';
				
				
				// onclick="getBarcode(this,'.$value["FileNo"].','.$value["TransactionType"].');"
				$value['Actions'] = $this->CustomPagination->getActionButtons($this->name,$value,['SrNo','FileNo','checkinId','TransactionType','lock_status'],$prefix = "",$hideViewButton = 1);
				
				// documentTypeHidden not use in index
				//$value['TransactionType'] = '<input type="hidden" name="documentTypeHidden" value="'.$value["TransactionType"].'"><input style="width:40px;" type="text" name="docTypeInput" class="docinput" value="'.$value["TransactionType"].'" /> ( '.$value["DocumentTitle"].' )';  
				$value['TransactionType'] = '<input type="hidden" name="documentTypeHidden" value="'.$value["TransactionType"].'">'.$value["TransactionType"].' ( '.$value["DocumentTitle"].' )';  

			}
			$dtColor = (($value['DocStatus']=='Y') ? 'style="color:#f17171;"' : "");
            $fmd_data = $this->FilesVendorAssignment->find()->where(['RecId' => $value["SrNo"]])->first();

			$value['DocStatus'] = (($fmd_data['vendorid']>0)?'Assigned':'Not Assigned');

			$value['PartnerFileNumber'] = $value['PartnerFileNumber'] . ((!empty($value['ClientCompName'])) ? ' ( '.$value['ClientCompName'].' )': '' );
		 	$value['DateAdded'] = (($value['DateAdded']!='')? '<span '.$dtColor.'>'.date('Y-m-d H:i:s', strtotime((string)$value['DateAdded'])).'</span>' : '');
			
			$value['Extension'] =  (($value['Extension']!='')? date('Y-m-d', strtotime($value['Extension'])) : '');
		}
	
		unset($data['checkinId']);
		return $data;

	}

    private function getCustomParshingDataAol(array $data){

		// manual
		foreach ($data as $key => $value) {

			$checkboxdisabled = (($value["lock_status"] == 1) ? 'disabled' : '');
			if($this->user_Gateway){
				$value['Checkbox'] = '<input type="checkbox" '.$checkboxdisabled.' id="checkAll[]" name="checkAll[]" value="'.$key.'_'.$value["checkinId"].'" class="checkSingle"/><input type="hidden" id="fmdId_'.$key.'" name="fmdId[]" value="'.$value["SrNo"].'"/><input type="hidden" id="docTypeId_'.$key.'" name="docTypeId[]" value="'.$value["TransactionType"].'" />';



				$value['Actions'] = $this->CustomPagination->getUserActionButtons($this->name,$value,['checkinId','SrNo','TransactionType'], 'common');

				$value['TransactionType'] = $value["TransactionType"].' ( '.$value["DocumentTitle"].' )';

			}else{
				$value['Checkbox'] = '<input type="checkbox" '.$checkboxdisabled.' name="checkAll[]" value="'.$value["SrNo"].'" class="checkSingle"  />';


				// onclick="getBarcode(this,'.$value["FileNo"].','.$value["TransactionType"].');"
				$value['Actions'] = $this->CustomPagination->getActionButtons($this->name,$value,['SrNo','FileNo','checkinId','TransactionType','lock_status'],$prefix = "",$hideViewButton = 10);

				// documentTypeHidden not use in index
				//$value['TransactionType'] = '<input type="hidden" name="documentTypeHidden" value="'.$value["TransactionType"].'"><input style="width:40px;" type="text" name="docTypeInput" class="docinput" value="'.$value["TransactionType"].'" /> ( '.$value["DocumentTitle"].' )';  
				$value['TransactionType'] = '<input type="hidden" name="documentTypeHidden" value="'.$value["TransactionType"].'">'.$value["TransactionType"].' ( '.$value["DocumentTitle"].' )';  

			}
			$dtColor = (($value['DocStatus']=='Y') ? 'style="color:#f17171;"' : "");

            $aol_data = $this->FilesAolAssignment->find()->where(['RecId' => $value["SrNo"]])->first();
			$value['DocStatus'] = (($aol_data['pre_aol_status']=='Y')?'Yes':'No');
			$value['DocStatus1'] = (($aol_data['final_aol_status']=='Y')?'Yes':'No');
			$value['DocStatus2'] = (($aol_data['submit_aol_status']=='Y')?'Yes':'No');
			$value['PartnerFileNumber'] = $value['PartnerFileNumber'] . ((!empty($value['ClientCompName'])) ? ' ( '.$value['ClientCompName'].' )': '' );
		 	$value['DateAdded'] = (($value['DateAdded']!='')? '<span '.$dtColor.'>'.date('Y-m-d H:i:s', strtotime((string)$value['DateAdded'])).'</span>' : '');

			$value['Extension'] =  (($value['Extension']!='')? date('Y-m-d', strtotime($value['Extension'])) : '');
		}

		unset($data['checkinId']);
		return $data;

	}

    private function getCustomParshingDataAtt(array $data){

		// manual
		foreach ($data as $key => $value) {

			$checkboxdisabled = (($value["lock_status"] == 1) ? 'disabled' : '');
			if($this->user_Gateway){
				$value['Checkbox'] = '<input type="checkbox" '.$checkboxdisabled.' id="checkAll[]" name="checkAll[]" value="'.$key.'_'.$value["checkinId"].'" class="checkSingle"/><input type="hidden" id="fmdId_'.$key.'" name="fmdId[]" value="'.$value["SrNo"].'"/><input type="hidden" id="docTypeId_'.$key.'" name="docTypeId[]" value="'.$value["TransactionType"].'" />';



				$value['Actions'] = $this->CustomPagination->getUserActionButtons($this->name,$value,['checkinId','SrNo','TransactionType'], 'common');

				$value['TransactionType'] = $value["TransactionType"].' ( '.$value["DocumentTitle"].' )';

			}else{
				$value['Checkbox'] = '<input type="checkbox" '.$checkboxdisabled.' name="checkAll[]" value="'.$value["SrNo"].'" class="checkSingle"  />';


				// onclick="getBarcode(this,'.$value["FileNo"].','.$value["TransactionType"].');"
				$value['Actions'] = $this->CustomPagination->getActionButtons($this->name,$value,['SrNo','FileNo','checkinId','TransactionType','lock_status'],$prefix = "",$hideViewButton = 1);

				// documentTypeHidden not use in index
				//$value['TransactionType'] = '<input type="hidden" name="documentTypeHidden" value="'.$value["TransactionType"].'"><input style="width:40px;" type="text" name="docTypeInput" class="docinput" value="'.$value["TransactionType"].'" /> ( '.$value["DocumentTitle"].' )';
				$value['TransactionType'] = '<input type="hidden" name="documentTypeHidden" value="'.$value["TransactionType"].'">'.$value["TransactionType"].' ( '.$value["DocumentTitle"].' )';

			}
			$dtColor = (($value['DocStatus']=='Y') ? 'style="color:#f17171;"' : "");

            $att_data = $this->FilesAttorneyAssignment->find()->where(['RecId' => $value["SrNo"]])->count();
			$value['DocStatus'] = (($att_data>'0')?'Y':'N');
			//$value['DocStatus1'] = (($att_data['final_aol_status']=='Y')?'Y':'N');
			$value['PartnerFileNumber'] = $value['PartnerFileNumber'] . ((!empty($value['ClientCompName'])) ? ' ( '.$value['ClientCompName'].' )': '' );
		 	$value['DateAdded'] = (($value['DateAdded']!='')? '<span '.$dtColor.'>'.date('Y-m-d H:i:s', strtotime((string)$value['DateAdded'])).'</span>' : '');

			$value['Extension'] =  (($value['Extension']!='')? date('Y-m-d', strtotime($value['Extension'])) : '');
		}

		unset($data['checkinId']);
		return $data;

	}

    private function getCustomParshingDataEss(array $data){

		// manual
		foreach ($data as $key => $value) {

			$checkboxdisabled = (($value["lock_status"] == 1) ? 'disabled' : '');
			if($this->user_Gateway){
				$value['Checkbox'] = '<input type="checkbox" '.$checkboxdisabled.' id="checkAll[]" name="checkAll[]" value="'.$key.'_'.$value["checkinId"].'" class="checkSingle"/><input type="hidden" id="fmdId_'.$key.'" name="fmdId[]" value="'.$value["SrNo"].'"/><input type="hidden" id="docTypeId_'.$key.'" name="docTypeId[]" value="'.$value["TransactionType"].'" />';



				$value['Actions'] = $this->CustomPagination->getUserActionButtons($this->name,$value,['checkinId','SrNo','TransactionType'], 'common');

				$value['TransactionType'] = $value["TransactionType"].' ( '.$value["DocumentTitle"].' )';

			}else{
				$value['Checkbox'] = '<input type="checkbox" '.$checkboxdisabled.' name="checkAll[]" value="'.$value["SrNo"].'" class="checkSingle"  />';


				// onclick="getBarcode(this,'.$value["FileNo"].','.$value["TransactionType"].');"
				$value['Actions'] = $this->CustomPagination->getActionButtons($this->name,$value,['SrNo','FileNo','checkinId','TransactionType','lock_status'],$prefix = "",$hideViewButton = 1);

				// documentTypeHidden not use in index
				//$value['TransactionType'] = '<input type="hidden" name="documentTypeHidden" value="'.$value["TransactionType"].'"><input style="width:40px;" type="text" name="docTypeInput" class="docinput" value="'.$value["TransactionType"].'" /> ( '.$value["DocumentTitle"].' )';
				$value['TransactionType'] = '<input type="hidden" name="documentTypeHidden" value="'.$value["TransactionType"].'">'.$value["TransactionType"].' ( '.$value["DocumentTitle"].' )';

			}
			$dtColor = (($value['DocStatus']=='Y') ? 'style="color:#f17171;"' : "");

            $ess_data = $this->FilesEscrowAssignment->find()->where(['RecId' => $value["SrNo"]])->count();
			$value['DocStatus'] = (($ess_data>'0')?'Y':'N');
			//$value['DocStatus1'] = (($att_data['final_aol_status']=='Y')?'Y':'N');
			$value['PartnerFileNumber'] = $value['PartnerFileNumber'] . ((!empty($value['ClientCompName'])) ? ' ( '.$value['ClientCompName'].' )': '' );
		 	$value['DateAdded'] = (($value['DateAdded']!='')? '<span '.$dtColor.'>'.date('Y-m-d H:i:s', strtotime((string)$value['DateAdded'])).'</span>' : '');

			$value['Extension'] =  (($value['Extension']!='')? date('Y-m-d', strtotime($value['Extension'])) : '');
		}

		unset($data['checkinId']);
		return $data;

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
	
	/**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    /*public function add($companyId = null)
    {
		// set page title
        $pageTitle = 'Add Record';
        $this->set(compact('pageTitle'));
		$company_mst_id = $this->request->getData('company_id');
    	if( isset($company_mst_id) && !empty($company_mst_id))
			$companyId = $company_mst_id;

		$partnerMapFields = '';
		if(!empty($companyId)){
			$partnerMapFields = $this->CompanyFieldsMap->partnerMapFields($companyId);
		}

		$sqlmainInt = [];

		$NATFileNumber = '';
        $FilesVendorAssignment = $this->FilesVendorAssignment->newEmptyEntity();

        if ($this->request->is('post')) {
			$saveOpenBtn = $this->request->getData('saveOpenBtn');
			$saveBtn = $this->request->getData('saveBtn');

			if(isset($saveOpenBtn) || isset($saveBtn))
			{
				// check State and County for records
				$CountyDetails = $this->CountyMst->getCountyTitleByStateCounty($this->request->getData('State'),$this->request->getData('County'));

				$CountyDetailsCount = ((is_array($CountyDetails) || $CountyDetails instanceof Countable) ? count($CountyDetails) : 0);

				if($CountyDetailsCount >= 1)
				{
					// ADD NEW RECORDS
					$NATFileNumber = $this->setNATFileNumber();
					$postData = $this->request->getData();

					$sqlmainInt = $this->FilesVendorAssignment->sqlDataInsertByForm($postData, $this->currentUser->user_id,$CountyDetails['cm_file_enabled'],$NATFileNumber);

					// new add
					$filesMainDataEnter = $this->FilesMainData->newEmptyEntity();
					$filesMainDataEnter = $this->FilesMainData->patchEntity($filesMainDataEnter, $sqlmainInt);

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
							$this->FilesVendorAssignment->insertNewCheckinData($insId, $docType, $this->currentUser->user_id, $this->request->getData('DocumentReceived'));

							// ###### Coding for adding/updating -public_notes
							// need to ask
							$regarding = (empty(trim($this->request->getData('Regarding')))) ? 'Checkin: Record Added': trim($this->request->getData('Regarding'));
							$this->PublicNotes->insertNewPublicNotes($insId, $docType, $this->currentUser->user_id, $regarding, 'Fva'); //$this->request->getData('Public_Internal')
							//##### End of Coding for adding/updating -public_notes
						}

						$this->Flash->success(__('Records added successfully !!'));

						if(isset($saveBtn)){
							// redirect to listing page
							return $this->redirect(['action' => 'index']); // need to index
						}else{
							// open another new add page
							return $this->redirect(['action' => 'add']);
						}
					}

					$this->Flash->error(__('The files checkin data could not be saved. Please, try again.'));
				}
				else
				{
					$this->Flash->error(__('Please Enter Correct County Name.'));
				}
				// come from GOTO function
				errordisplay:{
					$this->Flash->error(__('Please Check Date Format.'));
				}
			}

			// for open new add form
			$NATFileNumber = $this->setNATFileNumber();
        }

		$CountyList = $this->CountyMst->getCountyTitleByState();
		//pr($CountyList); exit;
		$StateList = $this->States->StateListArray();

		$companyMsts = $this->CompanyMst->companyListArray();

		$this->set('partner_id', $companyId);
		$this->set('NATFileNumber', $NATFileNumber);

        $this->set(compact('FilesVendorAssignment', 'companyMsts','partnerMapFields','StateList','CountyList')); // 'documentList'
        $this->set('_serialize', ['FilesVendorAssignment']);
    }*/

    public function addHoursExample($hours){
        // Get the current time
        $currentTime = Time::now();
        // Add the specified number of hours
        $nextTime = $currentTime->addHours($hours);
        // Return the result or use it as needed
        return $nextTime;
    }

    public function add(){
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            //foreach($data['search_criteria'] as $k=>$s){
                $natServicesTable = TableRegistry::getTableLocator()->get('NatServices');
                $natService = $natServicesTable->find()->where(['id' => $data['search_criteria']])->first();

                if ($natService) {
                    $turn_around_datetime = ($natService['turn_around_time'] !== "NA")
                        ? $this->addHoursExample((int)$natService['turn_around_time'])->i18nFormat('yyyy-MM-dd HH:mm:ss')
                        : "";

                    $data['search_criteria_name'] = $natService->sub_service;
                    $data['turn_around_datetime'] = $turn_around_datetime;
                } else {
                    $this->Flash->error(__('No record found in nat_services with id ' . $s['search_criteria'] . '.'));
                    return;
                }
            //}
            //$data['search_criteria'] = implode(',',$data['search_criteria']);
            //$data['search_criteria_name'] = implode(', ',$data['search_criteria_name']);
            //echo "<pre>";print_r($data);echo "</pre>";exit;
            // Fetch vendor details
            $this->loadModel('Vendors');
            $vendor = $this->Vendors->get_vendor($data['vendorid']);
            $data['vendor'] = $vendor->name;
            $vendorEmail = $vendor->main_contact_email; // Get vendor's email

            // Check if RecId is set and contains a comma
            $savedData = [];
            $isSaved = false;

            if (!empty($data['RecId']) && strpos($data['RecId'], ',') !== false) {
                $recIds = explode(',', $data['RecId']);

                foreach ($recIds as $recId) {
                    $newData = $data;
                    $newData['RecId'] = trim($recId);
                    $data['RecId']= $recId;

                    $existingRecord = $this->FilesVendorAssignment->find()->where(['RecId' => $recId])->first();
                    //echo "<pre>";print_r($existingRecord);echo "</pre>";
                    //echo "<pre>";print_r($data);echo "</pre>";exit;
                    if ($existingRecord) {
                        $filesVendorAssignment = $this->FilesVendorAssignment->patchEntity($existingRecord, $data);
                    } else {
                        // If record doesn't exist, create a new one
                        $filesVendorAssignment = $this->FilesVendorAssignment->newEmptyEntity();
                        $filesVendorAssignment = $this->FilesVendorAssignment->patchEntity($filesAolAssignment, $data);
                    }
                    if ($this->FilesVendorAssignment->save($filesVendorAssignment)) {
                        $savedData[] = $newData;
                        $isSaved = true;
                    } else {
                        $this->Flash->error(__('Failed to save record for RecId: ' . $recId));
                    }
                }
            } else {
                //$filesVendorAssignment = $this->FilesVendorAssignment->newEntity($data);
                $existingRecord = $this->FilesVendorAssignment->find()->where(['RecId' => $data['RecId']])->first();
                  //echo "<pre>";print_r($existingRecord);echo "</pre>";
                  if ($existingRecord) {
                      // If record exists, patch data for editing
                      $filesVendorAssignment = $this->FilesVendorAssignment->patchEntity($existingRecord, $data);
                  } else {
                      // If record doesn't exist, create a new one
                      $filesVendorAssignment = $this->FilesVendorAssignment->newEmptyEntity();
                      $filesVendorAssignment = $this->FilesVendorAssignment->patchEntity($filesAolAssignment, $data);
                  }

                if ($this->FilesVendorAssignment->save($filesVendorAssignment)) {
                    $savedData[] = $data;
                    $isSaved = true;
                } else {
                    $this->Flash->error(__('Failed to save the record.'));
                }
            }
            // If at least one record is saved, generate CSV & send email
            if ($isSaved) {
                $csvFilename = $this->saveCsvFile($savedData); // Generate CSV
                $csvFilenameOnly = basename($csvFilename);
                $downloadLink = $this->request->getAttribute('webroot') . 'files/export/vendor_assigned/' . $csvFilenameOnly;

                // Send email with CSV attachment
                if(isset($data['delivery_type'])){
                    if (!empty($vendorEmail)) {
                        if(isset($data['cc_nat_vendor'])){
                            $this->sendEmail($vendorEmail, $downloadLink, $csvFilename, $data['cc_nat_vendor_email']);
                        }else{
                            $this->sendEmail($vendorEmail, $downloadLink, $csvFilename);
                        }
                    }
                }

                // Success message with download link
                $this->Flash->success(__('Record(s) have been saved successfully. <a class="btn btn-primary" href="' . $downloadLink . '" download>Please click here to Download</a>'), ['escape' => false]);
            }

            return $this->redirect(['controller' => 'FilesVendorAssignment', 'action' => 'index']);
        }
    }

    public function attadd(){

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            //foreach($data['search_criteria'] as $k=>$s){
              //echo "<pre>";print_r($s);echo "</pre>";exit;
                $natServicesTable = TableRegistry::getTableLocator()->get('NatServices');
                $natService = $natServicesTable->find()->where(['id' => $data['search_criteria']])->first();

                if ($natService) {
                    $turn_around_datetime = ($natService['turn_around_time'] !== "NA")
                        ? $this->addHoursExample((int)$natService['turn_around_time'])->i18nFormat('yyyy-MM-dd HH:mm:ss')
                        : "";

                    $data['search_criteria_name'] = $natService->sub_service;
                    $data['turn_around_datetime'] = $turn_around_datetime;
                } else {
                    $this->Flash->error(__('No record found in nat_services with id ' . $s['search_criteria'] . '.'));
                    return;
                }
            //}
            //$data['search_criteria'] = implode(',',$data['search_criteria']);
            //$data['search_criteria_name'] = implode(', ',$data['search_criteria_name']);
            //echo "<pre>";print_r($data);echo "</pre>";exit;
            // Fetch vendor details
            $this->loadModel('Vendors');
            $vendor = $this->Vendors->get_vendor($data['vendorid']);
            $data['vendor'] = $vendor->name;
            $vendorEmail = $vendor->main_contact_email; // Get vendor's email

            // Check if RecId is set and contains a comma
            $savedData = [];
            $isSaved = false;

            if (!empty($data['RecId']) && strpos($data['RecId'], ',') !== false) {
                $recIds = explode(',', $data['RecId']);

                foreach ($recIds as $recId) {
                    $newData = $data;
                    $newData['RecId'] = trim($recId);
                    $data['RecId']= $recId;

                    $existingRecord = $this->FilesAttorneyAssignment->find()->where(['RecId' => $recId])->first();
                    if ($existingRecord) {
                        $filesVendorAssignment = $this->FilesAttorneyAssignment->patchEntity($existingRecord, $data);
                    } else {
                        // If record doesn't exist, create a new one
                        $filesVendorAssignment = $this->FilesAttorneyAssignment->newEmptyEntity();
                        $filesVendorAssignment = $this->FilesAttorneyAssignment->patchEntity($filesVendorAssignment, $data);
                    }

                    if ($this->FilesAttorneyAssignment->save($filesVendorAssignment)) {
                        $savedData[] = $newData;
                        $isSaved = true;
                    } else {
                        $this->Flash->error(__('Failed to save record for RecId: ' . $recId));
                    }
                }
            } else {
                //$filesVendorAssignment = $this->FilesVendorAssignment->newEntity($data);
                $existingRecord = $this->FilesAttorneyAssignment->find()->where(['RecId' => $data['RecId']])->first();
                  //echo "<pre>";print_r($existingRecord);echo "</pre>";
                  if ($existingRecord) {
                      // If record exists, patch data for editing
                      $filesVendorAssignment = $this->FilesAttorneyAssignment->patchEntity($existingRecord, $data);
                  } else {
                      // If record doesn't exist, create a new one
                      $filesVendorAssignment = $this->FilesAttorneyAssignment->newEmptyEntity();
                      $filesVendorAssignment = $this->FilesAttorneyAssignment->patchEntity($filesVendorAssignment, $data);
                  }

                if ($this->FilesAttorneyAssignment->save($filesVendorAssignment)) {
                    $savedData[] = $data;
                    $isSaved = true;
                } else {
                    $this->Flash->error(__('Failed to save the record.'));
                }
            }
            //echo "<pre>";print_r($data);echo "</pre>";exit;
            // If at least one record is saved, generate CSV & send email
            if ($isSaved) {
                $csvFilename = $this->saveCsvFile($savedData, 'att'); // Generate CSV
                $csvFilenameOnly = basename($csvFilename);
                $downloadLink = $this->request->getAttribute('webroot') . 'files/export/vendor_assigned/' . $csvFilenameOnly;

                // Send email with CSV attachment
                if(isset($data['delivery_type'])){
                    if (!empty($vendorEmail)) {
                        $this->sendEmail($vendorEmail, $downloadLink, $csvFilename, '', 'att');
                    }
                }

                // Success message with download link
                //$this->Flash->success(__('Record(s) have been saved successfully. Please click <a href="' . $downloadLink . '" download>here</a> to Download.'), ['escape' => false]);
                $this->Flash->success(__('Record(s) have been saved successfully. <a class="btn btn-primary" href="' . $downloadLink . '" download>Please click here to Download</a>'), ['escape' => false]);
            }

            return $this->redirect(['controller' => 'FilesVendorAssignment', 'action' => 'attindex']);
        }
    }

    public function essadd(){
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            //foreach($data['search_criteria'] as $k=>$s){
              //echo "<pre>";print_r($s);echo "</pre>";exit;
                $natServicesTable = TableRegistry::getTableLocator()->get('NatServices');
                $natService = $natServicesTable->find()
                    ->where(['id' => $data['search_criteria']])
                    ->first();

                if ($natService) {
                    $turn_around_datetime = ($natService['turn_around_time'] !== "NA")
                        ? $this->addHoursExample((int)$natService['turn_around_time'])->i18nFormat('yyyy-MM-dd HH:mm:ss')
                        : "";

                    $data['search_criteria_name'] = $natService->sub_service;
                    $data['turn_around_datetime'] = $turn_around_datetime;
                } else {
                    $this->Flash->error(__('No record found in nat_services with id ' . $s['search_criteria'] . '.'));
                    return;
                }
            //}
            //$data['search_criteria'] = implode(',',$data['search_criteria']);
            //$data['search_criteria_name'] = implode(', ',$data['search_criteria_name']);
            //echo "<pre>";print_r($data);echo "</pre>";exit;
            // Fetch vendor details
            $this->loadModel('Vendors');
            $vendor = $this->Vendors->get_vendor($data['vendorid']);
            $data['vendor'] = $vendor->name;
            $vendorEmail = $vendor->main_contact_email; // Get vendor's email

            // Check if RecId is set and contains a comma
            $savedData = [];
            $isSaved = false;

            if (!empty($data['RecId']) && strpos($data['RecId'], ',') !== false) {
                $recIds = explode(',', $data['RecId']);

                foreach ($recIds as $recId) {
                    $newData = $data;
                    $newData['RecId'] = trim($recId);
                    $data['RecId']= $recId;
                    $existingRecord = $this->FilesEscrowAssignment->find()->where(['RecId' => $recId])->first();
                    if ($existingRecord) {
                        // If record exists, patch data for editing
                        $filesVendorAssignment = $this->FilesEscrowAssignment->patchEntity($existingRecord, $data);
                    } else {
                        // If record doesn't exist, create a new one
                        $filesVendorAssignment = $this->FilesEscrowAssignment->newEmptyEntity();
                        $filesVendorAssignment = $this->FilesEscrowAssignment->patchEntity($filesVendorAssignment, $data);
                    }

                    if ($this->FilesEscrowAssignment->save($filesVendorAssignment)) {
                        $savedData[] = $newData;
                        $isSaved = true;
                    } else {
                        $this->Flash->error(__('Failed to save record for RecId: ' . $recId));
                    }
                }
            } else {
                //$filesVendorAssignment = $this->FilesVendorAssignment->newEntity($data);
                $existingRecord = $this->FilesEscrowAssignment->find()->where(['RecId' => $data['RecId']])->first();
                  //echo "<pre>";print_r($existingRecord);echo "</pre>";
                  if ($existingRecord) {
                      // If record exists, patch data for editing
                      $filesVendorAssignment = $this->FilesEscrowAssignment->patchEntity($existingRecord, $data);
                  } else {
                      // If record doesn't exist, create a new one
                      $filesVendorAssignment = $this->FilesEscrowAssignment->newEmptyEntity();
                      $filesVendorAssignment = $this->FilesEscrowAssignment->patchEntity($filesVendorAssignment, $data);
                  }

                if ($this->FilesEscrowAssignment->save($filesVendorAssignment)) {
                    $savedData[] = $data;
                    $isSaved = true;
                } else {
                    $this->Flash->error(__('Failed to save the record.'));
                }
            }
            //echo "<pre>";print_r($data);echo "</pre>";exit;
            // If at least one record is saved, generate CSV & send email
            if ($isSaved) {
                $csvFilename = $this->saveCsvFile($savedData, 'ess'); // Generate CSV
                $csvFilenameOnly = basename($csvFilename);
                $downloadLink = $this->request->getAttribute('webroot') . 'files/export/vendor_assigned/' . $csvFilenameOnly;

                // Send email with CSV attachment
                if(isset($data['delivery_type'])){
                    if (!empty($vendorEmail)) {
                        $this->sendEmail($vendorEmail, $downloadLink, $csvFilename, '', 'att');
                    }
                }

                // Success message with download link
                $this->Flash->success(__('Record(s) have been saved successfully. <a class="btn btn-primary" href="' . $downloadLink . '" download>Please click here to Download</a>'), ['escape' => false]);
            }

            return $this->redirect(['controller' => 'FilesVendorAssignment', 'action' => 'essindex']);
        }
    }
    
    public function addRecords($companyId = null)
    {
		// set page title
        $pageTitle = 'Add Record';
        $this->set(compact('pageTitle'));
		$company_mst_id = $this->request->getData('company_id');
    	if( isset($company_mst_id) && !empty($company_mst_id))
			$companyId = $company_mst_id;

		$partnerMapFields = '';
		if(!empty($companyId)){
			$partnerMapFields = $this->CompanyFieldsMap->partnerMapFields($companyId);
		}

		$sqlmainInt = [];

		$NATFileNumber = '';
        $FilesVendorAssignment = $this->FilesVendorAssignment->newEmptyEntity();

        if ($this->request->is('post')) {
			$saveOpenBtn = $this->request->getData('saveOpenBtn');
			$saveBtn = $this->request->getData('saveBtn');

			if(isset($saveOpenBtn) || isset($saveBtn))
			{
				// check State and County for records
				$CountyDetails = $this->CountyMst->getCountyTitleByStateCounty($this->request->getData('State'),$this->request->getData('County'));

				$CountyDetailsCount = ((is_array($CountyDetails) || $CountyDetails instanceof Countable) ? count($CountyDetails) : 0);

				if($CountyDetailsCount >= 1)
				{
					// ADD NEW RECORDS
					$NATFileNumber = $this->setNATFileNumber();
					$postData = $this->request->getData();

					$sqlmainInt = $this->FilesVendorAssignment->sqlDataInsertByForm($postData, $this->currentUser->user_id,$CountyDetails['cm_file_enabled'],$NATFileNumber);

					// new add
					$filesMainDataEnter = $this->FilesMainData->newEmptyEntity();
					$filesMainDataEnter = $this->FilesMainData->patchEntity($filesMainDataEnter, $sqlmainInt);

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
							$this->FilesVendorAssignment->insertNewCheckinData($insId, $docType, $this->currentUser->user_id, $this->request->getData('DocumentReceived'), 0, $vendorid, $criteria);
							//$this->FilesVendorAssignment->insertNewCheckinData($insId, $docType, $this->currentUser->user_id, $this->request->getData('DocumentReceived'));
                            //echo "<pre>";print_r($postData);echo "</pre>";exit;
							// ###### Coding for adding/updating -public_notes
							// need to ask
							$regarding = (empty(trim($this->request->getData('Regarding')))) ? 'Checkin: Record Added': trim($this->request->getData('Regarding'));
							$this->PublicNotes->insertNewPublicNotes($insId, $docType, $this->currentUser->user_id, $regarding, 'Fva'); //$this->request->getData('Public_Internal')
							//##### End of Coding for adding/updating -public_notes
						}

						$this->Flash->success(__('Records added successfully !!'));

						if(isset($saveBtn)){
							// redirect to listing page
							return $this->redirect(['action' => 'index']); // need to index
						}else{
							// open another new add page
							return $this->redirect(['action' => 'add']);
						}
					}

					$this->Flash->error(__('The files data could not be saved. Please, try again.'));
				}
				else
				{
					$this->Flash->error(__('Please Enter Correct County Name.'));
				}
				// come from GOTO function
				errordisplay:{
					$this->Flash->error(__('Please Check Date Format.'));
				}
			}

			// for open new add form
			$NATFileNumber = $this->setNATFileNumber();
        }

		$CountyList = $this->CountyMst->getCountyTitleByState();
		//pr($CountyList); exit;
		$StateList = $this->States->StateListArray();

		$companyMsts = $this->CompanyMst->companyListArray();
        
        $TransactionTypeList = $this->TransactionTypeMst->transactionTypeListing();
        
		$this->set('partner_id', $companyId);
		$this->set('NATFileNumber', $NATFileNumber);

        $this->loadModel('Vendors');
        $vendorlist = $this->Vendors->ListArray();
        $vendor_id = 12;


        $this->set(compact('FilesVendorAssignment', 'companyMsts','partnerMapFields','StateList','CountyList', 'vendorlist','TransactionTypeList')); // 'documentList' ,'vendor_services'
        $this->set('_serialize', ['FilesVendorAssignment']);
    }

    public function getVendorService(){
        $this->request->allowMethod(['post']);
        $this->loadModel('Vendors');
        $vendor_id = $this->request->getData('file_id');
        $vendor_services = $this->Vendors->get_vendor_services($vendor_id);
        //echo "<pre>";print_r($vendor_services);echo "</pre>";exit;
        $vendor_services_html="<label>Services: </label>";
        foreach ($vendor_services as $result) {
            if($result->time == "NA"){ $time="NA"; }else if($result->time == 0){ $time="Same Day"; }else{ $time = $result->time." Hours"; }
            $vendor_services_html .= '<div class="form-group">
            <input type="radio" class="form-check-input" id="search_criteria"  name="search_criteria" value="'.$result->id.'">
            <label for="service2">'.$result->sub_service.'</label>
        </div>';
        }
        return $this->response->withType('application/json')->withStringBody(json_encode(['success' => true, 'email' => $vendor_services_html]));
    }

    public function getEssService(){
        $this->request->allowMethod(['post']);
        $this->loadModel('Vendors');
        $vendor_id = $this->request->getData('file_id');
        $vendor_services = $this->Vendors->get_ess_services($vendor_id);
        //echo "<pre>";print_r($vendor_services);echo "</pre>";exit;
        $vendor_services_html="<label>Services: </label>";
        foreach ($vendor_services as $result) {
            if($result->time == "NA"){ $time="NA"; }else if($result->time == 0){ $time="Same Day"; }else{ $time = $result->time." Hours"; }
            $vendor_services_html .= '<div class="form-group">
            <input type="radio" class="form-check-input" id="search_criteria"  name="search_criteria" value="'.$result->id.'">
            <label for="service2">'.$result->sub_service.'</label>
        </div>';
        }
        return $this->response->withType('application/json')->withStringBody(json_encode(['success' => true, 'email' => $vendor_services_html]));
    }

    public function getAttService(){
        $this->request->allowMethod(['post']);
        $this->loadModel('Vendors');
        $vendor_id = $this->request->getData('file_id');
        $vendor_services = $this->Vendors->get_att_services($vendor_id);
        //echo "<pre>";print_r($vendor_services);echo "</pre>";exit;
        $vendor_services_html="<label>Services: </label>";
        foreach ($vendor_services as $result) {
            if($result->time == "NA"){ $time="NA"; }else if($result->time == 0){ $time="Same Day"; }else{ $time = $result->time." Hours"; }
            $vendor_services_html .= '<div class="form-group">
            <input type="radio" class="form-check-input" id="search_criteria"  name="search_criteria" value="'.$result->id.'">
            <label for="service2">'.$result->sub_service.'</label>
        </div>';
        }
        return $this->response->withType('application/json')->withStringBody(json_encode(['success' => true, 'email' => $vendor_services_html]));
    }

    /*private function sendEmail($recipientEmail, $csvDownloadLink, $csvFilePath, $cc=""){
        $mailer = new Mailer();
        $mailer->setEmailFormat('html')
            ->setFrom(['vsurjuse@tiuconsulting.com' => 'Nat'])
            ->setTo($recipientEmail)
            ->setSubject('Nat - Vendor Assigned')
            ->setAttachments([$csvFilePath]) // Attach CSV file
            ->deliver("
                <p>Dear Vendor,</p>
                <p>Records has been assigned successfully.</p>
                <p>Please find the attached CSV file.</p>
                <p>Best regards,</p>
                <p>NAT</p>
            ");
    }*/

    private function sendEmail($recipientEmail, $csvDownloadLink, $csvFilePath, $cc = "", $flag = ""){
        $subject = 'National Attorney Title - Vendor Assigned';
        if($flag=="att"){ $subject = 'National Attorney Title - Attorney Assigned';}

        $mailer = new Mailer();
        $mailer->setEmailFormat('html')
            //->setFrom(['vsurjuse@tiuconsulting.com' => 'National Attorney Title'])
            ->setTo($recipientEmail)
            ->setSubject($subject)
            ->setAttachments([$csvFilePath]); // Attach CSV file

        if (!empty($cc)) {
            $mailer->setCc($cc);
        }

        $mailer->deliver("
            <p>Hello Sir/Madam,</p>
            <p>Records have been assigned successfully.</p>
            <p>Please find the attached CSV file.</p>
            <p>Best regards,</p>
            <p>National Attorney Title</p>
        ");
    }

    private function sendEmailToClient($recipientEmail, $pdfFilePath, $cc = ""){
        $mailer = new Mailer();
        // Comment below line after going live
        //$recipientEmail = 'vsurjuse@tiuconsulting.com';
        $mailer->setEmailFormat('html')
            //->setFrom(['vsurjuse@tiuconsulting.com' => 'National Attorney Title'])
            ->setTo($recipientEmail)
            ->setSubject('National Attorney Title - Final Signed AOL')
            ->setAttachments([$pdfFilePath]); // Attach CSV file

        if (!empty($cc)) {
            $mailer->setCc($cc);
        }

        $mailer->deliver("
            <p>Dear Client,<br></p>
            <p>Records have been successfully verified.</p>
            <p>Please find the attachment for more details.<br></p>
            <p>Best regards,</p>
            <p>National Attorney Title</p>
        ");
    }

    private function saveCsvFile($dataArray, $flag="") {
        $name = "Vendor";
        if($flag == 'att'){$name = "Attorney";}
        if($flag == 'ess'){$name = "Escrow";}
        $csvDir = WWW_ROOT . 'files/export/vendor_assigned/';
        $timestamp = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
        $csvFile = $csvDir . 'vendor_' . $timestamp . '.csv';

        if (!is_dir($csvDir)) {
            mkdir($csvDir, 0777, true);
        }

        $file = fopen($csvFile, 'w');
        if ($file) {
            $fmd_fields = ['FileStartDate','NATFileNumber','PartnerFileNumber','TransactionType','PurchasePriceConsideration','LoanAmount','LoanNumber','StreetNumber','StreetName','City','State','County','Zip','APNParcelNumber','LegalDescriptionShortLegal','Grantors','GrantorFirstName1','GrantorLastName1','GrantorFirstName2','GrantorLastName2','GrantorMaritalStatus','GrantorCorporationName','Grantees','GranteeFirstName1','GranteeLastName1','GranteeFirstName2','GranteeLastName2','GranteeMaritalStatus','GranteeCorporationName'];

            $fva_fields = ['VendorAssignedDate'];
            //$fva_fields = ['VendorAssignedDate','vendor','search_criteria_name'];

            // Writing first and second row
            fputcsv($file, [$name, $dataArray[0]['vendor']]); // First row
            fputcsv($file, ['Search Criteria', $dataArray[0]['search_criteria_name']]); // Second row

            // Writing an empty row to ensure headers start from the fourth row
            fputcsv($file, []);

            // Write the fourth row with field names (column headers)
            fputcsv($file, array_merge($fva_fields, $fmd_fields));

            foreach ($dataArray as $row) {
                $fmd_data = $this->FilesMainData->find()->where(['Id' => $row['RecId']])->first();
                $fva_data = $this->FilesVendorAssignment->find()->where(['RecId' => $row['RecId']])->first();

                if (isset($fva_data['date_updated'])) {
                    $fva_data['VendorAssignedDate'] = $fva_data['date_updated'];
                    unset($fva_data['date_updated']); // Remove old key
                }

                $row1 = [];
                foreach ($fva_fields as $field) {
                    $row1[] = isset($fva_data[$field]) ? $fva_data[$field] : '';
                }

                foreach ($fmd_fields as $field) {
                    $row1[] = isset($fmd_data[$field]) ? $fmd_data[$field] : '';
                }

                fputcsv($file, $row1);
            }
            fclose($file);
        }
        return $csvFile; // Return file path for download link
    }

    private function saveCsvFileOld($dataArray) {
        $csvDir = WWW_ROOT . 'files/export/vendor_assigned/';
        $timestamp = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
        $csvFile = $csvDir . 'vendor_' . $timestamp . '.csv';

        if (!is_dir($csvDir)) {
            mkdir($csvDir, 0777, true);
        }

        $file = fopen($csvFile, 'w');
        if ($file) {
            $fmd_fields = ['FileStartDate','NATFileNumber','PartnerFileNumber','TransactionType','PurchasePriceConsideration','LoanAmount','LoanNumber','StreetNumber','StreetName','City','State','County','Zip','APNParcelNumber','LegalDescriptionShortLegal','Grantors','GrantorFirstName1','GrantorLastName1','GrantorFirstName2','GrantorLastName2','GrantorMaritalStatus','GrantorCorporationName','Grantees','GranteeFirstName1','GranteeLastName1','GranteeFirstName2','GranteeLastName2','GranteeMaritalStatus','GranteeCorporationName'];

            $fva_fields = ['VendorAssignedDate','vendor','search_criteria_name'];

                // Write the first row with field names (column headers)
                fputcsv($file, array_merge($fva_fields,$fmd_fields));
            foreach ($dataArray as $row) {
                $fmd_data = $this->FilesMainData->find()->where(['Id' => $row['RecId']])->first();
                $fva_data = $this->FilesVendorAssignment->find()->where(['RecId' => $row['RecId']])->first();

                //if (is_array($row)) {
                //    foreach ($row as $key => $value) {
                //        fwrite($file, "\"{$key}\",\"{$value}\"\n");
                //    }
                //}
                // Code Added for FMD and FVA data
                if (isset($fva_data['date_updated'])) {
                    $fva_data['VendorAssignedDate'] = $fva_data['date_updated'];
                    unset($fva_data['date_updated']); // Remove old key
                }

                $row1=[];
                foreach ($fva_fields as $field) {
                    $row1[] = isset($fva_data[$field]) ? $fva_data[$field] : '';
                }
                //echo "<pre>";print_r($row1);echo "</pre>";
                foreach ($fmd_fields as $field) {
                    $row1[] = isset($fmd_data[$field]) ? $fmd_data[$field] : '';
                }

                //echo "<pre>";print_r($row1);echo "</pre>";exit;
                fputcsv($file, $row1);
            }
            fclose($file);
        }
        return $csvFile; // Return file path for download link
    }

    function exportToCSV($fmd_data, $fva_data, $filename = 'export.csv') {
        // Rename date_updated to VendorAssignedDate in $fva_data
        if (isset($fva_data['date_updated'])) {
            $fva_data['VendorAssignedDate'] = $fva_data['date_updated'];
            unset($fva_data['date_updated']); // Remove old key
        }

        // Define fields from FilesMainData
        $fmd_fields = [
            'FileStartDate',
            'NATFileNumber',
            'PartnerFileNumber',
            'TransactionType',
            'PurchasePriceConsideration',
            'LoanAmount',
            'LoanNumber',
            'StreetNumber',
            'StreetName',
            'City',
            'State',
            'County',
            'Zip',
            'APNParcelNumber',
            'LegalDescriptionShortLegal',
            'Grantors',
            'GrantorFirstName1',
            'GrantorLastName1',
            'GrantorFirstName2',
            'GrantorLastName2',
            'GrantorMaritalStatus',
            'GrantorCorporationName',
            'Grantees',
            'GranteeFirstName1',
            'GranteeLastName1',
            'GranteeFirstName2',
            'GranteeLastName2',
            'GranteeMaritalStatus',
            'GranteeCorporationName'
        ];

        // Define fields from FilesVendorAssignment
        $fva_fields = [
            'VendorAssignedDate', // Updated key
            'vendorid',
            'vendor',
            'search_criteria',
            'search_criteria_name',
            'delivery_type',
            'turn_around_datetime'
        ];

        // Open file for writing
        $file = fopen($filename, 'w');

        // Write the first row with field names (column headers)
        fputcsv($file, array_merge($fmd_fields, $fva_fields));

        // Prepare the second row with corresponding values
        $row = [];

        // Populate data from fmd_data
        foreach ($fmd_fields as $field) {
            $row[] = isset($fmd_data[$field]) ? $fmd_data[$field] : '';
        }

        // Populate data from fva_data
        foreach ($fva_fields as $field) {
            $row[] = isset($fva_data[$field]) ? $fva_data[$field] : '';
        }

        // Write the values row
        fputcsv($file, $row);

        // Close the file
        fclose($file);

        echo "CSV file '$filename' has been created successfully.";
    }

    /*private function saveCsvFile($dataArray){
        $csvDir = WWW_ROOT . 'files/export/vendor_assigned/';

        // Generate a unique filename with timestamp
        $timestamp = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
        $csvFile = $csvDir . 'vendor_' . $timestamp . '.csv';

        // Ensure the directory exists
        if (!is_dir($csvDir)) {
            mkdir($csvDir, 0777, true);
        }

        // Define the required CSV column order
        $csvColumns = [
            'vendor', 'search_criteria_name'
        ];

        // Open file in write mode (new file each time)
        $file = fopen($csvFile, 'w');

        if ($file) {
            // Write headers first
            fputcsv($file, $csvColumns);

            // Write each row as CSV data
            foreach ($dataArray as $row) {
                $csvRow = [];
                foreach ($csvColumns as $column) {
                    $csvRow[] = isset($row[$column]) ? $row[$column] : '';
                }
                fputcsv($file, $csvRow);
            }
            fclose($file);
        }

        return $csvFile; // Return file path for download link
    }*/
	
	public function searchCountyAjax()
	{
		$this->autoRender = false;
		
		$id = $this->request->getData('id');
		$CountyTitle = $this->CountyMst->getCountysByStateName($id);
		
		$towstxtErrorCounty = '<select name="County" class="form-control" required="required"><option value="">Select County</option>';
		foreach($CountyTitle as $key=>$CountyText){
			if($CountyText['cm_title'] != null){   
				$towstxtErrorCounty .= '<option value="'.$CountyText['cm_title'].'"'; 
				$towstxtErrorCounty .= '>'.$CountyText['cm_title'].'</option>';
			}
		}
		$towstxtErrorCounty .= '</select>';
		echo $towstxtErrorCounty; 
		exit;
	}
	
	public $setmaxLRSno='';
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
	
	/**
     * Edit method
     *
     * @param string|null $id Files Checkin Data id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		//$id file check in data
		// set page title
		$pageTitle = 'Edit Record';
		$this->set(compact('pageTitle'));
	 
		$fmd_id = '';
		$companyId ='';
        if ($this->request->is(['patch', 'post', 'put'])) 
		{  
			// file main data id set as hidden
			$fmd_id = $this->request->getData('fmd_id'); 
			$saveBtn = $this->request->getData('saveBtn');
			$saveOpenBtn = $this->request->getData('saveOpenBtn');
			if(isset($saveBtn) || isset($saveOpenBtn))
			{
				// check selected State and County are correct or not
				$CountyDetails = $this->CountyMst->getCountyTitleByStateCounty($this->request->getData('State'),$this->request->getData('County'));
				$CountyDetails = ((is_array($CountyDetails) || $CountyDetails instanceof Countable) ? count($CountyDetails) : 0);
					
				if($CountyDetails >= 1)
				{ 
					// update file main data
					$postData = $this->request->getData();
			 	
					$this->FilesMainData->updateFileMainData($postData,$fmd_id);
				 
					/****************************************/
					//Add document Type and checkin Records
		 		 	$this->editSaveCheckinData($postData);
					/****************************************/  

					$this->Flash->success(__('Records updated successfully !!'));
					$TransactionType = $postData['TransactionType'];
					if(isset($this->request->getParam('pass')[1]) && ($this->request->getParam('pass')[1] == 'complete')){
							return $this->redirect([
								'controller' => 'PublicNotes',
								'action' => 'viewComplete/'.$fmd_id.'/'.$TransactionType/* ,
								'?' => [
									'fmd' => $fmd_id,
									'doctype' => $typeHiddenArr
								] */
							]);
					}else{ 
						return $this->redirect(['action' => 'index']);
					} 

				}
				else
				{
					$this->Flash->error(__('Please enter correct County name.'));
				}
			}
         
        }
		// fetch records from fmd and fcd table
		$FilesVendorAssignment = $this->FilesMainData->getFileMainData($id); // checkIn id
//echo '<pre>';
//print_r($FilesVendorAssignment); exit;
		if(!empty($FilesVendorAssignment)){
			$fmd_id = $FilesVendorAssignment['Id']; // file main data id
			$companyId = $FilesVendorAssignment['company_id']; // need to discuss
			
			$partnerMapFields = $this->CompanyFieldsMap->partnerMapFields($companyId);
			
			$this->set('partner_id', $companyId);
			$this->set('fmd_id', $fmd_id);
		}else{
			$this->Flash->error(__('Please select correct record.'));
			return $this->redirect(['action' => 'index']);exit;
		}
		
		
		$CountyList = $this->CountyMst->getCountyTitleByStateNew($FilesVendorAssignment['State']);
		// convert lower case and ucwords.
		$CountyList = array_change_key_case(array_map('strtolower', $CountyList), CASE_LOWER);
		
		$CountyList = array_combine(
						array_map('ucwords', array_keys($CountyList)), // Convert keys to ucwords
						array_map('ucwords', $CountyList) // Convert values to ucwords
					);
					
		$selectedCounty = strtolower($FilesVendorAssignment['County']);
		$selectedCounty = ucwords($selectedCounty);
		// END
		
		$StateList = $this->States->StateListArray();
		
	    $documentList =  $this->DocumentTypeMst->documentList();
		
		$companyMsts = $this->CompanyMst->companyListArray();
		
		$TransactionTypeList = $this->TransactionTypeMst->transactionTypeListing();
		
        $this->set(compact('FilesVendorAssignment', 'companyMsts','partnerMapFields','StateList','CountyList','documentList','TransactionTypeList','selectedCounty'));
        $this->set('_serialize', ['FilesVendorAssignment']);
		
    }

    public function aoledit($id = null){
		//$id file check in data
		// set page title
		$pageTitle = 'Edit Record';
		$this->set(compact('pageTitle'));
        //echo "<pre>";print_r($this->request->getData());echo "</pre>";exit;
        //$assignments = $this->FilesVendorAssignment->find()->where(['RecId' => $id])->count();
        $assignments = $this->FilesAolAssignment->find()->where(['RecId' => $id])->first();
        $this->set('assignments', $assignments);

        if (!$assignments) {
            $this->Flash->error(__('Record not found.'));
            return $this->redirect(['action' => 'aolindex']);
        }
		$fmd_id = '';
		$companyId ='';
        //echo "<pre>";print_r($this->request->getData());echo "</pre>";exit;
        if ($this->request->is(['patch', 'post', 'put'])){
		    $assignments = $this->FilesAolAssignment->patchEntity($assignments, $this->request->getData());

            // Attempt to save
            if ($this->FilesAolAssignment->save($assignments)) {
                $this->Flash->success(__('Record has been updated successfully.'));
                return $this->redirect(['action' => 'aolindex']); // Redirect after success
            }
            $this->Flash->error(__('Unable to update record. Please try again.'));
			// file main data id set as hidden
			$fmd_id = $this->request->getData('fmd_id');
			$saveBtn = $this->request->getData('saveBtn');
			$saveOpenBtn = $this->request->getData('saveOpenBtn');
			if(isset($saveBtn) || isset($saveOpenBtn))
			{
				// check selected State and County are correct or not
				$CountyDetails = $this->CountyMst->getCountyTitleByStateCounty($this->request->getData('State'),$this->request->getData('County'));
				$CountyDetails = ((is_array($CountyDetails) || $CountyDetails instanceof Countable) ? count($CountyDetails) : 0);

				if($CountyDetails >= 1)
				{
					// update file main data
					$postData = $this->request->getData();

					$this->FilesMainData->updateFileMainData($postData,$fmd_id);

					/****************************************/
					//Add document Type and checkin Records
		 		 	$this->editSaveCheckinData($postData);
					/****************************************/

					$this->Flash->success(__('Records updated successfully !!'));
					$TransactionType = $postData['TransactionType'];
					if(isset($this->request->getParam('pass')[1]) && ($this->request->getParam('pass')[1] == 'complete')){
							return $this->redirect([
								'controller' => 'PublicNotes',
								'action' => 'viewComplete/'.$fmd_id.'/'.$TransactionType/* ,
								'?' => [
									'fmd' => $fmd_id,
									'doctype' => $typeHiddenArr
								] */
							]);
					}else{
						return $this->redirect(['action' => 'index']);
					}

				}
				else
				{
					$this->Flash->error(__('Please enter correct County name.'));
				}
			}

        }
		// fetch records from fmd and fcd table
		$FilesVendorAssignment = $this->FilesMainData->getFileMainData($id); // checkIn id

		if(!empty($FilesVendorAssignment)){
			$fmd_id = $FilesVendorAssignment['Id']; // file main data id
			$companyId = $FilesVendorAssignment['company_id']; // need to discuss

			$partnerMapFields = $this->CompanyFieldsMap->partnerMapFields($companyId);

			$this->set('partner_id', $companyId);
			$this->set('fmd_id', $fmd_id);
		}/*else{
			$this->Flash->error(__('Please select correct record.'));
			return $this->redirect(['action' => 'index']);exit;
		}*/


		$CountyList = $this->CountyMst->getCountyTitleByState($FilesVendorAssignment['State']);

		$StateList = $this->States->StateListArray();

	    $documentList =  $this->DocumentTypeMst->documentList();

		$companyMsts = $this->CompanyMst->companyListArray();

        $this->set(compact('FilesVendorAssignment', 'companyMsts','partnerMapFields','StateList','CountyList','documentList'));
        $this->set('_serialize', ['FilesVendorAssignment']);

    }

    public function attedit($id = null){
		//$id file check in data
		// set page title
		$pageTitle = 'Edit Record';
		$this->set(compact('pageTitle'));
        //echo "<pre>";print_r($this->request->getData());echo "</pre>";exit;
        //$assignments = $this->FilesVendorAssignment->find()->where(['RecId' => $id])->count();
        $assignments = $this->FilesAolAssignment->find()->where(['RecId' => $id])->first();
        $this->set('assignments', $assignments);

        if (!$assignments) {
            $this->Flash->error(__('Record not found.'));
            return $this->redirect(['action' => 'aolindex']);
        }
		$fmd_id = '';
		$companyId ='';
        //echo "<pre>";print_r($this->request->getData());echo "</pre>";exit;
        if ($this->request->is(['patch', 'post', 'put'])){
		    $assignments = $this->FilesAolAssignment->patchEntity($assignments, $this->request->getData());

            // Attempt to save
            if ($this->FilesAolAssignment->save($assignments)) {
                $this->Flash->success(__('Record has been updated successfully.'));
                return $this->redirect(['action' => 'aolindex']); // Redirect after success
            }
            $this->Flash->error(__('Unable to update record. Please try again.'));
			// file main data id set as hidden
			$fmd_id = $this->request->getData('fmd_id');
			$saveBtn = $this->request->getData('saveBtn');
			$saveOpenBtn = $this->request->getData('saveOpenBtn');
			if(isset($saveBtn) || isset($saveOpenBtn))
			{
				// check selected State and County are correct or not
				$CountyDetails = $this->CountyMst->getCountyTitleByStateCounty($this->request->getData('State'),$this->request->getData('County'));
				$CountyDetails = ((is_array($CountyDetails) || $CountyDetails instanceof Countable) ? count($CountyDetails) : 0);

				if($CountyDetails >= 1)
				{
					// update file main data
					$postData = $this->request->getData();

					$this->FilesMainData->updateFileMainData($postData,$fmd_id);

					/****************************************/
					//Add document Type and checkin Records
		 		 	$this->editSaveCheckinData($postData);
					/****************************************/

					$this->Flash->success(__('Records updated successfully !!'));
					$TransactionType = $postData['TransactionType'];
					if(isset($this->request->getParam('pass')[1]) && ($this->request->getParam('pass')[1] == 'complete')){
							return $this->redirect([
								'controller' => 'PublicNotes',
								'action' => 'viewComplete/'.$fmd_id.'/'.$TransactionType/* ,
								'?' => [
									'fmd' => $fmd_id,
									'doctype' => $typeHiddenArr
								] */
							]);
					}else{
						return $this->redirect(['action' => 'index']);
					}

				}
				else
				{
					$this->Flash->error(__('Please enter correct County name.'));
				}
			}

        }
		// fetch records from fmd and fcd table
		$FilesVendorAssignment = $this->FilesMainData->getFileMainData($id); // checkIn id

		if(!empty($FilesVendorAssignment)){
			$fmd_id = $FilesVendorAssignment['Id']; // file main data id
			$companyId = $FilesVendorAssignment['company_id']; // need to discuss

			$partnerMapFields = $this->CompanyFieldsMap->partnerMapFields($companyId);

			$this->set('partner_id', $companyId);
			$this->set('fmd_id', $fmd_id);
		}/*else{
			$this->Flash->error(__('Please select correct record.'));
			return $this->redirect(['action' => 'index']);exit;
		}*/


		$CountyList = $this->CountyMst->getCountyTitleByState($FilesVendorAssignment['State']);

		$StateList = $this->States->StateListArray();

	    $documentList =  $this->DocumentTypeMst->documentList();

		$companyMsts = $this->CompanyMst->companyListArray();

        $this->set(compact('FilesVendorAssignment', 'companyMsts','partnerMapFields','StateList','CountyList','documentList'));
        $this->set('_serialize', ['FilesVendorAssignment']);

    }

    public function essedit($id = null){
		//$id file check in data
		// set page title
		$pageTitle = 'Edit Record';
		$this->set(compact('pageTitle'));
        //echo "<pre>";print_r($this->request->getData());echo "</pre>";exit;
        //$assignments = $this->FilesVendorAssignment->find()->where(['RecId' => $id])->count();
        $assignments = $this->FilesAolAssignment->find()->where(['RecId' => $id])->first();
        $this->set('assignments', $assignments);

        if (!$assignments) {
            $this->Flash->error(__('Record not found.'));
            return $this->redirect(['action' => 'aolindex']);
        }
		$fmd_id = '';
		$companyId ='';
        //echo "<pre>";print_r($this->request->getData());echo "</pre>";exit;
        if ($this->request->is(['patch', 'post', 'put'])){
		    $assignments = $this->FilesAolAssignment->patchEntity($assignments, $this->request->getData());

            // Attempt to save
            if ($this->FilesAolAssignment->save($assignments)) {
                $this->Flash->success(__('Record has been updated successfully.'));
                return $this->redirect(['action' => 'aolindex']); // Redirect after success
            }
            $this->Flash->error(__('Unable to update record. Please try again.'));
			// file main data id set as hidden
			$fmd_id = $this->request->getData('fmd_id');
			$saveBtn = $this->request->getData('saveBtn');
			$saveOpenBtn = $this->request->getData('saveOpenBtn');
			if(isset($saveBtn) || isset($saveOpenBtn))
			{
				// check selected State and County are correct or not
				$CountyDetails = $this->CountyMst->getCountyTitleByStateCounty($this->request->getData('State'),$this->request->getData('County'));
				$CountyDetails = ((is_array($CountyDetails) || $CountyDetails instanceof Countable) ? count($CountyDetails) : 0);

				if($CountyDetails >= 1)
				{
					// update file main data
					$postData = $this->request->getData();

					$this->FilesMainData->updateFileMainData($postData,$fmd_id);

					/****************************************/
					//Add document Type and checkin Records
		 		 	$this->editSaveCheckinData($postData);
					/****************************************/

					$this->Flash->success(__('Records updated successfully !!'));
					$TransactionType = $postData['TransactionType'];
					if(isset($this->request->getParam('pass')[1]) && ($this->request->getParam('pass')[1] == 'complete')){
							return $this->redirect([
								'controller' => 'PublicNotes',
								'action' => 'viewComplete/'.$fmd_id.'/'.$TransactionType/* ,
								'?' => [
									'fmd' => $fmd_id,
									'doctype' => $typeHiddenArr
								] */
							]);
					}else{
						return $this->redirect(['action' => 'index']);
					}

				}
				else
				{
					$this->Flash->error(__('Please enter correct County name.'));
				}
			}

        }
		// fetch records from fmd and fcd table
		$FilesVendorAssignment = $this->FilesMainData->getFileMainData($id); // checkIn id

		if(!empty($FilesVendorAssignment)){
			$fmd_id = $FilesVendorAssignment['Id']; // file main data id
			$companyId = $FilesVendorAssignment['company_id']; // need to discuss

			$partnerMapFields = $this->CompanyFieldsMap->partnerMapFields($companyId);

			$this->set('partner_id', $companyId);
			$this->set('fmd_id', $fmd_id);
		}/*else{
			$this->Flash->error(__('Please select correct record.'));
			return $this->redirect(['action' => 'index']);exit;
		}*/


		$CountyList = $this->CountyMst->getCountyTitleByState($FilesVendorAssignment['State']);

		$StateList = $this->States->StateListArray();

	    $documentList =  $this->DocumentTypeMst->documentList();

		$companyMsts = $this->CompanyMst->companyListArray();

        $this->set(compact('FilesVendorAssignment', 'companyMsts','partnerMapFields','StateList','CountyList','documentList'));
        $this->set('_serialize', ['FilesVendorAssignment']);

    }

	private function editSaveCheckinData($postData){
		$regarding = (empty(trim($postData['Regarding']))) ? 'Record Updated':trim($postData['Regarding']);
		 
		$docTypesarr =$this->explodeDocType($postData['TransactionType']); 
		$typeHiddenArr = $postData['documentTypeHidden'];
		 
		$fmd_id = $postData['fmd_id']; 
		// post one value 
		if(sizeof($docTypesarr) == 1)
		{   
			$this->saveSingleDocument($postData);
		} 
		// post multiple values
		elseif(sizeof($docTypesarr) > 1)
		{ 
			 // assume typeHiddenArr is single value
			if(in_array($typeHiddenArr,$docTypesarr)) 
			{  
				$this->saveMultiSameDocument($postData);
			}
			else
			{  
				$this->saveFirstDocument($postData);
			} 
		}
		 
		return true;
	}
	
	private function saveSingleDocument($postData){
		$regarding = (empty(trim($postData['Regarding']))) ? 'Record Updated':trim($postData['Regarding']);
		$docTypesarr = $postData['TransactionType']; // explode(',',$postData['TransactionType']);
		//$docTypesarr[0] 
		$docType = $this->setDocType($docTypesarr);

		$typeHiddenArr = $postData['documentTypeHidden'];
		$fmd_id = $postData['fmd_id'];
		
		$countFileCheckIn = $this->FilesVendorAssignment->checkCountByFileIdDoctype($fmd_id, $docType);
		//if hidden doc type is single value then ??? 
		 
		// new doc type
		if($countFileCheckIn < 1)
		{
			 
			// assume typeHiddenArr is single value
			$arr = $this->FilesVendorAssignment->updateCheckInData($docType,$postData['DocumentReceived'],$fmd_id,$typeHiddenArr);

			// update all doctype in other section with new doc type
			$this->updateOtherRecords($fmd_id, $docType, $typeHiddenArr);
		}
		else // same doc type 
		{	
			if($typeHiddenArr != $docType) // assume $typeHiddenArr is single value
			{ 
				//delete record with doctype	
				$this->deleteOtherRecords($fmd_id, $typeHiddenArr);
			}
			else
			{ 
				$arr = $this->FilesVendorAssignment->updateCheckInData($docType,$postData['DocumentReceived'],$fmd_id,$typeHiddenArr);
			}
		}
 
		//insert in QC id document recived is 'Y'
		if($postData['DocumentReceived'] == 'Y'){
			$this->FilesQcData->insertNewQcData($fmd_id, $docType, $this->currentUser->user_id);
			$this->PublicNotes->insertNewPublicNotes($fmd_id, $docType, $this->currentUser->user_id, 'Checkin: Record Document Received Inserted','Fqcd',true);
		}
		
		//********  Coding for adding/updating public_notes *************** 
		$this->PublicNotes->insertNewPublicNotes($fmd_id, $docType, $this->currentUser->user_id, $regarding, 'Fva'); //$postData['Public_Internal']
		 
		return true;

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

	private function saveMultiSameDocument($postData){
		$regarding = (empty(trim($postData['Regarding']))) ? 'Record Updated':trim($postData['Regarding']);
		
		$docTypesarr = $this->explodeDocType($postData['TransactionType']); 
		 
		$typeHiddenArr = $postData['documentTypeHidden'];
		$fmd_id = $postData['fmd_id'];
		
		//other insert
		foreach($docTypesarr as $newdt)
		{
			$newdt = $this->setDocType($newdt);
			
			if($newdt != $typeHiddenArr)
			{
			
				$countFileCheckIn = $this->FilesVendorAssignment->checkCountByFileIdDoctype($fmd_id, $newdt);
		
				if($countFileCheckIn < 1){
					// check for extension NEW
					//$extensionDT  = $this->FilesVendorAssignment->getMainDataByMultiDocType($fmd_id, $newdt, 'Id'); 
					 // insert checkin data
					 $this->FilesVendorAssignment->insertNewCheckinData($fmd_id,$newdt,$this->currentUser->user_id,$postData['DocumentReceived']);
					 
					 //********  Coding for adding/updating public_notes *************** 
					 $this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, $regarding, 'Fva'); //$postData['Public_Internal']
				}
			}else
			{
			
				$arr = $this->FilesVendorAssignment->updateCheckInData($newdt,$postData['DocumentReceived'],$fmd_id,$typeHiddenArr);
				// internal
				$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, $regarding,'Fva'); //$postData['Public_Internal']
 			}

			//insert in QC id document recived is 'Y'
			if($postData['DocumentReceived'] == 'Y'){
				$this->FilesQcData->insertNewQcData($fmd_id, $newdt, $this->currentUser->user_id);
				$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, 'Checkin: Record Document Received','Fqcd',true);
			}
			
		}	// forrach in array
		return true;
	}
	
	private function saveFirstDocument($postData){
		$regarding = (empty(trim($postData['Regarding']))) ? 'Record Updated':trim($postData['Regarding']);
		 
		$docTypesarr =$this->explodeDocType($postData['TransactionType']); 

		$typeHiddenArr = $postData['documentTypeHidden'];
		$fmd_id = $postData['fmd_id'];
		
		$first = 1;		
		foreach($docTypesarr as $newdt)
		{
			$newdt = $this->setDocType($newdt);
			//$countFileCheckIn = $this->FilesVendorAssignment->checkCountByFileIdDoctype($fmd_id, $newdt);
			$exist = $this->FilesVendorAssignment->exists(['RecId' => $fmd_id, 'TransactionType' => $newdt]);
			$alexist = 1;
			if(!$exist)
			{
				$alexist = 0;
				if($first)
				{
					//update files_checkin_data
					// assume typeHiddenArr is single value
					$arr = $this->FilesVendorAssignment->updateCheckInData($newdt,$postData['DocumentReceived'],$fmd_id,$typeHiddenArr);
					
					//********  Coding for adding/updating public_notes ***************
					 
					 $this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, $regarding, 'Fva'); //$postData['Public_Internal']
					  
					//update in other processe pending
					$this->updateOtherRecords($fmd_id, $newdt, $typeHiddenArr);
					
					$first = 0;
				}
				else
				{
					// check for extension NEW
					//$extensionDT  = $this->FilesVendorAssignment->getMainDataByMultiDocType($fmd_id, $newdt, 'Id'); 
					// insert checkin data
					$this->FilesVendorAssignment->insertNewCheckinData($fmd_id,$newdt,$this->currentUser->user_id,$postData['DocumentReceived']);
					// insert punblic notes
					
					$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, $regarding, 'Fva'); //$postData['Public_Internal']
				}
			}

			if($alexist)
			{
				//delete record with doctype
				$this->deleteOtherRecords($fmd_id, $typeHiddenArr);
			}
			
			//insert in QC id document recived is 'Y'
			if($postData['DocumentReceived'] == 'Y'){
				$this->FilesQcData->insertNewQcData($fmd_id, $newdt, $this->currentUser->id);
				$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, 'Checkin: Record Document Received','Fqcd',true);
			}
		}
		
		return true;
	}
	
	public function searchRecords()
    {
		// set page title
		$pageTitle = 'Record Listing';
		$this->set(compact('pageTitle'));
		
		// IF DOCUMENT RECEIVED BUTTON CLICKED
		$csvFileName = '';$townshipRecordsTable = '';
		$docstatus = $this->request->getData('docstatus');
		
		  if(isset($docstatus) && (!($this->user_Gateway))){
			 
			$fmd_township_division = $this->request->getData('fmd_township_division');
			$postData = ['sno'=>$this->request->getData('sno'), 'company_id'=>$this->request->getData('company_id'),'fmd_township_division'=>isset($fmd_township_division) ? $this->request->getData('fmd_township_division'): ''];
		//pr($postData);exit;	
			// physical document received process
            if($this->request->getData('docstatus') == "dr"){
                $processDocument = $this->_documentReceived($postData, 'Y');
            }

            if($this->request->getData('docstatus') == "dnr"){
				$processDocument = $this->_documentReceived($postData);
            }
		
			if(isset($processDocument) && is_array($processDocument)){
				$townshipRecordsTable = $this->townshipErrorTable($processDocument['townshipFmdError']);
				$csvFileName = $processDocument['csvFileName'];
			}
		}  

		$this->set('townshipRecordsTable', $townshipRecordsTable);
		$this->set('csvFileName', $csvFileName);

		 // set company Id in app controller
		 $requestData = $this->request->getData();
		 $company_mst_id = $this->setCompanyId($requestData); 
  
		if($this->user_Gateway){
			unset($this->columns_alise["FileNo"]);
			// remove and rearrange order for number key array
			array_splice($this->columnsorder,1,1); // 1-> key number, 1->count
		}
        // step for datatable config : 3
        $this->set('dataJson', $this->CustomPagination->setDataJson($this->columns_alise,['Checkbox','Actions']));

        // step for datatable config : 4
		
		//end step
		$isSearch = 0;
        $formpostdata = '';
        if ($this->request->is(['patch', 'post', 'put'])) {
            $formpostdata = $this->request->getData();
			$isSearch = 1;
        }
		
        $this->set('formpostdata', $formpostdata);
        //end step
		$this->set('isSearch', $isSearch);
        //$this->set('isSearch', $this->FilesVendorAssignment->isSearch());

        $FilesVendorAssignment = $this->FilesVendorAssignment->newEmptyEntity();

      
        //$mapArray = $this->_getMappingFields($company_mst_id);
		$partnerMapField =  $this->CompanyFieldsMap->partnerMapFields($company_mst_id,1);
		
        $DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
       // $fileCsvMasterData =  $this->_getCsvFileListing();,'fileCsvMasterData'
        $companyMsts = $this->CompanyMst->companyListArray()->toArray();
		
		// for common data_documentReceivedtable element
		$is_index = 'Y';
		$this->set('is_index', $is_index);
		
        $this->set(compact('FilesVendorAssignment','companyMsts','DocumentTypeData','partnerMapField'));
        $this->set('_serialize', ['FilesVendorAssignment']);
      
	  // for partner section 
	   $checkinDataSheet = $this->request->getData('checkinDataSheet');
		if(isset($checkinDataSheet))
		{
			$this->checkinRecordsSheet($this->request->getData());
		}
		
		$this->set('pageTitle','Search Record');
	}
	
	// step for datatable config : 5 main step
	public function ajaxListSearchRecords(){

		$this->autoRender = false;
		 
		$documentReceived = '';
		$formdata = $this->request->getData('formdata');
		//$DocumentReceived = $formdata['DocumentReceived'];
	 
		if(isset($formdata['DocumentReceived'])){
			$documentReceived = $formdata['DocumentReceived'];
			unset($formdata['DocumentReceived']);
		} 
		
		$pdata = $this->postDataCondition($this->request->getData()); 
		// Remove query limit for all records
		if($pdata['condition']['limit'] == -1){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']);
		} // END
			
		$query = $this->setFilterQuery($formdata, $pdata, $documentReceived);
		 
		// no groupby add
		$recordsTotal = $this->FilesVendorAssignment->getQueryCountResult($query, 'count', false); 
		
		$data  =  $this->FilesVendorAssignment->getQueryCountResult($query);
		//pr($data);
		// customise as per condition for differant datatable use.
		$data = $this->getCustomParshingData($data);
		
		$response = array(
						"draw" => intval($pdata['draw']),
						"recordsTotal" => intval($recordsTotal),
						"recordsFiltered" => intval($recordsTotal),
						"data" => $data
					);

		echo json_encode($response); 
		exit;
	}

	//Ajax method to update record lock 
	public function ajaxLockRecord(){
		$this->autoRender = false;
		$formdata = $this->request->getData(); 
		$checkinData = $this->FilesVendorAssignment->updateLockRecord($formdata['chechinId'], $formdata['lock_status']);
		if(!empty($checkinData)){  
			// add insert row in public notes fcd table  
			$this->PublicNotes->insertNewPublicNotes($checkinData['RecId'], $checkinData['TransactionType'], $this->currentUser->user_id, 'Lock : '.$formdata['lock_comment'],'Fva',true);
		}
		 
		exit;
	}  
	
	/**
     * View method
     *
     * @param string|null $id Files Checkin Data id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		// set page title
		$pageTitle = 'Check In Status';
		$this->set(compact('pageTitle'));
		
        $recordMainId = $this->request->getParam('fmd');
		$doctype = $this->request->getParam('doctype');
		if(empty($recordMainId) || empty($doctype)){
			return $this->redirect(['action' => 'indexPartner']);exit;
		}
		 
		$filesMainData = $this->FilesMainData->searchMainDataForAll($recordMainId);
		if(empty($filesMainData)){
			$this->Flash->error(__('Please select correct record.'));
			return $this->redirect(['action' => 'indexPartner']);exit;
		}
		
		$FilesVendorAssignment = $this->FilesVendorAssignment->getCheckInData($recordMainId, $doctype); 
		
		$documentData = $this->DocumentTypeMst->get($doctype);
		$documentDataList= [$documentData['Id']=>$documentData['Title']];
		 
		$partnerMapField = $this->CompanyFieldsMap->partnerMapFields($filesMainData['company_id'],1);

        $this->set(compact('FilesVendorAssignment', 'filesMainData', 'documentData', 'documentDataList','partnerMapField'));
		
        $this->set('_serialize', ['FilesVendorAssignment']);
		
    }
	
	private function generateCsvSheet($resultQuery=[], $callType='form'){
		$csvFileName ='';
		
		$partnerMapData = $this->partnerMapFields($resultQuery['companyId']);
		
		$csvNamePrifix = $partnerMapData['csvNamePrifix'].$resultQuery['limitPrifix'];
		
		$skipJoin = ['files_checkin_data'.ARCHIVE_PREFIX];
		$param  = ['partnerMapFields'=>$partnerMapData['partnerMapFields'], 'skipJoin'=>$skipJoin, 'onlyQuery'=>false];

		// behaviour call for adding extra fields for CSV sheet
		$resultQuery  = $this->FilesVendorAssignment->generateQuery($resultQuery['query'], $param); 
		$resultRecord = $this->FilesVendorAssignment->getQueryCountResult($resultQuery['query']); 
		$listRecord   = $this->FilesVendorAssignment->setListRecords($resultRecord, $resultQuery['headerParams']);
		
		//updateAllSheetGenerate
		if(array_key_exists(0,$listRecord))
		{	
			
			if($callType == 'link'){
				$this->downloadCsv($listRecord, array_keys($resultQuery['headerParams']), $csvNamePrifix);
				//$this->sampleExport($csvFileName,'export');
			} else {
				$csvFileName = $this->CustomPagination->recordExport($listRecord, array_keys($resultQuery['headerParams']), $csvNamePrifix, 'export');
				$this->set('csvFileName', $csvFileName);
			} 
			$this->Flash->success(__('Records sheet listed!!'));

		}else{
			$this->Flash->error(__('Records not found!!'));
		}

	}
	
	private function partnerMapFields($companyId){
		$partnerMapFields = ['NATFileNumber'=>'','PartnerFileNumber'=>'','Grantors'=>'','StreetName'=>'','County'=>'','State'=>''];
		$companyExportField =[];
		//===== generete csv file data & name to export data====================//	
		$partnerMapData = $this->FilesVendorAssignment->partnerExportFields($companyId,'cef_fieldid4CHI','checkinsheet');
		$partnerMapFields = $partnerMapData['partnerMapFields'];
		$csvNamePrifix = $partnerMapData['csvNamePrifix'];
			 
		$companyExportField = $this->CompanyExportFields->exportFieldsDataByField($companyId,'cef_fieldid4CHI');
		
		if(!empty($companyExportField)){
			$partnerMapFields = $this->CompanyFieldsMap->checkMapFieldsTitleById($companyId, $companyExportField);
			unset($partnerMapFields['InternalNotes']); // no use
		}
		
		if($this->currentUser->user_Gateway && isset($partnerMapFields['NATFileNumber'])){
			unset($partnerMapFields['NATFileNumber']);
		}
		
		return ['partnerMapFields'=>$partnerMapFields, 'csvNamePrifix'=>$csvNamePrifix];
	}
	
	public function deleteCheckPassword()
    {
		$id = $this->request->getData('checkinId');
		$delpassword = $this->request->getData('delpassword');

		if($delpassword == "" || $delpassword != "0442") {
			$this->Flash->error(__('Password is not Correct. Please, try again.'));
			return $this->redirect(['action' => 'index']);
		}
		$FilesVendorAssignment = $this->FilesVendorAssignment->get($id);

        if ($this->FilesVendorAssignment->delete($FilesVendorAssignment)) {
			// delete row from main data if deleted records is last records from check in.
			$countMainData = $this->FilesVendorAssignment->countByFileId($FilesVendorAssignment->RecId);
			if($countMainData < 1){
				$this->FilesMainData->deleteAll(['Id'=>$FilesVendorAssignment->RecId]);
			}

			// delete related records from other table.
			$this->deleteOtherRecords($FilesVendorAssignment->RecId,  $FilesVendorAssignment->TransactionType);

            $this->Flash->success(__('The files checkin data has been deleted.'));
        } else {
            $this->Flash->error(__('The files checkin data could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function aoldelete()
    {
        $id = $this->request->getData('checkinId');
        $delpassword = $this->request->getData('delpassword');

        if ($delpassword == "" || $delpassword != "0442") {
            $this->Flash->error(__('Password is not Correct. Please, try again.'));
            return $this->redirect(['action' => 'aolindex']);
        }

        $FilesAolAssignment = $this->FilesAolAssignment->find()
            ->where(['RecId' => $id])
            ->first();

        if ($FilesAolAssignment) {
            // Convert to array
            $data = $FilesAolAssignment->toArray();

            // Set default values for missing fields, but use original dates
            $data['pre_aol_status'] = $data['pre_aol_status'] ?? 'N'; // Default to 'N' if null
            $data['final_aol_status'] = $data['final_aol_status'] ?? 'N';
            $data['submit_aol_status'] = $data['submit_aol_status'] ?? 'N';

            // Use the original dates from the record being deleted (don't change them to current time)
            $data['pre_aol_date'] = $data['pre_aol_date'] ?? null;
            $data['final_aol_date'] = $data['final_aol_date'] ?? null;
            $data['submit_aol_date'] = $data['submit_aol_date'] ?? null;

            // Archive the record
            $archiveTable = \Cake\ORM\TableRegistry::getTableLocator()->get('FilesAolAssignmentArchieve');
            $archived = $archiveTable->newEntity($data);

            if ($archiveTable->save($archived)) {
                // Now delete the record if it's successfully archived
                if ($this->FilesAolAssignment->delete($FilesAolAssignment)) {
                    $this->Flash->success(__('The AOL record has been archived and deleted.'));
                } else {
                    $this->Flash->error(__('The AOL record could not be deleted. Please, try again.'));
                }
            } else {
                // Archive failed
                $this->Flash->error(__('Failed to archive the AOL record. Deletion aborted.'));
            }
        } else {
            $this->Flash->error(__('The AOL record was not found.'));
        }

        return $this->redirect(['action' => 'aolindex']);
    }

}