<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * FilesQcData Controller
 *
 * @property \App\Model\Table\FilesQcDataTable $FilesQcData
 * @method \App\Model\Entity\FilesQcData[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilesQcDataController extends AppController
{
    private $columns_alise = [  "Checkbox" => "",
                                "FileNo" => "fmd.NATFileNumber",
                                "PartnerFileNumber" => "fmd.PartnerFileNumber",
                                "TransactionType" => "fqcd.TransactionType",
                                "Grantors" => "fmd.Grantors",
                                "StreetName" => "fmd.StreetName",
                                "County" => "fmd.County",
                                "State" => "fmd.State",
                                "Status" => "fqcd.Status",
                                "ECapable" => "fmd.ECapable"
                            ];

	private $columnsorder = [0=>'fmd.Id',1=>'fmd.NATFileNumber',2=>'fmd.PartnerFileNumber',3=>'fqcd.TransactionType',4=>'fmd.Grantors',5=>'fmd.StreetName',6=>'fmd.County',7=>'fmd.State',8=>'fqcd.Status',9=>'fmd.ECapable']; 
	
	public $isWhere = 'P';

    public function initialize(): void
	{
		parent::initialize();
		$this->loadModel("CompanyFieldsMap");
		$this->loadModel("DocumentTypeMst");
		$this->loadModel("CompanyMst");
		$this->loadModel("FilesMainData"); 
		$this->loadModel("FilesCheckinData"); 
		   
		$this->loadModel('PublicNotes');
        $this->loadModel('RejectionStatusHistory'); 

	}
	public function beforeFilter(\Cake\Event\EventInterface $event)
    {
		parent::beforeFilter($event);
		$this->loginAccess();
	}

	public function indexPartner(){
		$this->index();
		$pageTitle = 'Rejection Status';
		$this->set(compact('pageTitle'));
	}
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $pageTitle = 'Rejections Management';
		$this->set(compact('pageTitle'));

        $this->setExtraFields("reject");

	    $company_id ="";
        $cId = $this->request->getData('company_id');
        if(isset($cId) && !empty($cId)){
			$company_id = $this->request->getData('company_id');
		}
		 
        $OKbtn = $this->request->getData('OKbtn');
		if(isset($OKbtn)){ 
			$this->processRejecedRecord($this->request->getData(), "OK");
		}

        $RTPbtn = $this->request->getData('RTPbtn');
		if(isset($RTPbtn)){ 
			$this->processRejecedRecord($this->request->getData(), "RTP");
		}

        $RIHbtn = $this->request->getData('RIHbtn');
		if(isset($RIHbtn)){ 
			$this->processRejecedRecord($this->request->getData(), "RIH");
		} 
		
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

        $FilesQcData = $this->FilesQcData->newEmptyEntity();
 
		$partnerMapField =  $this->CompanyFieldsMap->partnerMapFields($company_id,1);
		
        $DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();

        $companyMsts = $this->CompanyMst->companyListArray()->toArray();
		$partnerCompanyList = $this->CompanyMst->partnerCompanyList();
        $this->set(compact('FilesQcData','companyMsts','DocumentTypeData','partnerMapField','partnerCompanyList'));
		$this->set('datatblHerader', $this->columns_alise);
        $this->set('_serialize', ['FilesQcData']);

    }
 
    private function setExtraFields($type="index"){
   
        unset($this->columns_alise["Status"], $this->columns_alise["Grantors"], $this->columns_alise["StreetName"]);
        
        $this->columns_alise["Status"] = "fqcd.Status";
        $this->columns_alise["RejectionReason"] = "fqcd.RejectionReason"; 
        $this->columns_alise["TrackingNo"] = "fqcd.TrackingNo4RR"; 
        
        $this->columns_alise["Actions"] = "";
        
        unset($this->columnsorder[5], $this->columnsorder[8]);
        $this->columnsorder[] = "fqcd.Status";
        $this->columnsorder[] = "fqcd.RejectionReason"; 
        $this->columnsorder[] = "fqcd.TrackingNo4RR"; 

        array_splice($this->columnsorder,4,1);  
    }

    public function ajaxListRejection()
    {
        $this->autoRender = false;
        $this->setExtraFields("reject");
        $is_index = $this->request->getData('is_index');
 
        $pdata = $this->postDataCondition($this->request->getData());
		
		// Remove query limit for all records
		if($pdata['condition']['limit'] == -1){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']);
		} // END

        $process = ($is_index == 'Y') ? 'RJ': 'RJR';
		
        $query = $this->setFilterQuery($this->request->getData('formdata'), $pdata, $process);
		
        $recordsTotal = $this->FilesQcData->getQueryCountResult($query, 'count');

        $data = $this->FilesQcData->getQueryCountResult($query);
 
        $data = $this->getCustomParsingData($data, $is_index);
 
        $response = array(
                        "draw" => intval($pdata['draw']),
                        "recordsTotal" => intval($recordsTotal),
                        "recordsFiltered" => intval($recordsTotal),
                        "data" => $data,

                    );

        echo json_encode($response); 
        exit;
    }
    
    public function postDataCondition(array $postData, $fields=false){
		 
       if(!$fields){
           array_shift($this->columns_alise); 
           unset($this->columns_alise['Actions']); 
           $this->columns_alise["SrNo"] = "fmd.Id";
           $this->columns_alise["qcId"] = "fqcd.Id";
           $this->columns_alise["DocumentTitle"] = "dtm.Title";
       }else{
           $this->columns_alise = [];
           $this->columns_alise["qcId"] = "fqcd.Id";
       }
       $this->columns_alise["ClientCompName"] = "cpm.cm_comp_name";
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
       }

       return $pdata;
   }

    private function setFilterQuery($requestFormdata=[], $pdata=[], $processingstatus='NP', $selectedIds=null){ 
        $whereCondition = ['fcd.DocumentReceived' => 'Y', 'fqcd.Status' => ''];
        
        $add_checkin = true;
        if(isset($processingstatus) && $processingstatus == 'P'){
            $whereCondition = ['fcd.DocumentReceived' => 'Y', 'fqcd.Status !=' => ''];
        }
        
        if(isset($processingstatus) && $processingstatus == 'RJ'){  //
 
            $add_checkin = false;
            $whereCondition = [];
        }

        if(isset($processingstatus) && $processingstatus == 'RJR'){
            $rejectArr = ['OK','RTP','RIH']; 
            $whereCondition = ['fqcd.Status IN' => $rejectArr];
        }
         
        if(!is_null($selectedIds)){
            $selectedIds = $this->CustomPagination->setOnlyRecordIds($selectedIds, $requestFormdata);
            $whereCondition = 	array_merge($whereCondition, ['fcd.RecId IN' => $selectedIds['fmd'], 'fcd.TransactionType IN' => $selectedIds['doc']]);
        }
 
		
		$whereCondition = $this->addCompanyToQuery($whereCondition);
		
		if(!empty($pdata['condition']['search']['searchQcRecordes'])){
			switch($pdata['condition']['search']['searchQcRecordes']){
				
				case 'rih':
				case 'rtp':
					$whereCondition = array_merge($whereCondition , ['fqcd.Status' => strtoupper($pdata['condition']['search']['searchQcRecordes'])]);
					break;
				case 'p':
					$whereCondition = array_merge($whereCondition , ['fqcd.QCProcessingDate' => '0000-00-00', 'fqcd.QCProcessingDate IS NULL']);
				break;
				case 'all':
				break;
				
				break;
			}
		}

		//unset($pdata['condition']['search']['company_id']);
		$query = $this->FilesMainData->qcMasterQuery($whereCondition, $pdata['condition'],$add_checkin);
		//dd($pdata['condition']);
		if(isset($requestFormdata['onholdchkbox']) != 'OH'){
			if(isset($requestFormdata['holdfromdate']))
				unset($requestFormdata['holdfromdate']);
			if(isset($requestFormdata['holdfromdate']))
				unset($requestFormdata['holdfromdate']);
		}
		
		$query = $this->FilesMainData->dateFieldsAddtoQuery($query, $requestFormdata, ['files_checkin_data'.ARCHIVE_PREFIX,'files_qc_data'.ARCHIVE_PREFIX]); // behavior

		return $query;
	}

    private function getCustomParsingData(array $data, $is_index='Y'){
    
		$count = 1;
        foreach ($data as $key => $value) {
	
			if($is_index=='Y' || ($this->user_Gateway)){
				$checkboxdisabled = (($value["lock_status"] == 1) ? 'disabled' : '');
				$value['Checkbox'] = '<input type="checkbox" '.$checkboxdisabled.' id="checkAll[]" name="checkAll[]" value="'.$key.'_'.$value["qcId"].'" class="checkSingle"/><input type="hidden" id="fmdId_'.$key.'" name="fmdId[]" value="'.$value["SrNo"].'"/><input type="hidden" id="docTypeId_'.$key.'" name="docTypeId[]" value="'.$value["TransactionType"].'" /><input type="hidden" id="LRSNum_'.$key.'" value="'.$value["FileNo"].'_'.$value["TransactionType"].'" />';
			}else{  $value['Checkbox'] = $count; }
 
			if($this->user_Gateway){
				$value['Actions'] = $this->CustomPagination->getUserActionButtons($this->name,$value,['qcId','SrNo','TransactionType'], 'common');
			}elseif($is_index=='Y'){
		 
				$value['Actions'] = $this->CustomPagination->getActionButtons($this->name,$value,['SrNo','County','qcId','TransactionType','lock_status'],$prefix = "",$hideViewButton = 6);
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
  
            $value['RejectionReason'] = ($is_index=='Y') ? '<div class="table-descField"><textarea id="rejectionReasonId'.$key.'" name="RejectionReason[]" class="form-control">'.$value["RejectionReason"].'</textarea></div>' : $value["RejectionReason"];
 
			$value['TrackingNo'] = ($is_index=='Y') ? '<div class="table-descField"><textarea id="TrackingNoId'.$key.'" name="TrackingNo[]" class="form-control">'.$value["TrackingNo"].'</textarea></div>' : $value["TrackingNo"];

            $value['PartnerFileNumber'] = $value['PartnerFileNumber'] . ((!empty($value['ClientCompName'])) ? ' ( '.$value['ClientCompName'].' )': '' );
             
			$count++;
        }
 
        unset($data['qcId']);
        return $data;
    }
 

    private function processRejecedRecord(array $postData,$status='RTP') {

		$data= [];$return = false;
		if(isset($postData['checkAll'])){
			
			foreach($postData['checkAll'] as $checkValue){
				if(!empty($checkValue) && strpos($checkValue, '_')){
					$postkeys = explode('_',$checkValue);
					$keyVal = $postkeys[0];
					$recordVal = $postkeys[1];

					$filesMainId = $postData['fmdId'][$keyVal];
					$documentTypeId = $postData['docTypeId'][$keyVal];
                     
                    $data['RejectionReason']   = $postData['RejectionReason'][$keyVal];
                    $data['TrackingNo']     = $postData['TrackingNo'][$keyVal];
                    $data['Status']         = $status;
 
					$return = $this->addUpdateRejectionDetails($filesMainId, $documentTypeId, $data, $recordVal);
					
					$this->FilesCheckinData->updateRejected($filesMainId, $documentTypeId,$status);
					 				
				}
			} // foreach
		}

		if($return){ 
			$this->Flash->success(__('Record data has been saved.'));
		}else{
			$this->Flash->error(__('Record data could not be saved. Please, try again.'));
		}

	}


    private function addUpdateRejectionDetails($filesMainId, $documentTypeId, array $data, $checkValue=''){
		$return = FALSE;
		
		$publicType = 'I';
		$Regarding = 'Record Added';

		$data['RecId'] = $filesMainId;
		$data['TransactionType'] =$documentTypeId;
		$data['UserId'] = $this->currentUser->user_id;
		$data['LastModified'] = date("Y-m-d");
        $data['QCProcessingDate'] = (isset($data['QCProcessingDate']) ? $data['QCProcessingDate'] : date("Y-m-d"));
		$data['QCProcessingTime'] = date("H:i:s");
		
		if(!empty($data['RejectionReason'])){
			$data['RejectionReason'] = $data['RejectionReason'];  
			$postData['RejectionReason'] = $data['RejectionReason']; 
		}
		$data['TrackingNo4RR'] ='';
		if(!empty($data['TrackingNo'])){
			$data['TrackingNo4RR'] = $data['TrackingNo']; 
			$postData['TrackingNo4RR'] = $data['TrackingNo']; 
		}
		//Added code for rejection history
		$postData['Status'] = $data['Status'];
		$postData['fmdId'] = $filesMainId;
		$postData['docTypeId'] = $documentTypeId;
 
		$this->RejectionStatusHistory->saveRSHData($postData);
		
		if(empty($checkValue)){
			$return = $this->FilesQcData->saveQCData($data);
			$Regarding = 'Record Added';			 
		}else{
			$return = $this->FilesQcData->updateQCData($checkValue, $data);
     		$Regarding = 'Record Updated';
		}

		if($return){ 
			$Regarding .= " <b>(Rejection Status: ".$data['Status'].", Rejection Reason: ".$data['RejectionReason'].", Tracking No (RTP): ".$data['TrackingNo4RR'].", Processing Date: ".$data['QCProcessingDate'].")</b>";
			$this->PublicNotes->insertNewPublicNotes($filesMainId, $documentTypeId, $this->currentUser->user_id, $Regarding, 'Fqcd', true, 'Rejection');
		}
		return $return;
		
	}
  
    /**
     * Edit method
     *
     * @param string|null $id Files Qc Data id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $pageTitle = 'QC/Rejection Data';
		$this->set(compact('pageTitle'));
         
		$rejectionHistoryData = [];
		$filesQcData = $this->FilesQcData->newEmptyEntity();

		$recordMainId = $this->request->getParam('fmd');
		$doctype = $this->request->getParam('doctype');
		$section = $this->request->getParam('section');
		
		if(empty($recordMainId) || empty($doctype)){
			return $this->redirect(['action' => 'index']); exit;
		}
		
		$data= [];$return = false;
		
        if ($this->request->is(['patch', 'post', 'put'])) {
			
			$postData = $this->request->getData(); 
			
			$filesMainId = $postData['fmdId'];
			$documentTypeId = $postData['docTypeId'];
			$qcId = $postData['qcId'];
			 
			$clearsave = $this->request->getData('clearsave');
			if(isset($clearsave)){			  
				$return = $this->RejectionStatusHistory->updateAllRSHData($postData['rejectedState'], $postData['ClearanceNote']);				
			}else{ 
				$clearsaveStatus = $this->request->getData('clearsaveStatus');
                if(isset($clearsaveStatus)){					 
					$return = $this->RejectionStatusHistory->updateAllRSHData($postData['rejectedState'], $postData['ClearanceNote']);					
				}else{  
					$return = $this->RejectionStatusHistory->saveRSHData($postData); 
				}
 
				$data = $this->filterByPostType($postData);

				$return = $this->saveUpdateQCData($filesMainId, $documentTypeId, $data, $qcId);

			}
			if($return){ 
                  
				$this->Flash->success(__('The files QC data has been saved.'));
				
				if(isset($clearsave) || isset($clearsaveStatus)){
					// redirect on same edit page
				}else{ 
					if(isset($section) && ($section == 'complete')){
						return $this->redirect([
							'controller' => 'PublicNotes',
							'action' => 'viewComplete',$recordMainId,$doctype
						]);
					}else{ 
						return $this->redirect(['action' => 'index']);
					} 
				} 

			}else{
				$this->Flash->error(__('The files QC data could not be saved. Please, try again.'));
			}
			
		}
  
		$filesMainData = $this->FilesMainData->searchMainDataForAll($recordMainId);

		if(empty($filesMainData)){
			$this->Flash->error(__('Please select correct record.'));
			return $this->redirect(['action' => 'index']);exit;
		}
		
		$filesQcData = $this->FilesQcData->getfilesQcData($recordMainId,$doctype);
	
		$documentData = $this->DocumentTypeMst->get($doctype);
		$documentDataList= [$documentData['Id']=>$documentData['Title']];
	 
		$partnerMapField = $this->CompanyFieldsMap->partnerMapFields($filesMainData['company_id'],1);
 
		$rejectionSHData = $this->RejectionStatusHistory->rejectionHistoryData($recordMainId, $doctype);

		$this->set('section', $section);

        $this->set(compact('filesQcData', 'filesMainData', 'documentData', 'documentDataList','partnerMapField','rejectionSHData'));

		$this->set('_serialize', ['filesQcData']);

		$pageTitle = 'Rejection Data Entry For <u>'.$filesMainData['PartnerFileNumber']."</u>";		
		$this->set(compact('pageTitle'));

    }

    private function filterByPostType(array $postData){
  
		$data = [];
		
		$data['Status'] = $postData['Status'];
		$data['RejectionReason'] = $postData['RejectionReason'];
		$data['TrackingNo4RR'] = $postData['TrackingNo4RR'];
		$data['QCProcessingDate'] = (!empty($postData['ProcessingDate'])) ? date("Y-m-d", strtotime($postData['ProcessingDate'])) : date('Y-m-d');
		$data['QCProcessingTime'] = date("H:i:s");

		$data['publicData']['publicType'] = "I";
		$data['publicData']['regarding'] = $postData['Regarding'];
		
		return $data; 
    }

    private function saveUpdateQCData($filesMainId, $documentTypeId, array $data, $checkValue=''){
		
		$return = FALSE;
		$datapublic = '';
		$publicType = 'I';
		 
		$data['RecId'] = $filesMainId;
		$data['TransactionType'] =$documentTypeId;
		$data['LastModified'] = date("Y-m-d");
		$data['UserId'] = $this->currentUser->user_id;
        $data['QCProcessingDate'] = $data['QCProcessingDate'] ? $data['QCProcessingDate'] : date("Y-m-d");
		$data['QCProcessingTime'] = date("H:i:s");
		 
		if(isset($data['publicData'])){
			$postRegarding = $data['publicData']['regarding'];
			$publicType = $data['publicData']['publicType'];
			unset($data['publicData']);
		}
		 
		if(empty($checkValue)){
			//data insert for QC
			$return = $this->FilesQcData->saveQCData($data);
			$Regarding = (isset($postRegarding)) ? $postRegarding: 'Record Added';
		}else{
			//update data for QC
			$return = $this->FilesQcData->updateQCData($checkValue, $data);
			$Regarding = (isset($postRegarding)) ? $postRegarding: 'Record Updated';
		}

		if($return){ 

			$this->FilesCheckinData->updateRejected($filesMainId, $documentTypeId,$data['Status']); 
			$Regarding .= " <b>(Rejection Status: ".$data['Status'].", Rejection Reason: ".$data['RejectionReason'].", Tracking No (RTP): ".$data['TrackingNo4RR'].", Processing Date: ".$data['QCProcessingDate'].")</b>";
			$this->PublicNotes->insertNewPublicNotes($filesMainId, $documentTypeId, $this->currentUser->user_id, $Regarding, 'Fqcd', false, 'Rejection');
		}

		return $return;
	}
	
	/**
     * View method
     *
     * @param string|null $id Files Qc Data id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$pageTitle = 'Rejection Details';
		$this->set(compact('pageTitle'));
		
		$filesQcData = $this->FilesQcData;

		$recordMainId = $this->request->getParam('fmd');
		$doctype = $this->request->getParam('doctype');
		
		if(empty($recordMainId) || empty($doctype)){
			return $this->redirect(['action' => 'indexPartner']); exit;
		}
		 
		$filesMainData = $this->FilesMainData->searchMainDataForAll($recordMainId);
		if(empty($filesMainData)){
			$this->Flash->error(__('Please select correct record.'));
			return $this->redirect(['action' => 'indexPartner']);exit;
		}
		
		$filesQcData = $this->FilesQcData->getfilesQcData($recordMainId,$doctype);
	
		$documentData = $this->DocumentTypeMst->get($doctype);
		$documentDataList= [$documentData['Id']=>$documentData['Title']];
		
		$this->loadModel("CompanyFieldsMap");
		$partnerMapField = $this->CompanyFieldsMap->partnerMapFields($filesMainData['company_id'],1);

        $this->set(compact('filesQcData', 'filesMainData', 'documentData', 'documentDataList', 'partnerMapField'));

		$this->set('_serialize', ['filesQcData']);
    }
 
}