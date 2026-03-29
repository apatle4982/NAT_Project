<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * FilesReturned2partner Controller
 *
 * @property \App\Model\Table\FilesReturned2partnerTable $FilesReturned2partner
 *
 * @method \App\Model\Entity\FilesReturned2partner[] paginate($object = null, array $settings = [])
 */
class FilesReturned2partnerController extends AppController
{

    /**
     * Index method
     * returnFilesToPartner
     * @return \Cake\Http\Response|void
     */
	
	private $columns_alise = [  "Checkbox" => "",
                                "FileNo" => "fmd.NATFileNumber",
                                "PartnerFileNumber" => "fmd.PartnerFileNumber",
                                "TransactionType" => "fcd.TransactionType",
                                "Grantors" => "fmd.Grantors",
								"County" => "fmd.County",
                                "State" => "fmd.State",
                                "ECapable" => "fmd.ECapable",
								"Grantees" => "fmd.Grantees",
								"CarrierName" => "frtp.CarrierName",
								"CarrierTrackingNo" => "frtp.CarrierTrackingNo",
								"Actions"=>""
                            ];

	private $columnsorder = [0=>'fmd.Id', 1=>'fmd.NATFileNumber', 2=>'fmd.PartnerFileNumber', 3=>'fcd.TransactionType', 4=>'fmd.Grantors', 5=>'fmd.County', 6=>'fmd.State', 7=>'fmd.ECapable', 8=>'fmd.Grantees', 9=>'frtp.CarrierName', 10=>'frtp.CarrierTrackingNo']; 
	
	private $pageType = 'index';
	
	private $skipJoin = [];
	
	public function initialize(): void
	{

		parent::initialize();
 
		$this->skipJoin = ['files_checkin_data'.ARCHIVE_PREFIX,'files_recording_data'.ARCHIVE_PREFIX,'files_qc_data'.ARCHIVE_PREFIX, 'files_returned2partner'.ARCHIVE_PREFIX];
	}
 
	public function beforeFilter(\Cake\Event\EventInterface $event)
    {
		parent::beforeFilter($event);
		$this->loginAccess();
	}

	public function indexPartner(){
		$this->index('returnPartner');
	}

	public function returnPartnerNew(){
		$this->index('returnPartnerNew'); 
	//	$this->FilesReturned2partner->test();exit;
		$this -> render('index');
	}

    public function index($pageType = '')
    { 
		$pageTitle = 'Return To Partner';
		$this->set(compact('pageTitle'));

		$this->setPageType($pageType);
		
		// set company Id in app controller
		$requestData = $this->request->getData();
		$company_id = $this->setCompanyId($requestData); 
		
		/************** Index page Post****************/
		// Add recording details RecordingData  completeOrderDataSheet
		if( NULL !== $this->request->getData('recordingData')){
			$this->_processReturnData($requestData);
		}
		
		if( NULL !== $this->request->getData('completeOrderDataSheet')){
			$this->_processReturnData($requestData, true);
		}
		
		/************END Index page Post******************/
		// remove and rearrange order for number key array
		if($this->user_Gateway){
			unset($this->columns_alise["FileNo"]);
			array_splice($this->columnsorder,1,1); // 1-> key number, 1->count
		}
		
		// Check user is admin or not
		if($this->user_Gateway){
			$noOrder = ['Actions'];
			unset($this->columns_alise['Checkbox']);
		}else{
			//unset($this->columns_alise['Actions']);
			$noOrder = ['Checkbox', 'Actions'];
		}
		$this->set('dataJson', $this->CustomPagination->setDataJson($this->columns_alise,$noOrder));

        // step for datatable config : 4

		//end step
		$isSearch = 0;
        $formpostdata = '';
        if($this->request->is(['patch', 'post', 'put'])) {
            $formpostdata = $this->request->getData();
			$isSearch = 1;
        }
		
        $this->set('formpostdata', $formpostdata);
        //end step
		$this->set('isSearch', $isSearch);
        
        $this->loadModel("CompanyFieldsMap");
		$partnerMapField =  $this->CompanyFieldsMap->partnerMapFields($company_id,1);
		
		$this->loadModel("DocumentTypeMst");
        $DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
        $companyMsts = $this->CompanyFieldsMap->CompanyMst->companyListArray()->toArray();

		// partener company List
		$partnerCompanyList = $this->CompanyFieldsMap->CompanyMst->partnerCompanyList();

		$FilesReturned2partner = null; //$this->FilesReturned2partner;
        $this->set(compact('FilesReturned2partner', 'companyMsts', 'DocumentTypeData', 'partnerMapField', 'partnerCompanyList'));
		//pr($this->columnsorder);
		$this->set('datatblHerader', $this->columns_alise);
        $this->set('_serialize', ['FilesReturned2partner']);		
		$fileSearchType = ['fmd'=>'File / Record Added', 'fcd'=>'Document CheckIn (Received)', 'fad'=>'Accounting', 'fsad'=>'Submission To County', 'fqcd'=>'Open Rejection Date', 'frd'=>'Recorded', 'frtp'=>'Return to Partner Submission'];

		$this->set('fileSearchType', $fileSearchType);
		// call page 
		$this->set('pageType', $this->pageType);

		// index page button
		if( null !== ($this->request->getData('completeOrderDataSheet'))){  
			$this->returnManagementData($this->request->getData(), 'P');
		}
		
		//return to partner section 
		if( null !== ($this->request->getData('generateDataSheet')) && ($this->pageType == 'returnPartner')){
			$this->returnManagementData($this->request->getData());
		}
	 
    }

	
	private function setPageType($pageType){
		// set default
		$this->pageType = (empty($pageType)) ? $this->pageType : $pageType;;
	}
	
