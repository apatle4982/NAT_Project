<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Routing\Router;
/**
 * FilesAccountingData Controller
 *
 * @property \App\Model\Table\FilesAccountingDataTable $FilesAccountingData
 * @method \App\Model\Entity\FilesAccountingData[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilesAccountingDataController extends AppController
{

    private $columns_alise = [	"Checkbox" => "",
                                "FileNo" => "fmd.NATFileNumber",
                                "PartnerFileNumber" => "fmd.PartnerFileNumber",
                                "TransactionType" => "fva.TransactionType",
                                "Grantors" => "fmd.Grantors",
                                "County" => "fmd.County",
                                "State" => "fmd.State",                                
                                "Actions" => "",
							];
		// "ECapable" => "fmd.ECapable", 
	private $columnsorder = [0=>'fmd.Id',1=>'fmd.NATFileNumber',2=>'fmd.PartnerFileNumber',3=>'fad.TransactionType',4=>'fmd.Grantors',5=>'fmd.County',6=>'fmd.State',8=>'fad.jrf_final_fees',9=>'fad.it_final_fees',10=>'fad.of_final_fees',11=>'fad.total_final_fees', 12=>'fad.AccountingNotes'];  
	// 7=>'fmd.ECapable',
	public $callFrom = null;
	public $exportFld = 'cef_fieldid4AC';
	public $skipJoin = [];
        
    public function initialize(): void
	{
		parent::initialize();
		$this->loadModel("CompanyFieldsMap");
		$this->loadModel("DocumentTypeMst");
		$this->loadModel("CompanyMst");
		$this->loadModel("FilesMainData"); 
		$this->loadModel("FilesCheckinData"); 
		$this->loadModel('CountyMst');
		$this->loadModel('FilesQcData');
		$this->loadModel('PublicNotes');
		$this->loadModel('FilesAccountingDataHistory');
		$this->loadModel('CountyCalApiResponse');
		$this->loadModel('FilesVendorAssignment');

		$this->loadComponent('GeneratePDF');
	}
	
	public function beforeFilter(\Cake\Event\EventInterface $event)
    {
		parent::beforeFilter($event);
		$this->loginAccess();
	}
	
	public function indexPartner(){
		$this->index();
		$accountSheet = $this->request->getData('accountSheet');
		if(isset($accountSheet))
		{
			$this->accountManagementData($this->request->getData());
		}
		$pageTitle = 'Accounting Section';
		$this->set(compact('pageTitle')); 
	}
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    
	public function index()
    { 
		// set page title
		$pageTitle = 'Accounting Entry Section';
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
				//$townshipRecordsTable = $this->townshipErrorTable($processDocument['townshipFmdError']);
				//$csvFileName = $processDocument['csvFileName'];
			}
		}  

		//$this->set('townshipRecordsTable', $townshipRecordsTable);
		//$this->set('csvFileName', $csvFileName);

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
		$this->set('is_index', $is_index);
		
        $this->set(compact('FilesVendorAssignment','companyMsts','DocumentTypeData','partnerMapField'));
        $this->set('_serialize', ['FilesVendorAssignment']);
      
	  // for partner section 
	   $checkinDataSheet = $this->request->getData('checkinDataSheet');
		if(isset($checkinDataSheet))
		{
			$this->checkinRecordsSheet($this->request->getData());
		}
    }


    private function setIndexPage($action = 'index'){
		
		if($action == 'index'){
			$setArray = ['Checkbox','Actions'];
			$is_index = 'Y';
		}else{
			if($this->user_Gateway){
				unset($this->columns_alise["FileNo"]); 
				array_splice($this->columnsorder,1,1); 
				$setArray = ['Checkbox','Actions'];
			}else{
				unset($this->columns_alise['Actions']);
				$setArray = ['Checkbox'];
			}
			$is_index = 'N';
		}

		$this->set('dataJson', $this->CustomPagination->setDataJson($this->columns_alise,$setArray));
		return $is_index;

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


    private function getCustomParshingData(array $data, $is_index='Y') 
    { 
        $count = 1;
        foreach ($data as $key => $value) {
    
            $value['Checkbox'] = $count;
            if($this->user_Gateway){
                $value['Actions'] = $this->CustomPagination->getUserActionButtons($this->name,$value,['accountId','SrNo','TransactionType'], 'common');
            }elseif($is_index=='Y'){
                $value['Actions'] = $this->CustomPagination->getActionButtons($this->name,$value,['SrNo','County','accountId','TransactionType'], $prefix = "", $hideViewButton = 7);
            }
            $value['TransactionType'] = $value["TransactionType"].' ( '.$value["DocumentTitle"].' )';
			$value['PartnerFileNumber'] = $value["PartnerFileNumber"].' ( '.$value["ClientCompName"].' )';
			
            /*if($value['ECapable'] == "Y") {
				$value['ECapable'] = 'Both SF & CSC';
			} else if($value['ECapable'] == "S") {
				$value['ECapable'] = 'SF';
			} else if($value['ECapable'] == "C") {
				$value['ECapable'] = 'CSC';
			} else {
				$value['ECapable'] = '';
			} */

            $count++;
        }

        unset($data['accountId']);
        return $data;
    }
     
    /**
     * Edit method
     *
     * @param string|null $id Files Accounting Data id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$recordMainId = $this->request->getParam('fmd');
		$doctype = $this->request->getParam('doctype');
		$section = $this->request->getParam('section');

		if(empty($recordMainId) || empty($doctype)){
			return $this->redirect(['action' => 'index']);exit;
		}
		
		// County call API
		/*$getRequestData = $this->FilesMainData->getCountyCalRequestData($recordMainId);
		if(empty($getRequestData[0]['LoanAmount'])){
			$LoanAmount = 320000;
		}else{
			$LoanAmount = $getRequestData[0]['LoanAmount'];
		}	
					
        //$APIRequest = array("State" => $getRequestData[0]['st']['id'], "County" => $getRequestData[0]['cou_mst']['cm_id'], "TransactionType" => "0", "documentTypeID" => $doctype, "considerationAmount" => $LoanAmount, "loanAmount" => $LoanAmount);
		
		$APIRequest = array("State" => "1", "County" => "1", "TransactionType" => "0", "documentTypeID" => "131", "considerationAmount" => "240000", "loanAmount" => "320000");
		
		$CountyCalAPIToken = $this->CountyCalAPIToken();
		$CountyCalAPIResult = $this->CountyCalAPI($CountyCalAPIToken,$APIRequest);
		print_r($CountyCalAPIResult); exit;
		$jrf_cc_fees = $CountyCalAPIResult['results']['lineItems'][0]['amount'];
		$tt_cc_fees = $CountyCalAPIResult['results']['lineItems'][1]['amount'];
		$it_cc_fees = $CountyCalAPIResult['results']['lineItems'][2]['amount'];
		$ot_cc_fees = $CountyCalAPIResult['results']['lineItems'][3]['amount'];
		$ns_cc_fees = $CountyCalAPIResult['results']['lineItems'][4]['amount'];
		
		$this->set(compact('jrf_cc_fees', 'tt_cc_fees', 'it_cc_fees', 'ot_cc_fees','ns_cc_fees'));
		
		$APIdata = ['RecId'=>$recordMainId, 'TransactionType'=> $doctype, 'api_request'=>serialize($APIRequest), 'api_response'=>serialize($CountyCalAPIResult), 'entrydate'=>date('Y-m-d h:i:s')];
		
		$this->CountyCalApiResponse->saveCountyCalAPIData($APIdata);	*/
		//END
		
        if ($this->request->is(['patch', 'post', 'put']))
		{
			$data= [];$return = false;
			
				$postData = $this->request->getData();
 
				$filesMainId = $postData['fmdId'];
				$documentTypeId = $postData['docTypeId'];
				$accountId =  $postData['accountId'];
				$data['jrf_cc_fees'] =  $postData['jrf_cc_fees'];
				$data['jrf_icg_fees'] =  $postData['jrf_icg_fees'];
				$data['jrf_curative'] = $postData['jrf_curative'];
				$data['jrf_final_fees'] = $postData['jrf_final_fees'];
				$data['tt_cc_fees'] = $postData['tt_cc_fees'];
				$data['tt_icg_fees'] = $postData['tt_icg_fees']; 
                $data['tt_curative'] = $postData['tt_curative']; 
                $data['tt_final_fees'] = $postData['tt_final_fees'];
                $data['it_cc_fees'] = $postData['it_cc_fees'];
				$data['it_icg_fees'] = $postData['it_icg_fees']; 
                $data['it_curative'] = $postData['it_curative']; 
                $data['it_final_fees'] = $postData['it_final_fees'];
                $data['ot_cc_fees'] = $postData['ot_cc_fees'];
				$data['ot_icg_fees'] = $postData['ot_icg_fees']; 
                $data['ot_curative'] = $postData['ot_curative']; 
                $data['ot_final_fees'] = $postData['ot_final_fees']; 
                $data['ns_cc_fees'] = $postData['ns_cc_fees'];
				$data['ns_icg_fees'] = $postData['ns_icg_fees']; 
                $data['ns_curative'] = $postData['ns_curative']; 
                $data['ns_final_fees'] = $postData['ns_final_fees']; 
                $data['wu_cc_fees'] = $postData['wu_cc_fees'];
				$data['wu_icg_fees'] = $postData['wu_icg_fees']; 
                $data['wu_curative'] = $postData['wu_curative']; 
                $data['wu_final_fees'] = $postData['wu_final_fees']; 
                $data['of_cc_fees'] = $postData['of_cc_fees'];
				$data['of_icg_fees'] = $postData['of_icg_fees']; 
                $data['of_curative'] = $postData['of_curative']; 
                $data['of_final_fees'] = $postData['of_final_fees'];
                $data['total_cc_fees'] = $postData['total_cc_fees'];
				$data['total_icg_fees'] = $postData['total_icg_fees']; 
                $data['total_curative'] = $postData['total_curative']; 
                $data['total_final_fees'] = $postData['total_final_fees']; 
                $data['check_cleared'] = $postData['check_cleared'];

				$data['AccountingProcessingDate'] = (!empty($postData['AccountingProcessingDate'])) ? date("Y-m-d", strtotime($postData['AccountingProcessingDate'])) : date('Y-m-d');
				
				$data['publicData']['publicType'] = "I";
				$data['publicData']['regarding'] = $postData['Regarding'];
				$return = $this->addUpdateAccountingData($filesMainId, $documentTypeId, $data, $accountId);

			if($return){
				$this->FilesAccountingDataHistory->addAccountingHistory($filesMainId, $documentTypeId, $this->currentUser->user_id, $data);
				$this->Flash->success(__('The files accounting data has been saved.'));
				
				if(isset($section) && ($section == 'complete')){
					return $this->redirect([
						'controller' => 'PublicNotes',
						'action' => 'viewComplete',$recordMainId,$doctype
					]);
				}else{ 
					return $this->redirect(['action' => 'index']);
				}
				
			}else{
				$this->Flash->error(__('The files accounting data could not be saved. Please, try again.'));
			}			

        }
 
		$filesMainData = $this->FilesMainData->searchMainDataForAll($recordMainId);
		if(empty($filesMainData)){
			$this->Flash->error(__('Please select correct record.'));
			return $this->redirect(['action' => 'index']);exit;
		}
		
		$filesAccountingData = $this->FilesAccountingData->getfilesAccountingData($recordMainId,$doctype);
 
		$documentData = $this->DocumentTypeMst->get($doctype); 
		$documentDataList= [$documentData['Id']=>$documentData['Title']]; 
 
		$partnerMapField = $this->CompanyFieldsMap->partnerMapFields($filesMainData['company_id'],1);
		
		$accountingHistoryData = $this->FilesAccountingDataHistory->accoutHistoryData($recordMainId, $doctype);

		$this->set('section', $section);
		
        $pageTitle = 'Accounting Entry For <u>'.$filesMainData['PartnerFileNumber']."</u>";
		$this->set(compact('pageTitle'));

        $this->set(compact('filesAccountingData', 'filesMainData', 'documentData', 'documentDataList','partnerMapField', 'accountingHistoryData'));
        $this->set('_serialize', ['filesAccountingData']); 

    }
	
	private function CountyCalAPIToken(){
		
		// For Generating Access Token
		
		$url = 'https://sandboxaws.enoahprojects.com/3hm_live_v1/api_services/public/user/getToken';

		$body = array("secretKey" => "8359fabc166048ca03fd451544a4b4484fdcd35f");

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			$error_msg = curl_error($ch);
			$result = array("error"=>$error_msg);
		} else {
			$json = json_decode($response, true);
			$result = $json["jwtToken"];
		} 
		curl_close($ch); 
		 
		//print_r($result);
		$token = $json["jwtToken"];
		return $token;
		
	}

	private function CountyCalAPI($token, $postRequest){
		
		// For NEW fee Calculation Estimates
		
		//$postRequest = array("State" => "1", "County" => "1", "TransactionType" => "0", "documentTypeID" => "131", "considerationAmount" => "240000", "loanAmount" => "320000");

		$post_data = json_encode($postRequest); 
		$url = 'https://sandboxaws.enoahprojects.com/3hm_live_v1/api_services/public/api/feeCalculationEstimates';

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: bearer ' . $token));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
			
		if (curl_errno($ch)) {
			$error_msg = curl_error($ch);
			$result = array("error"=>$error_msg);
		} else {
			$jsonResult = json_decode($response, true); 
			if(!empty($jsonResult)) {
				$result = $jsonResult;
			} else {
				$result = array("error"=>"Something went wrong, please check and try again.");
			}					
		} 
		curl_close($ch); 
		return $result; 
		
	}
	
    private function addUpdateAccountingData($filesMainId, $documentTypeId, array $data, $checkValue=''){
		$return = FALSE;
		$publicType = 'I';
		
		$data['AccountingProcessingTime'] = date("H:i:s");
		$data['RecId'] = $filesMainId;
		$data['TransactionType'] =$documentTypeId;
		$data['LastModified'] = date("Y-m-d");
		$data['UserId'] = $this->currentUser->user_id;
		 
		if(isset($data['publicData'])){
			$postRegarding = $data['publicData']['regarding'];
			$publicType = $data['publicData']['publicType'];
			unset($data['publicData']);
		}

		if(empty($checkValue)){ 
			$return = $this->FilesAccountingData->insertNewAccountData($data);
			$Regarding = (isset($postRegarding) ? $postRegarding: 'Record Added');
		}else{ 
			$return = $this->FilesAccountingData->updateAccountData($checkValue, $data);
			$Regarding = (isset($postRegarding) ? $postRegarding: 'Record Updated');
		}

		if($return){
			$Regarding .= " <b>(Jurisdiction Recording Fee: ".$data['jrf_final_fees'].", Intangible / Mtg Tax: ".$data['it_final_fees'].", Other Fees: ".$data['of_final_fees'].", Total: ".$data['total_final_fees'].")</b>";
			$this->PublicNotes->insertNewPublicNotes($filesMainId, $documentTypeId, $this->currentUser->user_id, $Regarding, 'Fad', false, 'Accounting Main');
		}
		return $return;
	}


	// Function for Generate Accounting Sheet screen
	public function accountSheet(){
		
		$pageTitle = 'Generate Accounting Sheet';
		$this->set(compact('pageTitle'));
		$fromdate = $todate = '';
		$FilesAccountingData = $this->FilesAccountingData->newEmptyEntity();
		 
		if ($this->request->is(['patch', 'post', 'put'])) 
		{
			$generateSheetBtn = $this->request->getData('generateSheetBtn');
			$fromdate = $this->request->getData('fromdate');
			$todate = $this->request->getData('todate');
			if(isset($generateSheetBtn))
			{  
				$chkStartDate = $this->validateDate($fromdate); 
				$chkEndDate = $this->validateDate($todate); 
				if($chkStartDate == 1 && $chkEndDate == 1) {
					$this->accountManagementData($this->request->getData(),'cef_fieldid4GP','sheetGenerate');
				} else {
					$this->Flash->error(__('Please enter proper From Date / To Date.'));
				}
			}
			
		}
		
		$this->set('fromdate',$fromdate);
		$this->set('todate',$todate);
 
		$companyMsts = $this->CompanyMst->companyListArray();
		
        $this->set(compact('FilesAccountingData', 'companyMsts'));
        $this->set('_serialize', ['FilesAccountingData']);
	}


	public function accountManagementData(array $postData=[], $exportFld='cef_fieldid4AC', $callFrom=null){
		$listRecordFinal = [];
		$queryData = $this->request->getQuery();
		if(isset($queryData) && !empty($queryData) && empty($postData)){

			$this->autoRender = false;
			$postData = $this->request->getQuery();
			$getLimit = explode('-',$postData['limit']);
			unset($postData['limit']);
			
			$exportFld = $postData['exportFld'];
			$callFrom = isset($postData['callFrom']) ? $postData['callFrom'] : null; 
			unset($postData['callFrom'], $postData['exportFld']);
		}

		if(isset($postData['generateSheetBtn'])){ unset($postData['generateSheetBtn']); }
		
		$this->callFrom = $callFrom;
		$this->exportFld = $exportFld;
		 
		$companyId = $this->setCompanyId($postData);
		
		$this->skipJoin = ['files_checkin_data'.ARCHIVE_PREFIX,'files_qc_data'.ARCHIVE_PREFIX,'files_accounting_data'.ARCHIVE_PREFIX];
			 
		$pdata = $this->postDataCondition(['formdata'=>$postData,'draw' => 1,'order'=>null], true);
		
		if($callFrom == 'PFS' || $callFrom == 'EFS'){
			
			$partnerMapData = $this->_getpartnerMapData($companyId);
			
			$query = $this->setFilterQuery($postData, $pdata, $callFrom);
 
			$query = $query->group(['fmd.NATFileNumber','fcd.TransactionType']);
 
			$listRecord = $this->FilesAccountingData->searchExportByDateRange($query, $partnerMapData['partnerMapFields'], 'dataNheaderOnly', $this->skipJoin);
 
			$returnListRecord = $this->afPendingEstimation($listRecord, $postData['fromdate'], $callFrom);

			$listRecordFinal = $returnListRecord['records']; 
			$headerParamsFinal = $listRecord['headerParams'];
			
			$estimateFeeDetails = '';
			if($callFrom == 'EFS' && (array_key_exists(0,$listRecordFinal))){  
 				$estimateFeeDetails = $returnListRecord['estimateFeeDetails'];
			}

			$this->set(compact('estimateFeeDetails'));

			if(array_key_exists(0,$listRecordFinal))
			{  
				if($callFrom == 'EFS' && empty($companyId)) {
					$partnerMapData['csvNamePrifix'] = 'estimatedfeesheet_'.date("Ymd");
				}
				if($callFrom == 'PFS' && empty($companyId)) {
					$partnerMapData['csvNamePrifix'] = 'afpendingestimatedsheet_'.date("Ymd");
				}
				$csvFileName = $this->CustomPagination->recordExport($listRecordFinal,array_keys($headerParamsFinal),$partnerMapData['csvNamePrifix'],'export');
   
				$this->set('csvFileName',$csvFileName);
				//$this->Flash->success(__('Accounting records sheet listed!!')); 
			}/* else{
				$this->Flash->error(__('Records not found!!'));
			}  */  

			if($callFrom == 'EFS'){ 
				 
				$this->header = [];
				$this->header["County"] = $partnerMapData['partnerMapFields']['County'] ? $partnerMapData['partnerMapFields']['County'] : "County";
				$this->header["State"] = $partnerMapData['partnerMapFields']['State'] ? $partnerMapData['partnerMapFields']['State'] : "State"; 
				$this->header["TransactionType"] = $partnerMapData['partnerMapFields']['TransactionType'] ? $partnerMapData['partnerMapFields']['TransactionType'] : "TransactionType";
				$this->header["ECapable"] = $partnerMapData['partnerMapFields']['ECapable'] ? $partnerMapData['partnerMapFields']['ECapable'] : "ECapable";
				$this->header["jrf_final_fees"] = $partnerMapData['partnerMapFields']['jrf_final_fees'] ? $partnerMapData['partnerMapFields']['jrf_final_fees'] : "jrf_final_fees";
				$this->header["it_final_fees"] = $partnerMapData['partnerMapFields']['it_final_fees'] ? $partnerMapData['partnerMapFields']['it_final_fees'] : "it_final_fees";
				$this->header["of_final_fees"] = $partnerMapData['partnerMapFields']['of_final_fees'] ? $partnerMapData['partnerMapFields']['of_final_fees'] : "of_final_fees";
				$this->header["total_final_fees"] = $partnerMapData['partnerMapFields']['total_final_fees'] ? $partnerMapData['partnerMapFields']['total_final_fees'] : "total_final_fees"; 
				$this->header["Count"] = "Count"; 

				$pdataNew = $this->postDataConditionEFS(['formdata'=>$postData,'draw' => 1,'order'=>null], false);

				$pdataNew['condition']['order'] = ['fmd.County' => 'ASC'];

				$partnerMapData = $this->header;
 
				$query = $this->setFilterQueryEFS($postData, $pdataNew, $callFrom);
				$query = $query->group(['fcd.TransactionType','fmd.County','fmd.State']);
				$forCounty = true; 
				 
				$listRecord = $this->FilesAccountingData->searchExportByDateRange($query, $partnerMapData, false, $this->skipJoin,$forCounty);
   
				$listRecordFinal = $listRecord['records']; 
				$headerParamsFinal = $listRecord['headerParams'];
				 
				if(array_key_exists(0,$listRecordFinal))
				{  
					$file_name = "average4County_".date('Ymd');
					$csvFileNameCounty = $this->CustomPagination->recordExport($listRecordFinal,array_keys($headerParamsFinal),$file_name,'export');
					 
					$this->set('csvFileNameCounty',$csvFileNameCounty); 
				} 
				
			}
			

		}else{
			// accounting section 
			$query = $this->setFilterQuery($postData, $pdata, $postData['processingstatus']);
 
			$callType = 'form';
			$limitPrifix = '';
			// call from link
			if(!empty($queryData) && is_array($getLimit)){
				$callType = 'link';
				// add limit prifix to csv file name
				$limitPrifix = "_".($getLimit[0]+1)."-".($getLimit[0] + $getLimit[1]);

				// add limit to query
				$query = $query->limit($getLimit[1])->offset($getLimit[0]);
			}

			$resultQuery = $this->FilesAccountingData->generateQuery($query);
			$countRows = 0; // link 
			if($callType == 'form'){
				$countRows = $this->FilesAccountingData->getQueryCountResult($resultQuery['query'], 'count');
			}
			
			/********************* NEW CHANGE *******************************/
			if($countRows <= ROWLIMIT){
				 
				// add csvNamePrifix to result array
				$resultQuery['companyId'] = $companyId;
				$resultQuery['limitPrifix'] = $limitPrifix;
				// generate CSV sheet to download
				$this->generateCsvSheet($resultQuery, $callType);
			}else{
				// generate CSV link to download call from component 
				$postData['exportFld'] = $exportFld;
				$postData['callFrom'] = $callFrom;

				$pagelink = Router::url(['controller'=>$this->name,'action'=>'accountManagementData', '?'=>$postData]);

				$pdfDownloadLinks = $this->CustomPagination->generateCsvLink($countRows,$pagelink);
				if(!empty($pdfDownloadLinks)){
					$this->set('pdfDownloadLinks',$pdfDownloadLinks);
					//$this->Flash->success(__('Accounting records sheet links listed.'));
				}else{
					$this->Flash->error(__('Records not found!!'));
				}
			}
		}
		
	}

	private function generateCsvSheet($resultQuery=[], $callType = 'form'){
		$csvFileName ='';
		// behaviour call for adding extra fields for CSV sheet
		$partnerMapData = $this->_getpartnerMapData($resultQuery['companyId']);
		$partnerMapData['partnerMapFields']['CountyCode'] = 'CountyCode';
		$csvNamePrifix = $partnerMapData['csvNamePrifix'].$resultQuery['limitPrifix'];
		
		$param = ['partnerMapFields'=>$partnerMapData['partnerMapFields'], 'skipJoin'=>$this->skipJoin, 'onlyQuery'=>false];

		// behaviour call for adding extra fields for CSV sheet
		$resultQuery = $this->FilesAccountingData->generateQuery($resultQuery['query'], $param);
		//pr($resultQuery);exit;
		$resultRecord = $this->FilesAccountingData->getQueryCountResult($resultQuery['query']);
		$listRecord = $this->FilesAccountingData->setListRecords($resultRecord, $resultQuery['headerParams']);
 
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
			//$this->Flash->success(__('Accounting records sheet listed.'));

		}else{
			$this->Flash->error(__('Records not found!!'));
		}

	}

	private function _getpartnerMapData($companyId){
		
		$partnerMapData = $this->FilesAccountingData->partnerExportFields($companyId,$this->exportFld,'accsheet');
		
		$partnerMapFields = $partnerMapData['partnerMapFields'];
		$csvNamePrifix = $partnerMapData['csvNamePrifix'];
		
		// for Af pending function 
		$aditionalFld =[];
		if($this->exportFld == 'cef_fieldid4GP'){
			//Add aditional fields for export sheet	
			$aditionalFld = ['jrf_final_fees','it_final_fees','of_final_fees','total_final_fees','CheckNumber1','CheckNumber2','CheckNumber3'];
		}
		
		// EFS estimate file sheet // PFS pending file sheet
		if(!empty($this->callFrom)){ 
			$aditionalFld = ['CheckInProcessingDate','jrf_final_fees','it_final_fees','of_final_fees','total_final_fees'];
		}
		
		// call from component
		$partnerMapFields =  $this->CustomPagination->additionalFieldsTOSearch($aditionalFld, $partnerMapFields);
		if($this->user_Gateway && isset($partnerMapFields['NATFileNumber'])){
			unset($partnerMapFields['NATFileNumber']);
		}	
		
		return ['partnerMapFields'=>$partnerMapFields, 'csvNamePrifix'=>$csvNamePrifix];
	}

	public function estimatedFeeSheetPartner(){
		$this->estimatedFeeSheet();
	}
	
	public function estimatedFeeSheet(){

		$pageTitle = 'Estimated Fee Sheet';
		$this->set(compact('pageTitle'));

		$FilesAccountingData = $this->FilesAccountingData->newEmptyEntity();		
		$fromdate = $todate = '';
		if ($this->request->is(['patch', 'post', 'put'])) 
		{
			$searcch = $this->request->getData('search');
			if(isset($searcch))
			{
				$fromdate = $this->request->getData('fromdate');
				$todate = $this->request->getData('todate');

				$chkStartDate = $this->validateDate($fromdate); 
				$chkEndDate = $this->validateDate($todate); 
				if($chkStartDate == 1 && $chkEndDate == 1) {
					$this->accountManagementData($this->request->getData(), 'cef_fieldid4GP','EFS');
				} else {
					$this->Flash->error(__('Please enter proper From Date / To Date.'));
				}
				
				$State = $this->request->getData('State');
				$this->set('State', $State);
				
			}
		}
		
		$this->set('fromdate', $fromdate);
		$this->set('todate', $todate);
 
		$companyMsts = $this->CompanyMst->companyListArray();
		$DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
        $this->set(compact('FilesAccountingData', 'companyMsts', 'DocumentTypeData'));
        $this->set('_serialize', ['FilesAccountingData']);
	}
	

	private function afPendingEstimation(array $listRecord, $fromdate='', $callFrom='PFS'){
		
		$afpendingData = $this->FilesMainData->queryAfPendingFee($fromdate);
		$estimateFeeDetails = [];
		$afPendingArr = [];
		$listRecordFinal = []; 
		if(!empty($afpendingData)){
			foreach($afpendingData as $result){

				$State = $result['State'] ? strtolower($result['State']) : "";
				$County = $result['County'] ? strtolower($result['County']) : "";
				
				$afPendingArr[$result['dtm']['Title']][$State][$County]['jrf_final_fees'] = $result['avg_jrf_final_fees'] ? number_format($result['avg_jrf_final_fees'], 2, '.', '') : "";
				
				$afPendingArr[$result['dtm']['Title']][$State][$County]['it_final_fees'] = $result['avg_it_final_fees'] ? number_format($result['avg_it_final_fees'], 2, '.', '') : "";
				
				$afPendingArr[$result['dtm']['Title']][$State][$County]['of_final_fees'] = $result['avg_of_final_fees'] ? number_format($result['avg_of_final_fees'], 2, '.', '') : "";
				
				$afPendingArr[$result['dtm']['Title']][$State][$County]['total_final_fees'] = $result['avg_total_final_fees'] ? number_format($result['avg_total_final_fees'], 2, '.', '') : "";
			}
 
			if(!empty($listRecord['records'])){
				$key=0;
				if($callFrom =='EFS'){
					$totalrecfee = 0;
					$totaltax = 0;
					$totalcnt = 0;
					$totalrec = 0;
					$docs = [];
					$counties = [];
				}
				foreach($listRecord['records'] as $processListRecord){
					
					$State = $processListRecord['State'] ? strtolower($processListRecord['State']) : "";
					$County = $processListRecord['County'] ? strtolower($processListRecord['County']) : "";

					if(isset($afPendingArr[$processListRecord['dtm']['Title']][strtolower($State)][strtolower($County)])){
						$processListRecord['fad']['jrf_final_fees'] = $afPendingArr[$processListRecord['dtm']['Title']][strtolower($State)][strtolower($County)]['jrf_final_fees'];
					
						$processListRecord['fad']['it_final_fees'] = $afPendingArr[$processListRecord['dtm']['Title']][strtolower($State)][strtolower($County)]['it_final_fees'];
					
						$processListRecord['fad']['of_final_fees'] = $afPendingArr[$processListRecord['dtm']['Title']][strtolower($State)][strtolower($County)]['of_final_fees'];
					
						$processListRecord['fad']['total_final_fees'] = $afPendingArr[$processListRecord['dtm']['Title']][strtolower($State)][strtolower($County)]['total_final_fees'];
						
						if($callFrom =='EFS'){
							
							$counties[] = ucwords(strtolower($County));
							$docs[] = $processListRecord['dtm']['Title'];
							
							if($processListRecord['fad']['jrf_final_fees'] != '') 
								$jrf_final_fees = number_format(floatval($processListRecord['fad']['jrf_final_fees']), 2, '.', '');
							else 
								$jrf_final_fees = 0;
							$totalrecfee += $jrf_final_fees;
							
							if($processListRecord['fad']['it_final_fees'] !='')
								$it_final_fees = number_format(floatval($processListRecord['fad']['it_final_fees']), 2, '.', '');
							else 
								$it_final_fees = 0;
							$totaltax += $it_final_fees;

							if($processListRecord['fad']['total_final_fees'] !='')
								$total_final_fees = number_format(floatval($processListRecord['fad']['total_final_fees']), 2, '.', '');
							else 
								$total_final_fees = 0;
							$totalrec += $total_final_fees;
						}
						
					}
					$totalcnt++;

					$key++;
				}
			 
				if($callFrom =='EFS'){
					$Countyarr = implode(' , ',array_unique($counties));	
					$doctypearr = implode(' , ',array_unique($docs));
					$totalcnt = $totalcnt;
					 
					if($totalrecfee > 0)
						$totalrecfee = number_format($totalrecfee/$totalcnt, 2, '.', '');
					if($totaltax > 0) 
						$totaltax = number_format($totaltax/$totalcnt, 2, '.', '');
					if($totalrec > 0) 	
						$totalrec = number_format($totalrec/$totalcnt, 2, '.', '');	

					$estimateFeeDetails = ['Countyarr'=>$Countyarr, 'doctypearr'=>$doctypearr, 'totalcnt'=>$totalcnt, 'totalrecfee'=>$totalrecfee, 'totaltax'=>$totaltax, 'totalrec'=>$totalrec];
				}
			}
			
			
			$listRecordFinal = $this->FilesAccountingData->setListRecords($listRecord['records'], $listRecord['headerParams']);

		}  
		return ['records'=>$listRecordFinal, 'estimateFeeDetails'=>$estimateFeeDetails];
		
	}

	private function averageCountyEstimateFee($averageCountyAccount,$headerParamsFinal){
		$csvNamePrifix = 'average4County_'.date('Ymd');
		 
		$headerParamsFinal['TransactionType']='TransactionType'; 
		$headerParamsFinal['E Capable']='ECapable';
		unset($headerParamsFinal['VendorReferenceNo']);
		unset($headerParamsFinal['TAGReferenceNo']);
		unset($headerParamsFinal['Borrower']);
		unset($headerParamsFinal['ClientName']);
		unset($headerParamsFinal['CheckInTime']);
 
		$averageCountyAccountFinal = $this->FilesAccountingData->setListRecords($averageCountyAccount,$headerParamsFinal);
	
		$csvFileName_County = $this->CustomPagination->recordExport($averageCountyAccountFinal, array_keys($headerParamsFinal),$csvNamePrifix,'export');

		$this->set('csvFileName_County',$csvFileName_County);
	}

	private function postDataConditionEFS(array $postData, $fields=false){
		
		$this->columns_alise = [];
		$this->columns_alise["accountId"] =  "fad.Id";
		  
		$this->CustomPagination->setPaginationData(['request'=>$postData,
													 'columns'=>$this->columnsorder, 
													 'columnAlise'=>$this->columns_alise, 
													 'modelName'=>$this->name
													]);
 
		$pdata = $this->CustomPagination->getQueryData();
		
		if($fields){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']); 
		}
					
		return $pdata;
	}

	private function setFilterQueryEFS($requestFormdata=[], $pdata=[], $processingstatus='NP', $callstatus = true)
    {   
		$whereCondition = ['fcd.DocumentReceived'=>'Y'];
		  
		if(isset($requestFormdata['fromdate'])){
			$fromdate = $requestFormdata['fromdate'];
		}

		if(isset($requestFormdata['todate'])){
			$todate = $requestFormdata['todate'];
		}
   
		$whereCondition = $this->addCompanyToQuery($whereCondition);
		  
		$query = $this->FilesMainData->accountingCountyQuery($whereCondition, $pdata['condition']);
		  
		if(isset($fromdate) && isset($todate)){			 
			$processFild = 'fcd.CheckInProcessingDate';			 
			$query = $this->FilesAccountingData->dateBetween($query, $fromdate, $todate, $processFild);
		}

		return $query;
	}

	/**
     * View method
     *
     * @param string|null $id Files Accounting Data id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$pageTitle = 'Accounting';
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
		
		$filesAccountingData = $this->FilesAccountingData->getfilesAccountingData($recordMainId,$doctype);
		
		$documentData = $this->DocumentTypeMst->get($doctype);
		$documentDataList= [$documentData['Id']=>$documentData['Title']];
		$this->loadModel("CompanyFieldsMap");
		$partnerMapField = $this->CompanyFieldsMap->partnerMapFields($filesMainData['company_id'],1);

        $this->set(compact('filesAccountingData', 'filesMainData', 'documentData', 'documentDataList','partnerMapField'));
        $this->set('_serialize', ['filesAccountingData']);
		
    }

	public function pendingFileEstimateSheet(){
 
		$pageTitle = 'AF Pending File Estimate';
		$this->set(compact('pageTitle'));
		$FilesAccountingData = $this->FilesAccountingData->newEmptyEntity();
		
		$fromdate = $todate = '';
		if ($this->request->is(['patch', 'post', 'put'])) 
		{
			$search = $this->request->getData('search');
			if(isset($search))
			{
				$fromdate = $this->request->getData('fromdate');
				$todate = $this->request->getData('todate');

				$chkStartDate = $this->validateDate($fromdate); 
				$chkEndDate = $this->validateDate($todate); 
				if($chkStartDate == 1 && $chkEndDate == 1) {
					$this->accountManagementData($this->request->getData(), 'cef_fieldid4GP', 'PFS');
				} else {
					$this->Flash->error(__('Please enter proper From Date / To Date.'));
				}				
			}
		}
		
		$this->set('fromdate', $fromdate);
		$this->set('todate', $todate);
 
		$companyMsts = $this->CompanyMst->companyListArray();
		
        $this->set(compact('FilesAccountingData', 'companyMsts'));
        $this->set('_serialize', ['FilesAccountingData']);
	}

}