<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Routing\Router;
/**
 * MasterData Controller
 *
 * @method \App\Model\Entity\MasterData[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MasterDataController extends AppController
{
	private $columns_alise = [  "Checkbox" => "",
                                "FileNo" => "fmd.NATFileNumber",
                                "PartnerFileNumber" => "fmd.PartnerFileNumber",
                                "TransactionType" => "fva.TransactionType",
                                "Grantors" => "fmd.Grantors",
                                "StreetName" => "fmd.StreetName",
                                "County" => "fmd.County",
                                "State" => "fmd.State",
                                "Status" => "fva.Status",
                                "ECapable" => "fmd.ECapable"
                            ];

	private $columnsorder = [0=>'fmd.Id', 1=>'fmd.NATFileNumber', 2=>'fmd.PartnerFileNumber', 3=>'fva.TransactionType', 4=>'fmd.Grantors', 5=>'fmd.StreetName', 6=>'fmd.County', 7=>'fmd.State', 8=>'fva.Status', 9=>'fmd.ECapable'];
	
	private $CRskipJoin =[];
	private $MSskipJoin = [];
	public $isWhere = 'P';
	
	public $fileSearchType = ['fmd'=>'File / Record Added', 'fva'=>'Document CheckIn (Received)', 'fad'=>'Accounting', 'fsad'=>'Submission To County', 'fqcd'=>'Open Rejection Date', 'frd'=>'Recorded', 'frtp'=>'Return to Partner Submission'];

	
	public function initialize(): void
	{
		parent::initialize();
	   $this->loadModel("FilesMainData");
	   $this->loadModel("CompanyFieldsMap");
	   $this->loadModel("CompanyMst");
	   $this->loadModel("DocumentTypeMst"); 
	   $this->loadModel("FilesRecordingData");
	   $this->loadComponent('GeneratePDF');
	   
	   $this->CRskipJoin = ['files_vendor_assignment'.ARCHIVE_PREFIX,'files_recording_data'.ARCHIVE_PREFIX,'files_qc_data'.ARCHIVE_PREFIX, 'files_returned2partner'.ARCHIVE_PREFIX];
	   $this->MSskipJoin = ['files_vendor_assignment'.ARCHIVE_PREFIX, 'files_recording_data'.ARCHIVE_PREFIX];
	}
	
	public function beforeFilter(\Cake\Event\EventInterface $event)
    {
		parent::beforeFilter($event);
		$this->loginAccess();
	}
	
	public function index(){
		 
		return $this->redirect(['action' => 'masterSearch']);
	}

	public function masterSearchPartner(){
		$this->advanceSearch(1);
		$this->set('pageTitle', 'Master Search');
	}
	
	public function managementReport(){
		
		$this->advanceSearch(1);
		$this->set('pageTitle', 'Management Report');
	}
	
	public function masterSearch(){
		
		$this->advanceSearch(1);
		$this->set('pageTitle', 'Master Search');
	}
	public function advanceSearch($isSearch = 0){
		$this->setExtraFields("master");
		
		$currentURL = $this->getRequest()->getRequestTarget(); 
		$this->set('currentURL', $currentURL);
		
		// set company Id in app controller
		$requestData = $this->request->getData();
		$company_mst_id = $this->setCompanyId($requestData);
		
		// Check user is admin or not
		if($this->user_Gateway){
			$noOrder = ['Actions'];
			unset($this->columns_alise['Checkbox']);
		}else{
			//unset($this->columns_alise['Actions']);
			$noOrder = ['Checkbox', 'Actions'];
			unset($this->columns_alise['ECapable']);
		}
		
		// End add Account details
		$this->set('dataJson', $this->CustomPagination->setDataJson($this->columns_alise,$noOrder));

        // step for datatable config : 4 

		//end step
        $formpostdata = '';
        if ($this->request->is(['patch', 'post', 'put'])) {
            $formpostdata = $this->request->getData();
			$isSearch = 1;
        }
		
        $this->set('formpostdata', $formpostdata);
        //end step
		$this->set('isSearch', $isSearch);		
		
        $DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();		
		
		$partnerMapField =  $this->CompanyFieldsMap->partnerMapFields($company_mst_id,1);
		
        $companyMsts = $this->CompanyMst->companyListArray()->toArray();
		
		// partener company List
		$partnerCompanyList = $this->CompanyMst->partnerCompanyList();
		
        $MasterData = null;//$this->MasterData;
        $this->set(compact('MasterData','companyMsts','DocumentTypeData','partnerMapField', 'partnerCompanyList'));
		$this->set('datatblHerader', $this->columns_alise);
        $this->set('_serialize', ['MasterData']);
        $this->set('pageTitle', 'Advance Search');
		
		$this->set('fileSearchType', $this->fileSearchType); 

		// generate sheet
		$generateDataSheet = $this->request->getData('generateDataSheet');
		if(isset($generateDataSheet)){
			$this->masterManagementData($this->request->getData(), 'MS');
		}
		
	}
	
	private function setExtraFields($type="index"){

	   if($type=="master"){
			
		 	unset($this->columns_alise["Status"],  $this->columns_alise["StreetName"]);
			
			$this->columns_alise["Actions"] = ""; 
			
			$this->columns_alise["TransactionType"] = "fva.TransactionType"; // custome table alise change
			
			unset($this->columnsorder[8]); //$this->columnsorder[5],
			
			$this->columnsorder[3]= "fva.TransactionType"; // custome table alise change
			
			if($this->user_Gateway){
				unset($this->columns_alise["FileNo"]);
				unset($this->columnsorder[1]);
			}
			// remove and rearrange order for number key array
			array_splice($this->columnsorder,5,1);   //4

	   }
	   if($type=="complete"){
		   
			unset($this->columns_alise["Status"],  $this->columns_alise["StreetName"]);

			$this->columns_alise["CarrierName"] = "frtp.CarrierName";
			$this->columns_alise["CarrierTrackingNo"] = "frtp.CarrierTrackingNo";
			
			$this->columns_alise["Actions"] = ""; 
			
			unset($this->columnsorder[8]); //$this->columnsorder[5], 
			$this->columnsorder[] = "frtp.CarrierName ";
			$this->columnsorder[] = "frtp.CarrierTrackingNo";
 
			if($this->user_Gateway){
 
				unset($this->columns_alise["FileNo"]);
				unset($this->columnsorder[1]);
			}

			// remove and rearrange order for number key array
			array_splice($this->columnsorder,5,1); 

 
	   }
 
	}
	
	// use mainly for generetare excel sheet
	public function masterManagementData(array $postData=[], $isWhere='P'){
		$getQuery = $this->request->getQuery();
		if(isset($getQuery) && !empty($getQuery) && empty($postData)){

			$this->autoRender = false;
			$postData = $this->request->getQuery();
			$getLimit = explode('-',$postData['limit']);
			unset($postData['limit']);
			
			$isWhere = $postData['isWhere'];
			unset($postData['isWhere']);
		}
		if(isset($postData['generateSheetBtn'])){ 
			unset($postData['generateSheetBtn']); 
		}
		$this->isWhere =$isWhere;
		// get unique comapnyid from post records
		$companyId = $this->setCompanyId($postData);

		//===================== generete csv file data & name to export data====================//	
		 if($isWhere == 'CR'){ 
			$this->CRskipJoin = $this->checkSkipTable($postData,$this->CRskipJoin,'CR');
		}else{
			//for master pages
			$this->MSskipJoin = $this->checkSkipTable($postData,$this->MSskipJoin,'MS');
		} 

		//$querymapfields for both condition map fields found or not
		$pdata = $this->postDataCondition(['formdata'=>$postData,'draw' => 1,'order'=>null], true);

		if(isset($postData['checkAll']) && !empty($postData['checkAll'])){
			$selectedIds = $postData['checkAll'];
			$query = $this->setFilterQuery($postData, $pdata, $isWhere, $selectedIds);
		}else{
			$query = $this->setFilterQuery($postData, $pdata, $isWhere);
		} 
		
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

		// behaviour call 
		$resultQuery = $this->FilesMainData->generateQuery($query);
		//debug($resultQuery);exit;
		/**************/
		$countRows = 0; // link pass with limit so its always <= 500
		if($callType == 'form'){ 
			$countRows = $this->FilesMainData->getQueryCountResult($resultQuery['query'], 'count'); 
		}
		/********************************/

		// add csvNamePrifix to result array
		if($countRows <= ROWLIMIT){
			/****************************
			*  for default result set from export field mapping.
			* send company ID blank New CHK 
			******** **/
			$resultQuery['companyId'] = ''; // $companyId; 
			$resultQuery['limitPrifix'] = $limitPrifix;
			
			// generate CSV sheet to download
			$this->generateCsvSheet($resultQuery, $callType);
		}else{
			// generate CSV link to download call from component 
			$postData['isWhere'] = $isWhere; 
			$pagelink = Router::url(['controller'=>$this->name,'action'=>'masterManagementData', '?'=>$postData]);

			$pdfDownloadLinks = $this->CustomPagination->generateCsvLink($countRows,$pagelink);
			
			if(!empty($pdfDownloadLinks)){
				$this->set('pdfDownloadLinks',$pdfDownloadLinks);
				$this->Flash->success(__('Records return to partner sheet links listed!!'));
			}else{
				$this->Flash->error(__('Records not found!!'));
			}
		}

	}
	
	private function checkSkipTable($postData,$skipJoin, $callType){
		
		if($callType === 'CR'){
			if(!empty($postData['DocumentStartDate'])){
				array_push($skipJoin, 'files_vendor_assignment'.ARCHIVE_PREFIX);
			}
			if(!empty($postData['AccountingStartDate'])){
				array_push($skipJoin, 'files_accounting_data'.ARCHIVE_PREFIX);
			}
			if(!empty($postData['ShipStartDate'])){
				array_push($skipJoin, 'files_shiptoCounty_data'.ARCHIVE_PREFIX);
			}
		}else{
			// MS
			if(!empty($postData['QCStartDate'])){
				array_push($skipJoin, 'files_qc_data'.ARCHIVE_PREFIX);
			}
			if(!empty($postData['RecordingStartDate'])){
				array_push($skipJoin, 'files_returned2partner'.ARCHIVE_PREFIX);
			}
			if(!empty($postData['ShipStartDate'])){
				array_push($skipJoin, 'files_shiptoCounty_data'.ARCHIVE_PREFIX);
			}
			if(!empty($postData['AccountingStartDate'])){
				array_push($skipJoin, 'files_accounting_data'.ARCHIVE_PREFIX);
			}
		}
		
		return $skipJoin;
	}
	
	// step for datatable config : 5 main step
    public function ajaxListIndex(){
       $this->autoRender = false;
	   $is_index = $this->request->getData('is_index');

	   $pageCall = 'master';
	   if($is_index =='CR'){ 
			$pageCall = 'complete';
			// set extra for complete records
			$this->columns_alise["File"] = "frd.File";
			$this->columns_alise["file_main_path"] = "frd.file_main_path";
	   }

	   $this->setExtraFields($pageCall);

		// value chenge on page call [CR, MS, MMR] setFilterQuery

		$pdata = $this->postDataCondition($this->request->getData());
		// Remove query limit for all records
		if($pdata['condition']['limit'] == -1){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']);
		} // END
		
		$query = $this->setFilterQuery($this->request->getData('formdata'), $pdata, $is_index);
		//@array_pop($this->columns_alise);
	
		// new
		$recordsTotal = $this->FilesMainData->getQueryCountResult($query, 'count');

		$data = $this->FilesMainData->getQueryCountResult($query);
		
        // customise as per condition for differant datatable use.
        $data = $this->getCustomParshingData($data,$is_index);

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
			unset($this->columns_alise['Actions']);
			$this->columns_alise["SrNo"] = "fmd.Id";
			$this->columns_alise["DocumentTitle"] = "dtm.Title";
		}else{
			// generate sheet call
			$this->columns_alise = [];  //??
			$this->columns_alise["recId"] = "frd.Id";
			$this->columns_alise["SrNo"] = "fmd.Id";
		}
		$this->columns_alise["ClientCompName"] = "cpm.cm_comp_name";
		$this->columns_alise["lock_status"] = "fva.lock_status";
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
	

	private function setFilterQuery($requestFormdata=[], $pdata=[], $processingstatus='NP', $selectedIds=null){
		//=====================filter conditions===============================================
		
		$whereCondition = [];
		 
		// for records sheet of only selected records 
		// complte records
		if(isset($processingstatus) && $processingstatus == 'CR'){
			$whereCondition = ['frtp.RTPProcessingDate IS NOT' => NULL, 'fqcd.Status IN' => ['OK','']]; // 'OR'=>['fqcd.Status' => 'OK', 'fqcd.Status IS' => NULL]
			 
			if(!is_null($selectedIds)){
				$selectedIds = $this->CustomPagination->setOnlyRecordIds($selectedIds, $requestFormdata);
				$whereCondition = array_merge($whereCondition, ['frtp.RecId IN' => $selectedIds['fmd'], 'frtp.TransactionType IN' => $selectedIds['doc']]);
			}
			
			$query = $this->queryWithProcessDate($requestFormdata, $pdata, $whereCondition, $this->CRskipJoin, 'CR');
			
		}
		
		// master Search // master Management report
		if(isset($processingstatus) && ($processingstatus == 'MS' || $processingstatus == 'MMR')){
			
			if(!is_null($selectedIds)){
				$selectedIds = $this->CustomPagination->setOnlyRecordIds($selectedIds, $requestFormdata);
				$whereCondition = array_merge($whereCondition, ['fva.RecId IN' => $selectedIds['fmd'], 'fva.TransactionType IN' => $selectedIds['doc']]);
			}

			$query = $this->queryWithProcessDate($requestFormdata, $pdata, $whereCondition, $this->MSskipJoin, 'MS');
		}
		
		return $query;
	}
	
	
	private function queryWithProcessDate($requestFormdata, $pdata, $whereCondition, $skipJoin, $processingstatus){
		// set condtion for partner view
		$whereCondition = $this->addCompanyToQuery($whereCondition); 
		$dateFldTable = ['fmd'=>"fmd.DateAdded", 'fva'=>"fva.CheckInProcessingDate", 'fqcd'=>"fqcd.QCProcessingDate", 'fsad'=>"fsad.ShippingProcessingDate", 'fad'=>"fad.AccountingProcessingDate", 'frd'=>"frd.RecordingProcessingDate", 'frtp'=>"frtp.RTPProcessingDate"];
		
		if(!empty($requestFormdata['StartDate']) || !empty($requestFormdata['EndDate'])){
			$fva = (!empty($requestFormdata['file_search_type']) ? $requestFormdata['file_search_type']: 'fva');
			$whereCondition = @array_merge($whereCondition,[$this->FilesMainData->dateBetweenWhere($requestFormdata['StartDate'],$requestFormdata['EndDate'], $dateFldTable[$fva])]);
			// add column to search in query as per selected section
			$this->columns_alise = array_merge($this->columns_alise, [$dateFldTable[$fva]]);
		}

		if($processingstatus == 'CR'){
			$query = $this->FilesMainData->completeMasterQuery($whereCondition, $pdata['condition']);
		}else{
			$query = $this->FilesMainData->masterSearchQuery($whereCondition, $pdata['condition']);
		}  
		
		// behavior
		if(!empty($requestFormdata['file_search_type']) && (!empty($requestFormdata['StartDate']) || !empty($requestFormdata['EndDate']))){
			$tableFldCount = $this->FilesMainData->tblFldCountExport([$dateFldTable[$requestFormdata['file_search_type']]]); 
			$query = $this->FilesMainData->getOtherTableJoin($query, $tableFldCount,null,null,null, $skipJoin);
		} 

		return $query;
	}

	// step for datatable config : 6 custome data action
    private function getCustomParshingData(array $data, $is_index=''){

        // manual
		$count = 1;
        foreach ($data as $key => $value) {
	
			if($is_index != 'MMR'){
				$checkboxdisabled = (($value["lock_status"] == 1) ? 'disabled' : '');
				$value['Checkbox'] = '<input type="checkbox" id="checkAll[]" '.$checkboxdisabled.' name="checkAll[]" value="'.$key.'_'.$value["recId"].'" class="checkSingle"/><input type="hidden" id="fmdId_'.$key.'" name="fmdId[]" value="'.$value["SrNo"].'"/><input type="hidden" id="docTypeId_'.$key.'" name="docTypeId[]" value="'.$value["TransactionType"].'" /><input type="hidden" id="LRSNum_'.$key.'" value="'.$value["FileNo"].'_'.$value["TransactionType"].'" />';
			}else{ 
				$value['Checkbox'] = $count; 
			}

			// prifix not use in  hideViewButton == 3
			if($this->user_Gateway){
				$value['Actions'] = $this->CustomPagination->getUserActionButtons($this->name,$value,['SrNo','TransactionType','File','file_main_path'], 'complete');
			}else{
				$value['Actions'] = $this->CustomPagination->getActionButtons($this->name,$value,['SrNo','File','recId','TransactionType','file_main_path'],$prefix = $is_index, $hideViewButton = 3);
			}
			
			$value['ECapable'] = '<span style="color:green">'.$value["ECapable"].'</span>';  
			$value['PartnerFileNumber'] = $value['PartnerFileNumber'] . ((!empty($value['ClientCompName'])) ? ' ( '.$value['ClientCompName'].' )': '' );
            $value['TransactionType'] = '<input type="hidden"  class="doctypeHiddenCls" value="'.$value["TransactionType"].'"> '.$value["TransactionType"].' ( '.$value["DocumentTitle"].' )';  

			$count++;
        }

        unset($data['recId']);
        return $data;
    }
	
	private function generateCsvSheet($resultQuery=[], $callType = 'form'){

		$csvFileName ='';
		$partnerMapData = $this->_getpartnerMapData($resultQuery['companyId']);
 
		$csvNamePrifix = $partnerMapData['csvNamePrifix'].$resultQuery['limitPrifix'];
		$skipJoin = ($this->isWhere == 'CR') ? $this->CRskipJoin: $this->MSskipJoin; 
		
		$param  = ['partnerMapFields'=>$partnerMapData['partnerMapFields'], 'skipJoin'=>$skipJoin, 'onlyQuery'=>false];
 
		// behaviour call for adding extra fields for CSV sheet
		$resultQuery = $this->FilesMainData->generateQuery($resultQuery['query'], $param);
		// behaviour call for adding extra fields for CSV sheet
 
		$resultRecord = $this->FilesMainData->getQueryCountResult($resultQuery['query']); // get result

		$listRecord = $this->FilesMainData->setListRecords($resultRecord, $resultQuery['headerParams']);

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
	
	private function _getpartnerMapData($companyId){

		if($this->isWhere == 'CR'){
			// complete records
			$partnerMapData = $this->FilesMainData->partnerExportFields($companyId,'cef_fieldid4CO','cmposheet');
		}else{
			//for master pages
			$partnerMapData = $this->FilesMainData->partnerExportFields($companyId,'cef_fieldid4MS','mssheet');
		}

		$partnerMapFields = $partnerMapData['partnerMapFields'];
		$csvNamePrifix = $partnerMapData['csvNamePrifix'];
		if($this->user_Gateway && isset($partnerMapFields['NATFileNumber'])){
			unset($partnerMapFields['NATFileNumber']);
		}
		
		return ['partnerMapFields'=>$partnerMapFields, 'csvNamePrifix'=>$csvNamePrifix];
		
	}

	public function viewpdf(){ 
		$pageTitle = 'Record file view';
		$this->set(compact('pageTitle'));
		$this->set('layoutShow',false);
		$is_fileExist = false;
		
		$recordMainId = $this->request->getParam('fmd');
		$doctype = $this->request->getParam('doctype');
		$pdfFileData = $this->FilesRecordingData->fetchRecordingFilePath($recordMainId, $doctype);
   
		if(!empty($pdfFileData)){
			//$is_fileExist = $this->setPdfPathFromCompany($pdfFile);
			$file_main_path = (!empty($pdfFileData['file_main_path']) ? DS . $pdfFileData['file_main_path'] : '');
			$pdf_fullpath = 'main'.  $file_main_path . DS .$pdfFileData['file'];
			$this->set('pdf_fullpath', $pdf_fullpath);
			$is_fileExist = true;
		}
		$this->set('is_fileExist',$is_fileExist);
	}
 
	// file is_exist
	private function setPdfPathFromCompany($pdfFile){
		// pdf files store in main folder with respective partner id folder
		$companyDir = $this->FilesMainData->fetchCompanyFromFile($pdfFile); 
		$companyDirPdfFile =  (!empty($companyDir) ? DS .$companyDir. DS .$pdfFile :  DS .$pdfFile);
		
		$pdf_fullpath = 'main'.$companyDirPdfFile;
		if(file_exists(WWW_ROOT.$pdf_fullpath)){ // check with company id 
			$is_fileExist = true;
			$this->set('pdf_fullpath',$pdf_fullpath);
		}elseif(file_exists(WWW_ROOT.'main'. DS .$pdfFile)){ // check direct in main folder 
			$is_fileExist = true;
			$this->set('pdf_fullpath', 'main'. DS .$pdfFile);
		}
		return $is_fileExist;
	}


	public function completeOrderPartner(){
		$this->completeOrder();
	}
	
	public function completeOrder(){

		$pageTitle = 'Completed Orders';

		$this->set(compact('pageTitle'));
		
		$this->setExtraFields("complete");
 
		$company_mst_id = $this->setCompanyId($this->request->getData());
		
		// Check user is admin or not
		if($this->user_Gateway){
			$noOrder = ['Actions'];
			unset($this->columns_alise['Checkbox']);
		}else{
			//unset($this->columns_alise['Actions']);
			$noOrder = ['Checkbox', 'Actions'];
		}
		
		// End add Account details
		$this->set('dataJson', $this->CustomPagination->setDataJson($this->columns_alise,$noOrder));
 
		$isSearch = 1;
        $formpostdata = '';
        if ($this->request->is(['patch', 'post', 'put'])) {
            $formpostdata = $this->request->getData();
			//$isSearch = 1;
        }

        $this->set('formpostdata', $formpostdata);
        //end step
		
		$this->set('isSearch', $isSearch); 
        
		$partnerMapField =  $this->CompanyFieldsMap->partnerMapFields($company_mst_id,1);
 
        $DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
        $companyMsts = $this->CompanyFieldsMap->CompanyMst->companyListArray()->toArray();

		// partener company List
		$partnerCompanyList = $this->CompanyFieldsMap->CompanyMst->partnerCompanyList();

		$MasterData = null;
        $this->set(compact('MasterData','companyMsts','DocumentTypeData','partnerMapField',
		'partnerCompanyList'));
		$this->set('fileSearchType', $this->fileSearchType);

		//exit;
		// for tabel header
		
		$this->set('datatblHerader', $this->columns_alise);
        $this->set('_serialize', ['MasterData']);
		
		// generate sheet
		$generateDataSheet = $this->request->getData('generateDataSheet');
		if(isset($generateDataSheet)){
			$this->masterManagementData($this->request->getData(), 'CR');
		}
		
	}
    /*
    **	Master View Method
    **	$id input parameter
    */
    public function masterView($id = null)
    {

    	// fetch records from fmd and fva table
		$filesCheckinData = $this->FilesMainData->getMainDataAll($id, false); // checkIn id
 
		if(!empty($filesCheckinData)){

			$fmd_id = $filesCheckinData['nat_file_number']; // file main data id
			$this->set('fmd_id', $fmd_id);

		} else {

			$this->Flash->error(__('Please select correct record.'));
			return $this->redirect(['action' => 'index']);exit;
		}


		//$id file check in data
		// set page title
		$pageTitle = 'NAT File Details';
		$this->set(compact('pageTitle', 'filesCheckinData'));

		$this->set('_serialize', ['filesCheckinData']);

	}

}