	public function generateReturnfileSheet()
    { 
		$pageTitle = 'Generate Return File Sheet';
		$this->set(compact('pageTitle'));
       $FilesReturned2partner = $this->FilesReturned2partner;
	   
		if ($this->request->is(['patch', 'post', 'put'])) 
		{
			if(null !== ($this->request->getData('generateSheetBtn'))){
				$postData = $this->request->getData();
				$companyId = $postData['company_id'];
				
				$fromDate = $postData['StartDate'];
				$toDate = $postData['EndDate'];

				$chkStartDate = $this->validateDate($fromDate); 
				$chkEndDate = $this->validateDate($toDate); 
				
				if($chkStartDate == 1 && $chkEndDate == 1) {
					if(!empty($companyId)){
						$postData['file_search_type'] = 'frtp';
						
						$this->returnManagementData($postData, 'P');
						$this->set(compact('fromDate', 'toDate'));
					}else{
						$this->Flash->error(__('Please select partner!!'));
					}
				} else {
					$this->Flash->error(__('Please enter proper From Date / To Date.'));
				}
			}
		}

		$this->loadModel('CompanyMst');
		$companyMsts = $this->CompanyMst->companyListArray();
		
        $this->set(compact('FilesReturned2partner', 'companyMsts'));
        $this->set('_serialize', ['FilesReturned2partner']);
    }


