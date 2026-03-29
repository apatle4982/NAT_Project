<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Routing\Router;
/**
 * FilesRecordingData Controller
 *
 * @property \App\Model\Table\FilesRecordingDataTable $FilesRecordingData
 * @method \App\Model\Entity\FilesRecordingData[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilesRecordingDataController extends AppController
{
    private $columns_alise = [  "Checkbox" => "",
                                "FileNo" => "fmd.NATFileNumber",
                                "PartnerFileNumber" => "fmd.PartnerFileNumber",
                                "TransactionType" => "fcd.TransactionType",
                                "Grantors" => "fmd.Grantors", 
                                "County" => "fmd.County",
                                "State" => "fmd.State",
                                "ECapable" => "fmd.ECapable"
                            ];
	
	private $pageType = 'index';
	
	private $columnsorder = [0=>'frd.Id', 1=>'fmd.NATFileNumber', 2=>'fmd.PartnerFileNumber', 3=>'fcd.TransactionType', 4=>'fmd.Grantors', 5=>'fmd.County', 6=>'fmd.State', 7=>'fmd.ECapable']; 

	private $skipJoin = [];
    private $generateCSV = false;

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

		$this->loadComponent('GeneratePDF');
	}
	
	public function beforeFilter(\Cake\Event\EventInterface $event)
    {
		parent::beforeFilter($event);
		$this->loginAccess();
	}
	
	public function indexPartner(){
		$this->index();
		$pageTitle = 'Recording Status';
		$this->set(compact('pageTitle'));
	}
	
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($pageType='')
    {
		if($pageType == 'keynoImage') {
			$pageTitle = 'Key No Image';
			$this->set(compact('pageTitle'));
		} else if($pageType == 'research') {
			$pageTitle = 'Research Records';
			$this->set(compact('pageTitle'));
		} else if($pageType == 'recordManage') {
			$pageTitle = 'Recording Management Report';
			$this->set(compact('pageTitle'));
		} 
		
		else {
			$pageTitle = 'Key With Image';
			$this->set(compact('pageTitle'));
		}
		
        $this->setPageType($pageType);
		
		$this->setExtraFields();
		 
		$requestData = $this->request->getData();
		$RecId = $this->setCompanyId($requestData); 

		// Check user is admin or not
		if($this->user_Gateway){
			$noOrder = ['Actions'];
			unset($this->columns_alise['Checkbox']);
		}else{ 
			$noOrder = ['Checkbox', 'Actions'];
		}
		$this->set('dataJson', $this->CustomPagination->setDataJson($this->columns_alise,$noOrder));
 
		$isSearch = 0; 
        $formpostdata = '';
        if ($this->request->is(['patch', 'post', 'put'])) {
            $formpostdata = $this->request->getData();
			$isSearch = 1; 
        }
		
        $this->set('formpostdata', $formpostdata);
		$this->set('isSearch', $isSearch); 
         
		$partnerMapField =  $this->CompanyFieldsMap->partnerMapFields($RecId,1);

        $DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
        $companyMsts = $this->CompanyMst->companyListArray()->toArray();
 
		$partnerCompanyList = $this->CompanyMst->partnerCompanyList();

		$FilesRecordingData = $this->FilesRecordingData->newEmptyEntity();
        $this->set(compact('FilesRecordingData', 'companyMsts', 'DocumentTypeData','partnerMapField', 'partnerCompanyList'));

		$this->set('datatblHerader', $this->columns_alise);
        $this->set('_serialize', ['FilesRecordingData']);		
 
		$this->set('pageType', $this->pageType);
		
        $fileSearchType = ['fmd'=>'File / Record Added', 'fcd'=>'Document CheckIn (Received)', 'fad'=>'Accounting', 'fsad'=>'Submission To County', 'fqcd'=>'Open Rejection Date', 'frd'=>'Recorded', 'frtp'=>'Return to Partner Submission'];

		$this->set('fileSearchType', $fileSearchType);

        $currentURL = $this->getRequest()->getRequestTarget(); 
		$this->set('currentURL', $currentURL);

		if(!empty($formpostdata['cm_file_enabled'])){
			$this->recordingManagementData($this->request->getData());
		}
 
		$reseach_status1 = isset($formpostdata['reseach_status1']) ? : "S";
		$this->set('reseach_status1',$reseach_status1);	
    }
      
    public function ajaxListIndex(){ 
		$this->autoRender = false;

		$is_index = $this->request->getData('is_index');
	    $this->setPageType($is_index);
		 
        $this->columns_alise["File"] = "frd.File";
		$this->columns_alise["file_main_path"] = "frd.file_main_path";

	    $this->setExtraFields();
		
	    $processingStatus = 'NP';
        $formdata = $this->request->getData('formdata');
		 
		if(isset($formdata['processingstatus'])){
			$processingStatus = $formdata['processingstatus'];
		}
	
		if(isset($formdata['processingstatus']))
			unset($formdata['processingstatus']);
		 
		$pdata = $this->postDataCondition($this->request->getData(), false);
		
		// Remove query limit for all records
		if($pdata['condition']['limit'] == -1){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']);
		} // END
		
		$query = $this->setFilterQuery($formdata, $pdata, $processingStatus);
		//debug($query->sql()); exit;
		$recordsTotal = $this->FilesRecordingData->getQueryCountResult($query, 'count');
 
        $data = $this->FilesRecordingData->getQueryCountResult($query);
        $data = $this->getCustomParsingData($data);

	    $response = array(
						"draw" => intval($pdata['draw']),
						"recordsTotal" => intval($recordsTotal),
						"recordsFiltered" => intval($recordsTotal),
						"data" => $data
					);

		echo json_encode($response); 
        exit;
    }

    private function setPageType($pageType=null){
		$this->pageType = (empty($pageType)) ? $this->pageType : $pageType;;
	}

    private function setExtraFields(){
		
		if($this->pageType=="recordManage"){ 
			$this->columns_alise["ProcDate_InstrumentNo"] = 'CONCAT(frd.RecordingProcessingDate,"<br>",frd.InstrumentNumber)';
		
			$this->columns_alise["Book_Page"] = 'CONCAT(frd.Book,"<br>",frd.Page)';
			
			$this->columns_alise["RecordingDate_RecordingTime"] = 'CONCAT(frd.RecordingDate,"<br>",frd.RecordingTime)';
			
			$this->columns_alise["File_RecordingNote"] = 'CONCAT(frd.File,"<br>",frd.RecordingNotes)';

			$this->columnsorder[3]= "fcd.TransactionType"; 
			$this->columnsorder[]= "frd.RecordingProcessingDate"; 
			$this->columnsorder[]= "frd.Book"; 
			$this->columnsorder[]= "frd.RecordingDate"; 
			$this->columnsorder[]= "frd.File"; 

			if($this->user_Gateway){
				// remove and rearrange order for number key array
				unset($this->columns_alise["FileNo"]);
				array_splice($this->columnsorder,1,1); // 1-> key number, 1->count
				$this->columns_alise["Actions"] = ""; 
			}
			
	   }else{
		   
			$this->columns_alise["Availability"] = 'cm.file_avl';
			$this->columns_alise["ShipToCounty"] = "fsad.ShippingProcessingDate";
			$this->columns_alise["RecordingInfoImageAvailability"] = "cm.rec_info_avl";
			$this->columns_alise["WebsiteURL"] = "cm.cm_link";
			
			$this->columns_alise["TransactionType"] = "fcd.TransactionType"; 
			$this->columns_alise["Actions"] = ""; 
			
			$this->columnsorder[3]= "fcd.TransactionType"; 
			$this->columnsorder[] = "cm.file_avl";
			$this->columnsorder[] = "fsad.ShippingProcessingDate";
			$this->columnsorder[] = "cm.rec_info_avl";
			$this->columnsorder[] = "cm.cm_link";
	   }
	}

    private function postDataCondition(array $postData, $fields=false){
		 
		if(!$fields){
			array_shift($this->columns_alise); 
			unset($this->columns_alise['Actions']);
			$this->columns_alise["SrNo"] = "fmd.Id";
			$this->columns_alise["recId"] = "frd.Id";
			$this->columns_alise["DocumentTitle"] = "dtm.Title";
		}else{ 
			$this->columns_alise = [];  
			$this->columns_alise["recId"] = "frd.Id";
			$this->columns_alise["SrNo"] = "fmd.Id";
		}
		
		$this->columns_alise["ClientCompName"] = "cpm.cm_comp_name";	
		$this->columns_alise["lock_status"] = "fcd.lock_status";
		if($this->generateCSV == true) {
			$this->columns_alise["Image"] = "CASE WHEN frd.File = '' THEN 'No' WHEN frd.File IS NULL THEN 'No' WHEN frd.File != '' THEN 'Yes' END";
			$this->columns_alise["EffectiveDate"] = 'frd.RecordingDate';

		}
			

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

    private function setFilterQuery($requestFormdata=[], $pdata=[], $processingStatus='NP', $selectedIds=null){ 
		$selectedIdsCondition = [];
		 
		$whereCondition = [];//['fsad.ShippingProcessingDate IS NOT' => NULL];
		if($this->pageType == 'research'){ 
			if(!empty($requestFormdata)) {
				
				if (!empty($requestFormdata['cm_file_enabled'])){
					$where["cm.cm_file_enabled"] = 'Y';
					$whereCondition = array_merge($whereCondition, $where);
				}  
				if(!empty($requestFormdata['reseach_status4']) && $requestFormdata['reseach_status4'] == 'EF'){
					$whereEF[] = " (fcd.search_status = 'E' OR fcd.search_status = 'F') ";
					$whereCondition = array_merge($whereCondition, $whereEF);
				}
				if(!empty($requestFormdata['reseach_status1'])){
					$whereSuccess[] = "fcd.search_status != '".$requestFormdata['reseach_status1']."'";
					$whereCondition = array_merge($whereCondition, $whereSuccess);
				}
				if(!empty($requestFormdata['reseach_status2'])){
					$whereFailNoFind[] = "fcd.search_status != '".$requestFormdata['reseach_status2']."'";
					$whereCondition = array_merge($whereCondition, $whereFailNoFind);
				}
				if(!empty($requestFormdata['reseach_status3'])){
					$whereFailEffectiveDate[] = "fcd.search_status != '".$requestFormdata['reseach_status3']."'";
					$whereCondition = array_merge($whereCondition, $whereFailEffectiveDate);
				}
			} else {
				$whereSuccess[] = "fcd.search_status != 'S'";
				$whereCondition = array_merge($whereCondition, $whereSuccess);
			}
		}
		
		$skipJoin = ['files_shiptoCounty_data'.ARCHIVE_PREFIX,'files_recording_data'.ARCHIVE_PREFIX];//$this->skipJoin;
		if($this->pageType == 'research'){
			array_push($skipJoin, 'files_checkin_data'.ARCHIVE_PREFIX);
			//$skipJoin = $this->checkSkipTable($requestFormdata,$skipJoin);
		} 
		if(isset($processingStatus)){
			$processingCondition = $this->setProcessCondition($processingStatus);
		}
		 
		if(!is_null($selectedIds)){			
			$selectedIds = $this->CustomPagination->setOnlyRecordIds($selectedIds, $requestFormdata);
			$selectedIdsCondition = ['fcd.RecId IN' => $selectedIds['fmd'], 'fcd.TransactionType IN' => $selectedIds['doc']];
		}
		
		$whereCondition = array_merge($whereCondition, $processingCondition, $selectedIdsCondition);
		 
		$whereCondition = $this->addCompanyToQuery($whereCondition);
		
		$dateFldTable = ['fmd'=>"fmd.DateAdded", 'fcd'=>"fcd.CheckInProcessingDate", 'fqcd'=>"fqcd.QCProcessingDate", 'fsad'=>"fsad.ShippingProcessingDate", 'fad'=>"fad.AccountingProcessingDate", 'frd'=>"frd.RecordingProcessingDate", 'frtp'=>"frtp.RTPProcessingDate"];
		
		if(!empty($requestFormdata['StartDate']) || !empty($requestFormdata['EndDate'])){
			$frd = (!empty($requestFormdata['file_search_type']) ? $requestFormdata['file_search_type']: 'frd');
			$whereCondition = @array_merge($whereCondition,[$this->FilesMainData->dateBetweenWhere($requestFormdata['StartDate'],$requestFormdata['EndDate'], $dateFldTable[$frd])]);
		}
		
		if($this->pageType == 'indexNew'){
			$query = $this->FilesMainData->filesRecordingQueryNew($whereCondition, $pdata['condition'], $this->pageType);
		} else {
			$query = $this->FilesMainData->filesRecordingQuery($whereCondition, $pdata['condition'], $this->pageType);
		}
		

		if(!empty($requestFormdata['file_search_type']) && (!empty($requestFormdata['StartDate']) || !empty($requestFormdata['EndDate']))){
			$tableFldCount = $this->FilesMainData->tblFldCountExport([$dateFldTable[$requestFormdata['file_search_type']]]); 
			$query = $this->FilesMainData->getOtherTableJoin($query, $tableFldCount,null,null,null,$skipJoin);
		}
		
		return $query;
	}


    private function getCustomParsingData(array $data)
	{ 
		$count = 1;
        foreach ($data as $key => $value) {
	
			 if(($this->pageType == 'ischeck') || ($this->user_Gateway)){ 
				$checkboxdisabled = (($value["lock_status"] == 1) ? 'disabled' : '');
				$value['Checkbox'] = '<input type="checkbox" id="checkAll[]" '.$checkboxdisabled.' name="checkAll[]" value="'.$key.'_'.$value["recId"].'" class="checkSingle"/>
				<input type="hidden" id="fmdId_'.$key.'" name="fmdId[]" value="'.$value["SrNo"].'"/>
				<input type="hidden" id="docTypeId_'.$key.'" name="docTypeId[]" value="'.$value["TransactionType"].'"/>
				<input type="hidden" id="LRSNum_'.$key.'" value="'.$value["FileNo"].'_'.$value["TransactionType"].'" />';
			}else{$value['Checkbox'] = $count; } 
			 
			if($this->user_Gateway){
				$value['Actions'] = $this->CustomPagination->getUserActionButtons($this->name,$value,['recId','SrNo','TransactionType'], 'common');
			}else{
				$value['Actions'] = $this->CustomPagination->getActionButtons($this->name,$value,['SrNo','File','recId','TransactionType','file_main_path'],$prefix = $this->pageType, $hideViewButton = 4);
			}
			
			if($value['ECapable'] == "Y") {
				$value['ECapable'] = 'Both SF & CSC';
			} else if($value['ECapable'] == "S") {
				$value['ECapable'] = 'SF';
			} else if($value['ECapable'] == "C") {
				$value['ECapable'] = 'CSC';
			} else {
				$value['ECapable'] = '';
			} 
            $value['TransactionType'] = '<input type="hidden"  class="doctypeHiddenCls" value="'.$value["TransactionType"].'"> '.$value["TransactionType"].' ( '.$value["DocumentTitle"].' )';  
            $value['PartnerFileNumber'] = $value['PartnerFileNumber'] . ((!empty($value['ClientCompName'])) ? ' ( '.$value['ClientCompName'].' )': '' );
			
			if($value['WebsiteURL'] !=""){
				$link_replace = $this->getLink($value['WebsiteURL']);
				
				if(strlen($link_replace)>20)
					$value['WebsiteURL'] = '<a href="'.$value['WebsiteURL'].'" target="_blank" title="'.$value['County'].'">'.substr($link_replace,0,20).' </a>';
				else
					$value['WebsiteURL'] = '<a href="'.$value['WebsiteURL'].'" target="_blank" title="'.$value['County'].'">'.$link_replace.'</a>';
			}
			
			$count++;
        }

        unset($data['recId']);
        return $data;
    }


    private function setProcessCondition($processingStatus)
	{
		$processingCondition = [];
		switch($this->pageType){
			
			case 'index':
                $processingCondition =	['OR'=>
                                    ['frd.RecordingProcessingDate IS' => NULL, 
                                        'AND'=>['frd.RecordingProcessingDate IS NOT' => NULL, 'frd.KNI'=>'1']
                                    ]
                                ];
                if($processingStatus == 'P'){
					if($this->generateCSV == true)
                    	$processingCondition = ['frd.RecordingProcessingDate IS NOT' => NULL];
					else 
						$processingCondition = ['frd.RecordingProcessingDate IS NOT' => NULL, 'frd.KNI'=>'2'];
                }
			break; 
			case 'indexNew':
                $processingCondition =	['OR'=>
                                    ['frd.RecordingProcessingDate IS' => NULL, 
                                        'AND'=>['frd.RecordingProcessingDate IS NOT' => NULL, 'frd.KNI'=>'1']
                                    ]
                                ];
                if($processingStatus == 'P'){
					if($this->generateCSV == true)
                    	$processingCondition = ['frd.RecordingProcessingDate IS NOT' => NULL];
					else 
						$processingCondition = ['frd.RecordingProcessingDate IS NOT' => NULL, 'frd.KNI'=>'2'];
                }
			break; 
			case 'research':
				$processingCondition = ['OR'=>
											['frd.RecordingProcessingDate IS' => NULL, 
												'AND'=>['frd.RecordingProcessingDate IS NOT' => NULL, 'frd.KNI'=>'1']
											], 
										'AND'=>[
												'OR'=>['frd.RecordingDate IS'=>NULL, 'frd.RecordingDate'=>'0000-00-00']
											]
										];
				if($processingStatus == 'P'){
					$processingCondition =  ['frd.RecordingProcessingDate IS NOT' => NULL, 'frd.KNI'=>'2', /* 'fcd.search_status !=' => 'S', */ 'OR'=>['frd.RecordingDate IS'=>NULL, 'frd.RecordingDate'=>'0000-00-00']];
				}
			break;
			case 'keynoImage':
					$processingCondition = ['frd.RecordingProcessingDate IS' => NULL, 'frd.KNI IS' => NULL];
					if($processingStatus == 'P'){
						$processingCondition =  ['frd.RecordingProcessingDate IS NOT' => NULL, 'frd.KNI' => '1'];
					}
			break;
			
			case 'recordManage':
					$processingCondition =	['frd.RecordingProcessingDate IS' => NULL];
					if($processingStatus == 'P'){
						$processingCondition = ['frd.RecordingProcessingDate IS NOT' => NULL];
					}
			break;
		}		
		return $processingCondition;
	}

    private function getLink($Website){
		$link_replace ='';
		if(strpos($Website, '://')){
			$link = explode("://",$Website);
			$link_replace = str_replace("www.","",$link[1]);
		}else{
			$link_replace = $Website;
		}
		return $link_replace;
	}

	/**
     * Edit method
     *
     * @param string|null $id Files Recording Data id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$recordMainId = $this->request->getParam('fmd');
		$doctype = $this->request->getParam('doctype');
		$pageType = $this->request->getParam('pageType');
		$section = $this->request->getParam('section');
		 
		$pageType = (isset($pageType)) ? $pageType : $this->pageType;
		$this->setPageType($pageType);
		$this->set('pageType', $pageType);
		
		$actionlink =  $this->pageAction($pageType);
		$this->set('actionlink', $actionlink);
		 
		if(empty($recordMainId) || empty($doctype)){
			return $this->redirect(['action' => 'index']);exit;
		}
		$FilesRecordingData = $this->FilesRecordingData->newEmptyEntity();
		if ($this->request->is(['patch', 'post', 'put']))
		{
		
			$data= []; $return = false;
			
			$postData = $this->request->getData(); 
			//echo "<pre>"; print_r($postData);exit;
			$filesMainId = $postData['fmdId'];
			$documentTypeId = $postData['docTypeId'];
			$recordId =  $postData['recordId'];
			 
			$coversheetsSave = $this->request->getData('coversheetsSave');
			if(isset($coversheetsSave)){ 
				$pdfname = $this->GeneratePDF->generateCoversheetPDF([$filesMainId.'_'.$documentTypeId]); 
			}
			$saveBtn = $this->request->getData('saveBtn');
			if(isset($saveBtn)){

				$return = $this->saveUpdateRecordingData($filesMainId, $documentTypeId, $postData, $recordId);

				if($return){
					$this->Flash->success(__('Recording file data has been saved.'));
					return $this->redirect(['action' =>$actionlink]); 
					
				}else{
					$this->Flash->error(__('Recording file could not be saved. Please, try again.'));
				}
			}
			
		}
		$filesMainData = $this->FilesMainData->searchMainDataForAll($recordMainId);

		if(empty($filesMainData)){
			$this->Flash->error(__('Please select correct record.'));
			return $this->redirect(['action' => 'index']);exit;
		}  

		$FilesRecordingData = $this->FilesRecordingData->getRecordingDataEdit($recordMainId, $doctype);

		$FilesCheckinData = $this->FilesCheckinData->getCheckInData($recordMainId, $doctype);
		$this->set('search_status', $FilesCheckinData['search_status']);
		$documentData = $this->DocumentTypeMst->get($doctype);
		$documentDataList = [$documentData['Id']=>$documentData['Title']];
  
		$partnerMapFields = $this->CompanyFieldsMap->partnerMapFields($filesMainData['company_id']);

		$this->set('section', $section);
		
        $this->set(compact('FilesRecordingData', 'filesMainData', 'documentData', 'documentDataList','partnerMapFields'));

        $this->set('_serialize', ['FilesRecordingData']);
		
		$pageTitle = 'Recording Entry For <u>'.$filesMainData['PartnerFileNumber']."</u>";		
		$this->set(compact('pageTitle'));
    }

	private function pageAction($pageType){
		$actionlink = 'index';
		switch($pageType){
			case 'keynoImage' : $actionlink = 'recordingkeyNoImage'; break;
			case 'research': $actionlink = 'recordingResearch'; break;
			default : $actionlink = 'index'; break;
		}
		return $actionlink;
	}
	
	private function saveUpdateRecordingData($filesMainId, $documentTypeId, array $data, $checkValue=''){
		$return = FALSE;
		$publicType = 'I';
		 
		$data['UserId'] = $this->currentUser->user_id;
		$data['RecId'] = $data['fmdId']; unset($data['fmdId']);
		$data['TransactionType'] = $data['docTypeId']; unset($data['docTypeId']);
		$pageType = $data['pageType']; unset($data['pageType']);

		if(isset($data['public'])){
			$postRegarding = $data['public']['Regarding']; 
			unset($data['public']);
		}

		if(isset($data['fcd'])){
			$fcdData = $data['fcd'];
			$fcdData['search_status_updated_date'] = date('Y-m-d');
			unset($data['fcd']);
		}

		unset($data['saveBtn'], $data['DocumentImageFile']);
	  
		if(($pageType != 'keynoImage' || $pageType != 'keyno-image') && isset($data['DocumentImage']) && ($data['DocumentImage']['error'] !=4)){
			$imageStatus = $this->uploadDocumentImage($data['DocumentImage']);
			if(is_array($imageStatus) && isset($imageStatus['errormsg'])){
				$this->Flash->error(__($imageStatus['errormsg']));
				return false;
			}else{
				$data['DocumentImage'] = $imageStatus;
			}
		}
 
		$frdData = $data;
		$frdData['RecordingDate'] = (!empty($frdData['RecordingDate'])) ? date('Y-m-d', strtotime($frdData['RecordingDate'])) : date('Y-m-d');
		
		$frdData['RecordingProcessingDate'] = (!empty($frdData['RecordingProcessingDate'])) ? date('Y-m-d', strtotime($frdData['RecordingProcessingDate'])) : date('Y-m-d');
		$frdData['RecordingProcessingTime'] = date("H:i:s");
 
		if(empty($checkValue)){
			$return = $this->FilesRecordingData->saveFRDData($frdData);
			$Regarding = (isset($postRegarding)) ? $postRegarding: 'Record Added KNI';
		}else{
			$return = $this->FilesRecordingData->updateFRDData($checkValue, $frdData);
     		$Regarding = (isset($postRegarding)) ? $postRegarding: 'Record Uploaded KNI';
		}

		if($return){
			if($pageType == 'keyno-image')
				$Regarding .= " <b>(Recording Date: ".$frdData['RecordingDate'].", Recording Time: ".$frdData['RecordingTime'].",Instrument Number: ".$frdData['InstrumentNumber'].", Book: ".$frdData['Book'].", Page: ".$frdData['Page'].", Recording Processing Date: ".$frdData['RecordingProcessingDate'].", Research Status: ".$fcdData['search_status'].")</b>";
			else 
				$Regarding .= " <b>(File: ".$frdData['File'].", Recording Date: ".$frdData['RecordingDate'].", Recording Time: ".$frdData['RecordingTime'].",Instrument Number: ".$frdData['InstrumentNumber'].", Book: ".$frdData['Book'].", Page: ".$frdData['Page'].", Recording Processing Date: ".$frdData['RecordingProcessingDate'].", Research Status: ".$fcdData['search_status'].")</b>";

			$this->FilesCheckinData->updateFCDByFmdDoc($filesMainId, $documentTypeId, $fcdData);
			$this->PublicNotes->insertNewPublicNotes($filesMainId, $documentTypeId, $this->currentUser->user_id, $Regarding, 'Frd', true, 'RD');

		}

		return $return;
	}


	public function recordingkeyNoImage()
    {
		$this->index('keynoImage');
	}

	public function recordingResearch()
    {
		$this->index('research');
	}
	
	public function recordingManagementReport()
    {
		$this->index('recordManage');
	}
	
	public function recordingConfirmationCoversheets()
    {
		$pageTitle = 'Generate Recording Confirmation Coversheets';
		$this->set('pageTitle',$pageTitle);

		$FilesRecordingData = $this->FilesRecordingData;
		
		if ($this->request->is(['patch', 'post', 'put'])) 
		{
			$coverSheetBtn = $this->request->getData('coverSheetBtn');
			if(isset($coverSheetBtn)){
				$postData = $this->request->getData();
				
				$companyId = $postData['company_id'];
				$fromDate = $postData['RecordingStartDate'];
				$toDate = $postData['RecordingEndDate'];
  
				$chkStartDate = $this->validateDate($fromDate); 
				$chkEndDate = $this->validateDate($toDate); 
				
				if($chkStartDate == 1 && $chkEndDate == 1) {
					if(!empty($companyId)){
						$fmdDocIDs = ['companyId'=> $companyId, 'fromDate'=>$fromDate, 'toDate'=>$toDate];
						// get count of all found records
						$dataCount = $this->GeneratePDF->fetchFmdRecording($fmdDocIDs, true);
				
						// generate pdf download links 
						$pdfDownloadLinks = $this->pdfDownloadLinks($dataCount, $fmdDocIDs);
						$this->set('pdfDownloadLinks', $pdfDownloadLinks);
						
						if(empty($pdfDownloadLinks)){
							$this->Flash->error(__('Records not found for confirmation coversheet.'));
						}else{
							$this->Flash->success(__('Confirmation coversheet download links are listed.'));
						}
					}else{
						$this->Flash->error(__('Please select partner.'));
					}					
				} else {
					$this->Flash->error(__('Please enter proper From Date / To Date.'));
				} 
			}
			$this->set(compact('fromDate','toDate'));
		}

		$companyMsts = $this->CompanyMst->companyListArray();
		
        $this->set(compact('FilesRecordingData', 'companyMsts'));
        $this->set('_serialize', ['FilesRecordingData']);
	}
	
	private function pdfDownloadLinks($dataCount, $fmdDocIDs){
	
		$downloadlinks = "";
		if($dataCount > 0){
			if(isset($fmdDocIDs['fromDate']) && isset($fmdDocIDs['toDate'])){
				$pagelink = Router::url(['controller'=>$this->name,'action'=>'coverSheetGenerate', '?'=>$fmdDocIDs]);
			}
			// for new page
			if(isset($fmdDocIDs['addedfromDate']) && isset($fmdDocIDs['addedtoDate'])){
				$pagelink = Router::url(['controller'=>$this->name,'action'=>'coverSheetGenerate', '?'=>$fmdDocIDs]);
			}
			
			// for manual confirmation coversheet
			if(isset($fmdDocIDs['field']) && isset($fmdDocIDs['filenumber'])){
				$pagelink = Router::url(['controller'=>$this->name,'action'=>'coverSheetGenerate', '?'=>$fmdDocIDs]);
			}
			
			$pagelinkD = '';
			$pages = $dataCount / ROWLIMIT;
			for($i = 0; $i < floor($pages); $i++){
				$pagelinkD = $pagelink.'&limit='.($i*ROWLIMIT).'-'.ROWLIMIT;
				$downloadlinks .= '<li class="col-sm-4 col-md-4 col-lg-3 list-group-item"> <a href="'.$pagelinkD.'" title="Download PDF sheet"> <i class="las la-file-download" aria-hidden="true"></i> Pages '.($i*ROWLIMIT+1).' to '.(($i+1)*ROWLIMIT).'</a></li>';
			}
			
			if(($dataCount % ROWLIMIT) > 0){
				$pagelinkD = $pagelink.'&limit='.($i*ROWLIMIT).'-'.($dataCount % ROWLIMIT);
				$downloadlinks .= '<li class="col-sm-4 col-md-4 col-lg-3 list-group-item"> <a href="'.$pagelinkD.'" title="Download PDF sheet">  <i class="las la-file-download" aria-hidden="true"></i> Pages '.($i*ROWLIMIT+1).' to '.(($i*ROWLIMIT)+($dataCount % ROWLIMIT)).'</a></li>';
			}		
		}		
		return $downloadlinks;		
	}
	
	public function coverSheetGenerate(){
		$this->autoRender = false;
		$getQuery = $this->request->getQuery();
		if(isset($getQuery)){

			$postData = $this->request->getQuery();
			// fetch all data with limit and condition
			$dataQuery = $this->GeneratePDF->fetchFmdRecording($postData);
			$limitPrifix = '';
			// component to create pdf files (data , pdf prifix-name)
			// direct download
			if(isset($postData['limit']) &&  strpos($postData['limit'], '-')){
				$limit = explode('-',$postData['limit']);
				$limitPrifix = "_".($limit[0]+1)."-".($limit[0]+$limit[1]);
			}
 
			// multiple pdf generate 
			$filename = $this->GeneratePDF->pdfGenerateFinal($dataQuery, $limitPrifix);
		
			if(is_null($filename)){
				$this->redirect($this->referer());	
				$this->Flash->error(__('Hard copy not received for search record(s), PDF file not generated.'));
			}
		}
	}
	
	public function recordingManagementData(array $postData=[], $is_csv=false){
		 
		$queryData = $this->request->getQuery();
		 
		if(isset($queryData) && !empty($queryData) && empty($postData)){
			$this->autoRender = false;
			$postData = $queryData;
			$getLimit = explode('-',$postData['limit']);
			unset($postData['limit']);
			$this->pageType = $postData['pageType'];
			// true == recording CSV page
			$is_csv = ($this->pageType == 'index') ? true : false; //Imp
			unset($postData['pageType']);

			$this->generateCSV = $postData['generateCSV'];
			unset($postData['generateCSV']);
		}
		 
		if(isset($postData['generateSheetBtn'])){ unset($postData['generateSheetBtn']); }
		
		// get unique comapnyid from post records
		$companyId = $this->setCompanyId($postData); 
		//===================== generete csv file data & name to export data ====================//	

		//$querymapfields for both condition map fields found or not
		$pdata = $this->postDataCondition(['formdata'=>$postData,'draw' => 1,'order'=>null], true);
 
		$processing = (empty($postData['processingstatus'])) ? 'P' : $postData['processingstatus']; //NP;
		 
		if(isset($postData['checkAll']) && !empty($postData['checkAll'])){
			$selectedIds = $postData['checkAll'];
			$query = $this->setFilterQuery($postData, $pdata, $processing, $selectedIds);
		}else{
			$query = $this->setFilterQuery($postData, $pdata, $processing);
		}
		
		$callback = '';
		if(($is_csv) && ($this->pageType == 'index')){
			$callback = 'dataNheaderOnly';
		}
		 
		$this->skipJoin = $this->checkSkipTable($postData,$this->skipJoin);

		/********************* NEW CHANGE *******************************/
		$limitPrifix = '';
		$callType = 'form';
		// call from link
		if(!empty($queryData) && is_array($getLimit)){
			// add limit prifix to csv file name
			$limitPrifix = "_".($getLimit[0]+1)."-".($getLimit[0] + $getLimit[1]);
		
			$callType = 'link';
			
			// add limit to query
			$query = $query->limit($getLimit[1])->offset($getLimit[0]);
		}
		
		$resultQuery = $this->FilesRecordingData->generateQuery($query);
		
		$countRows = 0; // link 
		if($callType == 'form'){
			$countRows = $this->FilesRecordingData->getQueryCountResult($resultQuery['query'], 'count');
		}
		// add csvNamePrifix to result array
		//echo "<br>resultQuery"; print_r($countRows); echo ROWLIMIT;exit;
		if($countRows <= ROWLIMIT){

			$resultQuery['companyId'] = $companyId;
			$resultQuery['limitPrifix'] = $limitPrifix;
			// generate CSV sheet to download
			$this->generateCsvSheet($resultQuery, $callType, $postData);

		}else{
			// generate CSV link to download call from component 
			$postData['pageType'] = $this->pageType;
			$postData['generateCSV'] = $this->generateCSV;
			 
			$pagelink = Router::url(['controller'=>$this->name,'action'=>'recordingManagementData', '?'=>$postData]);

			$pdfDownloadLinks = $this->CustomPagination->generateCsvLink($countRows,$pagelink);
			if(!empty($pdfDownloadLinks)){
				$this->set('pdfDownloadLinks',$pdfDownloadLinks);
				//$this->Flash->success(__('Recording sheet links listed.'));
			}else{
				$this->Flash->error(__('Records not found.'));
			}
		}
		
	}

	private function checkSkipTable($postData,$skipJoin){
		if(!empty($postData['file_search_type']) && $postData['file_search_type'] == 'fcd'){
			array_push($skipJoin, 'files_checkin_data'.ARCHIVE_PREFIX);
		}
		if(!empty($postData['file_search_type']) && $postData['file_search_type'] == 'fad'){
			array_push($skipJoin, 'files_accounting_data'.ARCHIVE_PREFIX);
		}
		if(!empty($postData['file_search_type']) && $postData['file_search_type'] == 'frtp'){
			array_push($skipJoin, 'files_returned2partner'.ARCHIVE_PREFIX);
		}
		return $skipJoin;
	}

	private function generateCsvSheet($resultQuery=[], $callType = 'form', $postData = []){
		$csvFileName ='';
		 
		$skipJoin = ['files_recording_data'.ARCHIVE_PREFIX, 'files_shiptoCounty_data'.ARCHIVE_PREFIX, 'files_checkin_data'.ARCHIVE_PREFIX];
		$skipJoin = $this->checkSkipTable($postData,$skipJoin);
		$partnerMapData = $this->_getpartnerMapData($resultQuery['companyId']);

		$csvNamePrifix = $partnerMapData['csvNamePrifix'].$resultQuery['limitPrifix'];

		$param  = ['partnerMapFields'=>$partnerMapData['partnerMapFields'], 'skipJoin'=>$skipJoin, 'onlyQuery'=>false];

		// behaviour call for adding extra fields for CSV sheet
		$resultQuery = $this->FilesRecordingData->generateQuery($resultQuery['query'], $param);
 
		$resultRecord = $this->FilesRecordingData->getQueryCountResult($resultQuery['query']);
		
		// call from csv generate sheet for update sheet generated status
		/* if(($this->pageType == 'index')){
			$this->updateCSVGenerate($resultRecord);
		} */
		
		if($this->generateCSV == true) {

			$this->updateCSVGenerate($resultRecord); // update sheet_generate = Y for all the records in frd

			$resultQuery['headerParams']['Image'] = 'Image';
			$resultQuery['headerParams']['EffectiveDate'] = 'EffectiveDate';
		}
		
		$listRecord = $this->FilesRecordingData->setListRecords($resultRecord, $resultQuery['headerParams']);
	
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
			//$this->Flash->success(__('Recording sheet listed.'));

		}else{
			$this->Flash->error(__('Records not found.'));
		}
	}

	private function _getpartnerMapData($companyId){
		 
		$partnerMapData = $this->FilesMainData->partnerExportFields($companyId,'cef_fieldid4RE','recsheet');

		$partnerMapFields = $partnerMapData['partnerMapFields'];
		$csvNamePrifix = $partnerMapData['csvNamePrifix'];
		if($this->user_Gateway && isset($partnerMapFields['NATFileNumber'])){
			unset($partnerMapFields['NATFileNumber']);
		}
		
		return ['partnerMapFields'=>$partnerMapFields, 'csvNamePrifix'=>$csvNamePrifix];
	}
	
	/**
     * View method
     *
     * @param string|null $id Files Recording Data id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$pageTitle = 'Recording';
		$this->set(compact('pageTitle'));
		
        $recordMainId = $this->request->getParam('fmd');
		$doctype = $this->request->getParam('doctype');
		
		// only use for email section use
		$layoutShow = $this->request->getQuery('layoutShow');
		$layoutShow = (isset($layoutShow)) ? false: true;
		$this->set('layoutShow', $layoutShow);
		
		//************* page and link setting *************//
		$pagetype = $this->request->getParam('pageType');
		$pageType = (isset($pagetype)) ? $this->request->getParam('pageType') : $this->pageType;
		$this->setPageType($pageType);
		$this->set('pageType', $pageType);
		
		$actionlink =  $this->pageAction($pageType);
		$this->set('actionlink', $actionlink);
		//*************END page and link setting *************//
		
		if(empty($recordMainId) || empty($doctype)){
			return $this->redirect(['action' => 'indexPartner']);exit;
		}
		 
		$FilesRecordingData = $this->FilesMainData->filesRecordingEditData($recordMainId,$doctype);
		
		if(empty($FilesRecordingData)){
			$this->Flash->error(__('Please select correct record.'));
			return $this->redirect(['action' => 'indexPartner']);exit;
		}
		
		if ($this->request->is(['patch', 'post', 'put'])) 
		{
			// generate cover sheet
			$coversheetsSave = $this->request->getData('coversheetsSave');
			if(isset($coversheetsSave)){
				// send array of fmdId_docId 
				$pdfname = $this->GeneratePDF->generateCoversheetPDF([$recordMainId.'_'.$doctype]); //
			}
			
			// send record status
			$recordSendEmail  = $this->request->getData('recordSendEmail');
			if(isset($recordSendEmail)){
				// send email to client
				$this->recordSendEmail([$recordMainId,$doctype]);
				$this->Flash->success(__('Recording status email sent.'));
			}
		}
		
		$documentData = $this->DocumentTypeMst->get($doctype);
		$documentDataList = [$documentData['Id']=>$documentData['Title']];
		
		$this->loadModel('CountyMst');
		$StateList = $this->CountyMst->StateListArray();
		$CountyList = $this->CountyMst->getCountyTitleByState($FilesRecordingData['State']); //

		$this->loadModel("CompanyFieldsMap");
		$partnerMapFields = $this->CompanyFieldsMap->partnerMapFields($FilesRecordingData['company_id']);

        $this->set(compact('FilesRecordingData', 'documentData', 'documentDataList','partnerMapFields', 'StateList', 'CountyList'));

        $this->set('_serialize', ['FilesRecordingData']);
    }
	
	public function newConfirmationCoversheets()
    {
		$pageTitle = 'Generate Recording Confirmation Coversheets';
		$this->set('pageTitle',$pageTitle);

		$FilesRecordingData = $this->FilesRecordingData;
		
		if ($this->request->is(['patch', 'post', 'put'])) 
		{
			$coverSheetBtn = $this->request->getData('coverSheetBtn');
			if(isset($coverSheetBtn)){
				$postData = $this->request->getData();
				
				$companyId = $postData['company_id'];
				$fromDate = $postData['RecordingStartDate'];
				$toDate = $postData['RecordingEndDate'];
				$eCapable = $postData['eCapable'];

				$chkStartDate = $this->validateDate($fromDate); 
				$chkEndDate = $this->validateDate($toDate); 
				
				if($chkStartDate == 1 && $chkEndDate == 1) {
					if(!empty($companyId)){
						$fmdDocIDs = ['companyId'=> $companyId, 'addedfromDate'=>$fromDate, 'addedtoDate'=>$toDate, 'eCapable'=>$eCapable];
						// get count of all found records
						$dataCount = $this->GeneratePDF->fetchFmdRecording($fmdDocIDs, true);
				
						// generate pdf download links 
						$pdfDownloadLinks = $this->pdfDownloadLinks($dataCount, $fmdDocIDs);
						$this->set('pdfDownloadLinks', $pdfDownloadLinks);
						
						if(empty($pdfDownloadLinks)){
							$this->Flash->error(__('Records not found for confirmation coversheet.'));
						}else{
							$this->Flash->success(__('Confirmation coversheet download links are listed.'));
						}
					}else{
						$this->Flash->error(__('Please select partner.'));
					}
				} else {
					$this->Flash->error(__('Please enter proper From Date / To Date.'));
				}					
			}
			$this->set(compact('fromDate','toDate','eCapable'));
		}

		$companyMsts = $this->CompanyMst->companyListArray();
		
        $this->set(compact('FilesRecordingData', 'companyMsts'));
        $this->set('_serialize', ['FilesRecordingData']);
	}
	
	public function manualConfirmationCoversheets()
    {
		$pageTitle = 'Manual Coversheet Extraction';
		$this->set('pageTitle',$pageTitle);

		$FilesRecordingData = $this->FilesRecordingData;
		
		$fieldhash = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24);
		
		if ($this->request->is(['patch', 'post', 'put'])) 
		{
			$subExport = $this->request->getData('subExport');
			if(isset($subExport)){
				$postData = $this->request->getData();
				
				$company_id = $postData['company_id'];
				$field = $postData['field'];
				$filenumber = $postData['filenumber'];
				
				//For more than 500 records
				$flno4pdf = array();
				foreach($filenumber as $flno){
					if(trim($flno) != "" && trim($flno) != "Submit"){
						$flno4pdf[] =  $flno;
					}
				}
				
				$flno4pdf = implode(",",$flno4pdf);
				
				if(!empty($company_id)){
					$fmdDocIDs = ['companyId'=> $company_id, 'field'=>$field, 'filenumber'=>$flno4pdf];
					// get count of all found records
					$dataCount = $this->GeneratePDF->fetchFmdRecording($fmdDocIDs, true);
			
					// generate pdf download links 
					$pdfDownloadLinks = $this->pdfDownloadLinks($dataCount, $fmdDocIDs);
					$this->set('pdfDownloadLinks', $pdfDownloadLinks);
					
					if(empty($pdfDownloadLinks)){
						$this->Flash->error(__('Records not found for confirmation coversheet.'));
					}else{
						$this->Flash->success(__('Confirmation coversheet download links are listed.'));
					}
				}else{
					$this->Flash->error(__('Please select partner.'));
				}
			}
			$this->set(compact('company_id','field','filenumber'));
		}

		$companyMsts = $this->CompanyMst->companyListArray();
		
        $this->set(compact('FilesRecordingData', 'companyMsts','fieldhash'));
        $this->set('_serialize', ['FilesRecordingData']);
	}


	// scanning Recognition 
	public function scanningRecognition(){
		$qrerror = [];
		$pageTitle = 'Scanning Recognition';
		$this->set('pageTitle',$pageTitle);  
		$qrcode = '';
		if ($this->request->is(['patch', 'post', 'put'])) 
		{
			// value of qrcode must be LRSnbumber_documenttype  // 525110_113
			$qrcode = $this->request->getData('qrcode');
			$qrCodeSubmit = $this->request->getData('qrCodeSubmit');
			if (!empty($qrcode) || !empty($qrCodeSubmit)){
				
				if(!empty($qrcode) && strpos($qrcode, '_')){
					
					$qrcodearr = explode('_',$qrcode);
					$LRSNo = trim($qrcodearr[0]);
					$docType = trim($qrcodearr[1]);
					
					// return direct fmd id if found else 0
					$fmdID = $this->FilesMainData->findQRcodeLRSnumber($LRSNo);
					
					if($fmdID != 0){
					
						// find recording data 
						$recordingData = $this->FilesRecordingData->getRecordingData($fmdID, $docType);
					
						if(!empty($recordingData)){
							$recordingCheckCondition  = ($recordingData['RecordingProcessingDate'] != '' && $recordingData['File'] != '' && $recordingData['RecordingDate'] != '');
							
							if($recordingCheckCondition){

								$qrerror['text'] = "NO SCAN NEEDED.";
								$qrerror['class'] = "sr-box-danger";
		
								// Update hard_copy_received status in FRD table
								$this->FilesRecordingData->updateRecordingData($recordingData['Id'], 'hard_copy_received');
								
								// add public notes 
								$this->PublicNotes->insertNewPublicNotes($fmdID, $docType, $this->currentUser->id, 'Record Updated for Scanning Recognition', 'Coversheet', false, 'Scanning Recognition');
												
							}else{
								$qrerror['text'] = "SCAN NEEDED.";
								$qrerror['class'] = "sr-box-ok";
							}
						}else{
							$qrerror['text'] = "NO SCAN NEEDED.";
							$qrerror['class'] = "sr-box-danger";
							//$this->Flash->error(__('Record not found!!'));
						}	
					}else{
						$qrerror['text'] = "Record not found!!";
						$qrerror['class'] = "sr-box-danger";
						//$this->Flash->error(__('QRcode not match any records!!'));
					}	
				}else{
					$qrerror['text'] = "Record not found!!";
					$qrerror['class'] = "sr-box-danger";
					//$this->Flash->error(__('QRcode not match any records!!'));
					//$this->Flash->error(__('Please enter QRcode in the correcr format!!'));
				}

			}
		}
		
		$this->set('qrerror',$qrerror);
		$recordingData =  null;
		$this->set('qrcode', $qrcode);
        $this->set(compact('recordingData'));
        $this->set('_serialize', ['recordingData']);
		
	}
	
	public function initiateCoversheet(){
		$pageTitle = 'Initiate Coversheet';
		$this->set('pageTitle',$pageTitle);  
		$session = $this->request->getSession();
		$qrerror = [];
		$qrcode = $qrcodeEnter = $PartnerFileNumber = $TransactionType = '';
		// form post
		// value of qrcode must be LRSnbumber_documenttype  // 525110_113
		$sheetlist_arr=[];
		if ($this->request->is(['patch', 'post', 'put'])) 
		{
			$postData = $this->request->getData();
		  	//pr($postData); exit;
			$fmdID = 0;

			if (!empty($postData)){
			 
				if(isset($postData['qrcode']) || isset($postData['qrCodeSubmit'])){
					$qrcode = $postData['qrcode']; 
					$qrcodeEnter = $postData['qrcodeEnter'];
					 
					if(empty($qrcode) && (!empty($qrcodeEnter))){
						$qrcode = $qrcodeEnter;
					} 
					if(!empty($qrcode) && strpos($qrcode, '_')){
						$qrcodearr = explode('_',$qrcode);
						$LRSNo = trim($qrcodearr[0]);
						$docType = trim($qrcodearr[1]); 
						// return direct fmd id if found else 0
						$fmdID = $this->FilesMainData->findQRcodeLRSnumber($LRSNo);
						if($fmdID == 0){
							$qrerror['text'] = "Record not found!!";
							$qrerror['class'] = "sr-box-danger";
							//$this->Flash->error(__('QRcode not match any records!!'));
						}	
					}/* else{
						$this->Flash->error(__('Please enter QRcode in the correct format!!'));
					} */
				} 


				if(isset($postData['clientFileSubmit'])){ 
				 
					$PartnerFileNumber = $postData['PartnerFileNumber'];
					$docType  = $postData['TransactionType'];

					if(!empty($PartnerFileNumber)){ 
						// return direct fmd id if found else 0
						
						// if record found multiple recID against PartnerFileNumber 
						// then we need to show multiple rows which are processed in recording  -- TBD
						$fmdData = $this->FilesMainData->findFMDPartnerFileNumber($PartnerFileNumber, $docType);
				 
						if($fmdData == 0){
							$qrerror['text'] = "Record not found!!";
							$qrerror['class'] = "sr-box-danger";
							//$this->Flash->error(__('Client File Number not match any records!!'));
						}else{
							$fmdID   = $fmdData['Id'];
							$docType = $fmdData['TransactionType'];
						}	
					}else{
						$this->Flash->error(__('Please enter Client File Number!!'));
					}
				}
    
				
				if( ($fmdID != 0) && !isset($postData['btnCoversheet']) ){
					
					// if btnCoversheet then DB process not to be run 
					// find recording data
					$recordingData = $this->FilesRecordingData->getRecordingData($fmdID, $docType);
					 
					if(!empty($recordingData)){
						$recordingCheckCondition  = ($recordingData['RecordingProcessingDate'] != '' && $recordingData['File'] != '' && $recordingData['RecordingDate'] != '');
						if(!empty($recordingCheckCondition)){
							$qrerror['text'] = "Coversheet Ok";
							$qrerror['class'] = "sr-box-ok";

							// Update hard_copy_received status in FRD table
							$this->FilesRecordingData->updateRecordingData($recordingData['Id'], 'hard_copy_received');

							// add public notes 
							$this->PublicNotes->insertNewPublicNotes($fmdID, $docType, $this->currentUser->id, 'Record Updated for Initiate Coversheet', 'Coversheet', false, 'Initiate Coversheet');
							
							if($session->check('sheetlist_arr')) {
								$sheetlist_arr_SESS = $session->read('sheetlist_arr');
								array_push($sheetlist_arr_SESS, $recordingData['RecId']."_".$recordingData['TransactionType']);
								$session->write(['sheetlist_arr' => $sheetlist_arr_SESS]);
							}else{
								$sheetlist_arr[] = $recordingData['RecId']."_".$recordingData['TransactionType'];
								$session->write(['sheetlist_arr' => $sheetlist_arr]);
							}
							
						}else{
							$qrerror['text'] = "Coversheet Error";
							$qrerror['class'] = "sr-box-danger";
						} 
					}else{
						$qrerror['text'] = "Record not found!!";
						$qrerror['class'] = "sr-box-danger";
						//$this->Flash->error(__('Record not found!!'));
					} 
				} 

				// coversheet Data Table and Print PDF
				$sessionSheetlist = [];
				if($session->check('sheetlist_arr')) {

					// create coversheet PDF file if print button submit. 
					if (isset($postData['btnCoversheet'])){
						
						$coverSheetIds = $postData['coverSheetIds'];

						// send array of fmdId_docId 
						$pdfname = $this->GeneratePDF->generateCoversheetPDF($coverSheetIds);  
					 	// $session->delete('sheetlist_arr');
					}
					
					// create data table
					if($session->check('sheetlist_arr')) {
						$sessionSheetlist = $session->read('sheetlist_arr');
						$sessionSheetlist = array_values(array_unique($sessionSheetlist));	

						// fetch record data of matching fmdid
						$coverSheetData = $this->coverSheetData($sessionSheetlist);
						$this->set('coverSheetData',$coverSheetData['rowsText']);
					}

					//$session->destroy('sheetlist_arr');
				} 
		
			}
		}

		$this->set('qrerror',$qrerror);
		/* $this->set('qrcode', $qrcode);
		$this->set('qrcodeEnter', $qrcodeEnter); */
	
		$this->set('PartnerFileNumber', $PartnerFileNumber);
		$this->set('TransactionType', $TransactionType);

        $DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
		$recordingData = null;
        $this->set(compact('recordingData', 'DocumentTypeData'));
        $this->set('_serialize', ['recordingData']);
		
	}
	
	
	private function coverSheetData(array $sheetlist_arr){
		$rowsText = ''; $postPDFData= [];
		if(is_array($sheetlist_arr) && !empty($sheetlist_arr)){	

			foreach($sheetlist_arr as $kay){
				
				if(!empty($kay) && strpos($kay, '_')){
					$expl = explode("_",$kay);
					$LRSNo = trim($expl[0]);
					$docType = trim($expl[1]);
					
					$recordingData = [];
				 
					$recordingData = $this->FilesMainData->recordingDataQuery($LRSNo, $docType);
					
					foreach($recordingData as $records){	
						if($records['frd']['RecId'] !=''){
							// set data for PDF generate.
							 
							$rowsText .='<tr>								
											<td><input type="hidden" name="coverSheetIds[]" value="'.$records['frd']['RecId'].'_'.$records['frd']['TransactionType'].'">'.substr($records['NATFileNumber'],0,65).'</td>
											<td><span >'.$records['PartnerFileNumber'].'</span></td>
											<td><span >'.$records['dtm']['Title'].'</span></td>
											<td><span >'.$records['frd']['RecordingProcessingDate'].'</td>
											<td>'.$records['frd']['InstrumentNumber'].'</td>
											<td>'.$records['frd']['Book'].'</span></td>
											<td>'.$records['frd']['Page'].'</td>	
											<td><span style="color:green;">'.$records['ECapable'].'</span></td>
										</tr>';
						}
					}
				}
			}
		}
		
		return ['rowsText'=>$rowsText]; //, 'postPDFData'=>$postPDFData

	}

	public function recordingCsv()
    {
		$pageTitle = 'Generate Recording Sheet';
		$this->set(compact('pageTitle'));
		$this->generateCSV = true;
		$recStartDate = $recEndDate = '';
		$FilesRecordingData = $this->FilesRecordingData->newEmptyEntity();
		
		if ($this->request->is(['patch', 'post', 'put'])) 
		{
			$generateSheetBtn = $this->request->getData('generateSheetBtn');			
			if(isset($generateSheetBtn)){

				$postData = $this->request->getData();
				$companyId = $postData['company_id'];

				$recStartDate = $postData['StartDate'];  
				$recEndDate = $postData['EndDate'];  
				$chkStartDate = $this->validateDate($recStartDate); 
				$chkEndDate = $this->validateDate($recEndDate); 
				
				if($chkStartDate == 1 && $chkEndDate == 1) {
					if(!empty($companyId)){
						$this->recordingManagementData($this->request->getData(), true);
					}else{
						$this->Flash->error(__('Please select partner.'));
					}
				} else {
					$this->Flash->error(__('Please enter proper From Date / To Date.'));
				}					
			}
		}
		
		$this->set('recStartDate',$recStartDate);
		$this->set('recEndDate',$recEndDate);
		
		$companyMsts = $this->CompanyMst->companyListArray();
		
        $this->set(compact('FilesRecordingData', 'companyMsts'));
        $this->set('_serialize', ['FilesRecordingData']);

	}
	
	private function updateCSVGenerate($listRecord){
 
		$recordindIds = [];
		foreach($listRecord as $records)
		{
			if(isset($records['recId']) && !empty($records['recId']))
				 
				array_push($recordindIds, $records['recId']);
		}
		 
		// update records for  sheet_generate status 'Y'
		$this->FilesRecordingData->updateAllSheetGenerate($recordindIds);
		return true; 
	}


	// New functions for the slow query changes - 28062023

	public function indexNew($pageType='')
    {
		$pageType = 'indexNew';
		
		$pageTitle = 'Key With Image';
		$this->set(compact('pageTitle'));
		 
        $this->setPageType($pageType);
		
		$this->setExtraFields();
		 
		$requestData = $this->request->getData();
		$RecId = $this->setCompanyId($requestData); 

		// Check user is admin or not
		if($this->user_Gateway){
			$noOrder = ['Actions'];
			unset($this->columns_alise['Checkbox']);
		}else{ 
			$noOrder = ['Checkbox', 'Actions'];
		}
		$this->set('dataJson', $this->CustomPagination->setDataJson($this->columns_alise,$noOrder));
 
		$isSearch = 0; 
        $formpostdata = '';
        if ($this->request->is(['patch', 'post', 'put'])) {
            $formpostdata = $this->request->getData();
			$isSearch = 1; 
        }
		
        $this->set('formpostdata', $formpostdata);
		$this->set('isSearch', $isSearch); 
         
		$partnerMapField =  $this->CompanyFieldsMap->partnerMapFields($RecId,1);

        $DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
        $companyMsts = $this->CompanyMst->companyListArray()->toArray();
 
		$partnerCompanyList = $this->CompanyMst->partnerCompanyList();

		$FilesRecordingData = $this->FilesRecordingData->newEmptyEntity();
        $this->set(compact('FilesRecordingData', 'companyMsts', 'DocumentTypeData','partnerMapField', 'partnerCompanyList'));

		$this->set('datatblHerader', $this->columns_alise);
        $this->set('_serialize', ['FilesRecordingData']);		
 
		$this->set('pageType', $this->pageType);
		
        $fileSearchType = ['fmd'=>'File / Record Added', 'fcd'=>'Document CheckIn (Received)', 'fad'=>'Accounting', 'fsad'=>'Submission To County', 'fqcd'=>'Open Rejection Date', 'frd'=>'Recorded', 'frtp'=>'Return to Partner Submission'];

		$this->set('fileSearchType', $fileSearchType);

        $currentURL = $this->getRequest()->getRequestTarget(); 
		$this->set('currentURL', $currentURL);

		if(!empty($formpostdata['cm_file_enabled'])){
			$this->recordingManagementData($this->request->getData());
		}
 
		$reseach_status1 = isset($formpostdata['reseach_status1']) ? : "S";
		$this->set('reseach_status1',$reseach_status1);	
    }

	public function ajaxListIndexNew(){ 
		$this->autoRender = false;

		$is_index = $this->request->getData('is_index');
	    $this->setPageType($is_index);
		 
        $this->columns_alise["File"] = "frd.File";
		$this->columns_alise["file_main_path"] = "frd.file_main_path";

	    $this->setExtraFields();
		
	    $processingStatus = 'NP';
        $formdata = $this->request->getData('formdata');
		 
		if(isset($formdata['processingstatus'])){
			$processingStatus = $formdata['processingstatus'];
		}
	
		if(isset($formdata['processingstatus']))
			unset($formdata['processingstatus']);
		 
		$pdata = $this->postDataCondition($this->request->getData(), false);

		// Remove query limit for all records
		if($pdata['condition']['limit'] == -1){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']);
		} // END

		$query = $this->setFilterQuery($formdata, $pdata, $processingStatus);
		//debug($query->sql()); exit;
		$recordsTotal = $this->FilesRecordingData->getQueryCountResult($query, 'count');
 
        $data = $this->FilesRecordingData->getQueryCountResult($query);
        $data = $this->getCustomParsingData($data);

	    $response = array(
						"draw" => intval($pdata['draw']),
						"recordsTotal" => intval($recordsTotal),
						"recordsFiltered" => intval($recordsTotal),
						"data" => $data
					);

		echo json_encode($response); 
        exit;
    }




}