	// step for datatable config : 5 main step
    public function ajaxListIndex(){

		$this->autoRender = false;

	    $is_index = $this->request->getData('is_index');
	    $this->setPageType($is_index);
 
	    //$this->setExtraFields(); 
	    $processingstatus = 'NP'; // not processed
		$formdata = $this->request->getData('formdata');
 
		if(isset($formdata['processingstatus'])){
			$processingstatus = $formdata['processingstatus'];
		}
	 
		if(isset($formdata['processingstatus']))
			unset($formdata['processingstatus']);

		$pdata = $this->postDataCondition($this->request->getData(), false);

		 
		// Remove query limit for all records
		if($pdata['condition']['limit'] == -1){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']);
		} // END
		
	
		$postData = $this->request->getData('formdata');
		$query = $this->setFilterQuery($postData, $pdata, $processingstatus);
		//echo ' ==================  22 ======================= ';
		//debug($query->sql());exit;
		// new 
		$recordsTotal = $this->FilesReturned2partner->getQueryCountResult($query, 'count'); 

        $data =  $this->FilesReturned2partner->getQueryCountResult($query);
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

	private function postDataCondition(array $postData, $fields=false){
		
		//remove/pop extra fields
		if(!$fields){
			// index call
			array_shift($this->columns_alise);
			//array_pop($this->columns_alise); //Action
			unset($this->columns_alise['Actions']);
			$this->columns_alise["SrNo"] = "fmd.Id";
			$this->columns_alise["recId"] = "frtp.Id";
			$this->columns_alise["DocumentTitle"] = "dtm.Title";
		}else{
			// generate sheet call
			$this->columns_alise = [];  //??
			$this->columns_alise["recId"] = "frtp.Id";
			$this->columns_alise["SrNo"] = "fmd.Id";
		}
		$this->columns_alise["lock_status"] = "fcd.lock_status";
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
	
	// step for datatable config : 6 custome data action
    private function getCustomParshingData(array $data){
        // manual

		$count = 1;
        foreach ($data as $key => $value) {
	
			if($this->pageType != 'MSTP'){ // manage custome
				$checkboxdisabled = (($value["lock_status"] == 1) ? 'disabled' : '');
				$value['Checkbox'] = '<input type="checkbox" id="checkAll[]" '.$checkboxdisabled.' name="checkAll[]" value="'.$key.'_'.$value["recId"].'" class="checkSingle"/>
				<input type="hidden" id="fmdId_'.$key.'" name="fmdId[]" value="'.$value["SrNo"].'"/>
				<input type="hidden" id="docTypeId_'.$key.'" name="docTypeId[]" value="'.$value["TransactionType"].'"/>
				<input type="hidden" id="LRSNum_'.$key.'" value="'.$value["FileNo"].'_'.$value["TransactionType"].'" />';
			}else{ $value['Checkbox'] = $count; }

			// prifix not use in  hideViewButton == 2 
			if($this->user_Gateway){
				$value['Actions'] = $this->CustomPagination->getUserActionButtons($this->name,$value,['recId','SrNo','TransactionType'], 'common');
			}else{
				$value['Actions'] = $this->CustomPagination->getActionButtons($this->name,$value,['SrNo','County','recId','TransactionType'],$prefix = '', $hideViewButton = 8);
			}
			
			$value['ECapable'] = '<span style="color:green">'.$value["ECapable"].'</span>';  
            $value['TransactionType'] = '<input type="hidden"  class="doctypeHiddenCls" value="'.$value["TransactionType"].'"> '.$value["TransactionType"].' ( '.$value["DocumentTitle"].' )';  

			$count++;
        }

        unset($data['recId']);
        return $data;
    }
	

	private function setFilterQuery($requestFormdata=[], $pdata=[], $processingstatus='NP', $selectedIds=null){
		//=====================filter conditions===============================================
		 
		//$this->loadModel('FilesMainData');
		$whereCondition = []; 
		// complte records
		 
		if(isset($processingstatus)){
			//processingstatus == NP
			 
			$whereCondition = [ 'frtp.RTPProcessingDate IS' => NULL,  'frd.RecordingProcessingDate IS NOT' => NULL, 'frd.pdf_generate'=>'Y',  'fqcd.Status IN' => ['OK','']];
			 
			if($processingstatus == 'P'){
				$whereCondition = ['frtp.RTPProcessingDate IS NOT' => NULL, 'frd.RecordingProcessingDate IS NOT' => NULL, 'frd.pdf_generate'=>'Y',   'fqcd.Status IN' => ['OK','']];
			} 

			// new change
			if($this->pageType == 'returnPartnerNew'){
				$whereCondition = [ 'frd.RecordingProcessingDate IS NOT' => NULL, 'frd.pdf_generate'=>'Y',  'fqcd.Status IN' => ['OK','']];
			}
		}
		
		// for records sheet of only selected records
		if(!is_null($selectedIds)){
			
			$selectedIds = $this->CustomPagination->setOnlyRecordIds($selectedIds, $requestFormdata);
  
			$whereCondition = array_merge($whereCondition, ['frd.RecId IN' => $selectedIds['fmd'], 'frd.TransactionType IN' => $selectedIds['doc']]);
		}

		$dateFldTable = ['fmd'=>"fmd.DateAdded", 'fcd'=>"fcd.CheckInProcessingDate", 'fqcd'=>"fqcd.QCProcessingDate", 'fsad'=>"fsad.ShippingProcessingDate", 'fad'=>"fad.AccountingProcessingDate", 'frd'=>"frd.RecordingProcessingDate", 'frtp'=>"frtp.RTPProcessingDate"];
		
		if(!empty($requestFormdata['StartDate']) || !empty($requestFormdata['EndDate'])){
			$fcd = (!empty($requestFormdata['file_search_type']) ? $requestFormdata['file_search_type']: 'fcd');
			$whereCondition = @array_merge($whereCondition,[$this->FilesReturned2partner->FilesMainData->dateBetweenWhere($requestFormdata['StartDate'],$requestFormdata['EndDate'], $dateFldTable[$fcd])]);
 		}
				
		// set condtion for partner view
		$whereCondition = $this->addCompanyToQuery($whereCondition);
		
		// new change for return to partner custome query
		if($this->pageType == 'returnPartnerNew'){
			$orderArr = [];
			$orderArr['processingstatus'] = $processingstatus;
			$orderArr['order'] = $pdata['condition']['order']; unset($pdata['condition']['order']);
			if(isset($pdata['condition']['limit'])) 
				{
					$orderArr['limit'] = $pdata['condition']['limit']; unset($pdata['condition']['limit']);
				
					$orderArr['offset'] = $pdata['condition']['offset'];   unset($pdata['condition']['offset']);
				}
			}
		 
		$query = $this->FilesReturned2partner->FilesMainData->return2PartnerQuery($whereCondition, $pdata['condition']);
		
		
		// behavior
		if(!empty($requestFormdata['file_search_type']) && (!empty($requestFormdata['StartDate']) || !empty($requestFormdata['EndDate']))){
			$tableFldCount = $this->FilesReturned2partner->FilesMainData->tblFldCountExport([$dateFldTable[$requestFormdata['file_search_type']]]); 
			$query = $this->FilesReturned2partner->getOtherTableJoin($query, $tableFldCount,null,null,null,$this->skipJoin);
		}
		//$query = $this->FilesReturned2partner->FilesMainData->dateFieldsAddtoQuery($query, $requestFormdata,$this->skipJoin);
 		//pr($requestFormdata); 
		// new change for return to partner custome query
		if(($this->pageType == 'returnPartnerNew') && !isset($requestFormdata['callfor'])){
			return $this->getCustomeQuery($query, $orderArr);
		}
		  
		return $query;
	}

 
	private function getCustomeQuery($query, $orderArr){
		$query = $query->select(['RTPProcessingDate'=>'if(ISNULL(frtp.RTPProcessingDate), "", frtp.RTPProcessingDate)']);
		if($orderArr['processingstatus'] == 'P'){
			$where = ['sub.RTPProcessingDate !='=> ""];
		}else{
			$where = ['sub.RTPProcessingDate'=> ""];
		}
		 
		$queryMain = $this->FilesReturned2partner->find()
		->select(['FileNo' => 'sub.FileNo', 
			'PartnerFileNumber'=> 'sub.PartnerFileNumber',
			'TransactionType'=> 'sub.TransactionType',
			'Grantors'=> 'sub.Grantors',
			'Grantees'=> 'sub.Grantees',
			'County'=> 'sub.County', 
			'State'=> 'sub.State',
			'ECapable'=> 'sub.ECapable',
			'CarrierName'=> 'sub.CarrierName',
			"CarrierTrackingNo" => "sub.CarrierTrackingNo",
			'SrNo'=> 'sub.SrNo',
			'recId'=> 'sub.recId',
			'DocumentTitle'=> 'sub.DocumentTitle',
			'RTPProcessingDate'=>'sub.RTPProcessingDate',
			'lock_status'=> 'sub.lock_status'  
		])
		->from(['sub'=>$query])->where($where); 
		 
		$or_key =   array_keys ($orderArr['order']);
		$or_key_name =  explode('.',$or_key[0]); // remove prifix
		$order_key = ['sub.'.$or_key_name[1] => $orderArr['order'][$or_key[0]]];

		$queryMain->order($order_key);
		if(isset($orderArr['limit'])) 
		{
			$queryMain->limit([$orderArr['offset'],$orderArr['limit']]) ;
		}
	 //->disableHydration() 
	 	//debug($queryMain->sql());
		return $queryMain;
	}
 
	// use mainly for generetare excel sheet
	// $isWhere not use in this function 
	public function returnManagementData(array $postData=[], $processing=''){
 
		//$this->setExtraFields();
		$requestData = $this->request->getQuery();
		 
		if(isset($requestData) && !empty($requestData) && empty($postData)){ 
			$this->autoRender = false;
			$postData = $requestData;
			$getLimit = explode('-',$postData['limit']);
			unset($postData['limit']);
			
			$processing = $postData['processing'];
			unset($postData['processing']);
		}
		if(isset($postData['generateSheetBtn'])){ unset($postData['generateSheetBtn']); }
		
		// get unique comapnyid from post records
		$companyId = $this->setCompanyId($postData);
		
		//===================== generete csv file data & name to export data====================//	
	 
		//$querymapfields for both condition map fields found or not
		$pdata = $this->postDataCondition(['formdata'=>$postData,'draw' => 1,'order'=>null], true);
 
		$processing = (empty($processing)) ? $postData['processingstatus'] : $processing ; //NP;
	  
		$postData['callfor'] = 'pdf';
		if(isset($postData['checkAll']) && !empty($postData['checkAll'])){
			$selectedIds = $postData['checkAll'];
			$query = $this->setFilterQuery($postData, $pdata, $processing, $selectedIds);
		}else{
			$query = $this->setFilterQuery($postData, $pdata, $processing);
		}
	 
		$this->skipJoin = $this->checkSkipTable($postData, $this->skipJoin);
		// behaviour call for adding extra fields for CSV sheet
		
		/* $listRecord = $this->FilesReturned2partner->searchExportByDateRange($query, $partnerMapFields, '', $skipJoin);

		if(array_key_exists(0,$listRecord['records']))
		{	
			//send only headers from headerParams
			$csvFileName = $this->CustomPagination->recordExport($listRecord['records'], array_keys($listRecord['headerParams']), $csvNamePrifix, 'export');

			$this->set('csvFileName',$csvFileName);
			$this->Flash->success(__('Return to partner records sheet listed!!'));

		}else{
			$this->Flash->error(__('Return to partner Records not found!!'));
		} */
		 
		/********************* NEW CHANGE *******************************/
		$limitPrifix = '';
		$callType = 'form';
		// call from link
		if(!empty($this->request->getQuery()) && is_array($getLimit)){
			// add limit prifix to csv file name
			$limitPrifix = "_".($getLimit[0]+1)."-".($getLimit[0] + $getLimit[1]); 
			$callType = 'link';
			
			// add limit to query
			$query = $query->limit($getLimit[1])->offset($getLimit[0]);
		}
	 
		$resultQuery = $this->FilesReturned2partner->generateQuery($query);
		// pr($resultQuery);exit;
		$countRows = 0; // link 
		if($callType == 'form'){
			$countRows = $this->FilesReturned2partner->getQueryCountResult($resultQuery['query'], 'count');
		}
		// add csvNamePrifix to result array
 
		if($countRows <= ROWLIMIT){
	 
			$resultQuery['companyId'] = $companyId;
			$resultQuery['limitPrifix'] = $limitPrifix;
			// generate CSV sheet to download
			$this->generateCsvSheet($resultQuery, $callType);
			
		}else{
			 
			// generate CSV link to download call from component 
			$postData['processing'] = $processing;
			$pagelink = Router::url(['controller'=>$this->name,'action'=>'returnManagementData', '?'=>$postData]);

			$pdfDownloadLinks = $this->CustomPagination->generateCsvLink($countRows,$pagelink);
			if(!empty($pdfDownloadLinks)){
				$this->set('pdfDownloadLinks',$pdfDownloadLinks);
				//$this->Flash->success(__('Return to partner sheet links listed!!'));
			}else{
				$this->Flash->error(__('Records not found!!'));
			}
		}

	}
	
	
	private function _getpartnerMapData($companyId){
		
		
		$partnerMapData = $this->FilesReturned2partner->FilesMainData->partnerExportFields($companyId,'cef_fieldid4RP','rf2psheet');
				
		$partnerMapFields = $partnerMapData['partnerMapFields'];
		$csvNamePrifix = $partnerMapData['csvNamePrifix'];
		if($this->user_Gateway && isset($partnerMapFields['NATFileNumber'])){
			unset($partnerMapFields['NATFileNumber']);
		}
		
		return ['partnerMapFields'=>$partnerMapFields, 'csvNamePrifix'=>$csvNamePrifix];
		
	}
	
	private function generateCsvSheet($resultQuery=[], $callType = 'form'){
		$csvFileName ='';
		
		$partnerMapData = $this->_getpartnerMapData($resultQuery['companyId']);

		$csvNamePrifix = $partnerMapData['csvNamePrifix'].$resultQuery['limitPrifix'];

		$param  = ['partnerMapFields'=>$partnerMapData['partnerMapFields'], 'skipJoin'=>$this->skipJoin, 'onlyQuery'=>false];

		// behaviour call for adding extra fields for CSV sheet
		$resultQuery = $this->FilesReturned2partner->generateQuery($resultQuery['query'], $param);
		
		$resultRecord = $this->FilesReturned2partner->getQueryCountResult($resultQuery['query']);
		
		$listRecord = $this->FilesReturned2partner->setListRecords($resultRecord, $resultQuery['headerParams']);
	 
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
			//$this->Flash->success(__('Return to partner sheet listed!!'));
 
		}else{
			$this->Flash->error(__('Records not found!!'));
		}

	}
	
	
	private function checkSkipTable($postData,$skipJoin){
		if(!empty($postData['DocumentStartDate'])){
			array_push($skipJoin, 'files_checkin_data'.ARCHIVE_PREFIX);
		}
		if(!empty($postData['AccountingStartDate'])){
			array_push($skipJoin, 'files_accounting_data'.ARCHIVE_PREFIX);
		}
		if(!empty($postData['ShipStartDate'])){
			array_push($skipJoin, 'files_shiptoCounty_data'.ARCHIVE_PREFIX);
		}
		return $skipJoin;
	}
	
	private function _processReturnData(array $postData, $is_complete=false){
		
		$data= [];$return = false;
		if(isset($postData['checkAll'])){
			
			foreach($postData['checkAll'] as $checkValue){
				if(!empty($checkValue)&& strpos($checkValue, '_')){
					$postkeys = explode('_',$checkValue);
					$keyVal = $postkeys[0];
					$recordVal = $postkeys[1];

					$filesMainId = $postData['fmdId'][$keyVal];
					$documentTypeId = $postData['docTypeId'][$keyVal];
					
					if(isset($postData['CarrierName']) && !empty($postData['CarrierName'])) {
						$data['CarrierName'] =  $postData['CarrierName'];
					}
				
					if(isset($postData['CarrierTrackingNo']) && !empty($postData['CarrierTrackingNo'])) {
						$data['CarrierTrackingNo'] =  $postData['CarrierTrackingNo'];
					}
					
					// send to recording 
					if($is_complete){
						$data['RTPProcessingDate'] = Date("Y-m-d");
						$data['RTPProcessingTime'] = Date("H:i:s");
					} 

					$return = $this->_addUpdateReturnDetails($filesMainId, $documentTypeId, $data, $recordVal);
				}
			} // foreach
		}
		
		if($return){
			$this->Flash->success(__('Return to partner data has been saved.'));
		}else{
			$this->Flash->error(__('Return to partner data could not be saved. Please, try again.'));
		}

	}
	
	
	private function _addUpdateReturnDetails($filesMainId, $documentTypeId, array $data, $checkValue=''){
		$return = FALSE; 
		$section = 'RF2P';
		
		$data['RecId'] = $filesMainId;
		$data['TransactionType'] =$documentTypeId;
		$data['UserId'] = $this->currentUser->user_id;
		
		if(isset($data['publicData'])){
			$postRegarding = $data['publicData']['regarding']; 
			unset($data['publicData']);
		}
		
		//data insert/update for rejection carrier name & number
		if(empty($checkValue)){
			$return = $this->FilesReturned2partner->saveR2PData($data);
			$Regarding = (isset($postRegarding)) ? $postRegarding: 'Record Added';
		}else{
			$return = $this->FilesReturned2partner->updateR2PData($checkValue, $data);
     		$Regarding = (isset($postRegarding)) ? $postRegarding: 'Record Updated';
		}

		if($return){
			
			// add public notes
			$this->loadModel('PublicNotes');
			$this->PublicNotes->insertNewPublicNotes($filesMainId, $documentTypeId, $this->currentUser->user_id, $Regarding, 'Frtpd', true, $section);
		 
		}

		return $return;
		
	}
	
	
  	/**
     * View method
     *
     * @param string|null $id Files Returned2partner id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pageTitle = 'Return File Details';
		$this->set(compact('pageTitle'));
		
        $recordMainId = $this->request->getParam('fmd');
		$doctype = $this->request->getParam('doctype');
		if(empty($recordMainId) || empty($doctype)){
			return $this->redirect(['action' => 'indexPartner']);exit;
		}		
		
		//$this->loadModel('FilesMainData');
		$filesMainData = $this->FilesReturned2partner->FilesMainData->searchMainDataForAll($recordMainId);
		if(empty($filesMainData)){
			$this->Flash->error(__('Please select correct record.'));
			return $this->redirect(['action' => 'indexPartner']);exit;
		}
		
		$FilesReturned2partner = $this->FilesReturned2partner->getR2PEditData($recordMainId,$doctype);
		
		$documentData = $this->FilesReturned2partner->DocumentTypeMst->get($doctype);
		$documentDataList= [$documentData['Id']=>$documentData['Title']];
		
		$this->loadModel("CompanyFieldsMap");
		$partnerMapField = $this->CompanyFieldsMap->partnerMapFields($filesMainData['company_id'],1);

        $this->set(compact('FilesReturned2partner', 'filesMainData', 'documentData', 'documentDataList','partnerMapField'));
        $this->set('_serialize', ['FilesReturned2partner']);
    }

  

    /**
     * Edit method
     *
     * @param string|null $id Files Returned2partner id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$recordMainId = $this->request->getParam('fmd');
		$doctype = $this->request->getParam('doctype');
		$section = $this->request->getParam('section');
		$this->set('section', $section);
		if(empty($recordMainId) || empty($doctype)){
			return $this->redirect(['action' => 'index']);exit;
		}
		
		$saveBtn = $this->request->getData('saveBtn'); 
        if ($this->request->is(['patch', 'post', 'put']) && isset($saveBtn))
		{
			$data= [];$return = false;
			$postData = $this->request->getData();

			$filesMainId = $postData['fmdId'];
			$documentTypeId = $postData['docTypeId'];
			$returnId =  $postData['returnId'];

			if(isset($postData['CarrierName']) && !empty($postData['CarrierName'])) {
				$data['CarrierName'] =  $postData['CarrierName'];
			}
			
			if(isset($postData['CarrierTrackingNo']) && !empty($postData['CarrierTrackingNo'])) {
				$data['CarrierTrackingNo'] =  $postData['CarrierTrackingNo'];
			}
			
			if(isset($postData['RTPProcessingDate'])) {
				$data['RTPProcessingDate'] = (!empty($postData['RTPProcessingDate'])) ? date("Y-m-d", strtotime($postData['RTPProcessingDate'])) : date('Y-m-d');
				$data['RTPProcessingTime'] = date("H:i:s");
			}
			
			
			$data['publicData']['publicType'] = $postData['publicType'];
			$data['publicData']['regarding'] = $postData['Regarding'];
			
			$return = $this->_addUpdateReturnDetails($filesMainId, $documentTypeId, $data, $returnId);

			if($return){
				$this->Flash->success(__('Return file data has been saved.'));
				// check this
				if(isset($section) && ($section == 'complete')){
					return $this->redirect([
						'controller' => 'PublicNotes',
						'action' => 'viewComplete',$recordMainId,$doctype
					]);
				}else{ 
					return $this->redirect(['action' => 'index']);
				}
			}else{
				$this->Flash->error(__('Return file could not be saved. Please, try again.'));
			}
			
        }
		
		
		//$this->loadModel('FilesMainData');
		$filesMainData = $this->FilesReturned2partner->FilesMainData->searchMainDataForAll($recordMainId);
		//pr($filesMainData);
		if(empty($filesMainData)){
			$this->Flash->error(__('Please select correct record.'));
			return $this->redirect(['action' => 'index']);exit;
		}
		
		$FilesReturned2partner = $this->FilesReturned2partner->getR2PEditData($recordMainId,$doctype);
		
		$documentData = $this->FilesReturned2partner->DocumentTypeMst->get($doctype);
		$documentDataList= [$documentData['Id']=>$documentData['Title']];
		
		$this->loadModel("CompanyFieldsMap");
		$partnerMapField = $this->CompanyFieldsMap->partnerMapFields($filesMainData['company_id'],1);
		$pageTitle = 'Return File for <u>'.$filesMainData['PartnerFileNumber'].'</u>';
		$this->set(compact('pageTitle'));
        $this->set(compact('FilesReturned2partner', 'filesMainData', 'documentData', 'documentDataList','partnerMapField'));
        $this->set('_serialize', ['FilesReturned2partner']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Files Returned2partner id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $filesReturned2partner = $this->FilesReturned2partner->get($id);
        if ($this->FilesReturned2partner->delete($filesReturned2partner)) {
            $this->Flash->success(__('The files returned2partner has been deleted.'));
        } else {
            $this->Flash->error(__('The files returned2partner could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
