<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * FilesExamReceipt Controller
 *
 * @method \App\Model\Entity\FilesExamReceipt[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilesExamReceiptController extends AppController
{
  
	private $orig_fields = ['FileStartDate','PartnerID','NATFileNumber','PartnerFileNumber','Grantors','GrantorFirstName1','GrantorFirstName2','Grantees','StreetNumber','StreetName','City','County','State','Zip','TransactionType','CheckInDateTime','CountyRecordingFee','Taxes','AdditionalFees','Total','CarrierName','CarrierTrackingNo','RecordingDate','RecordingTime','InstrumentNumber','Book','Page','PublicNotes','LoanAmount','File'];

    // step for datatable config : 1

    private $columns_alise = [  "Checkbox" => "",
                                "FileNo" => "fmd.NATFileNumber", 
                                "partner_file_number" => "fmd.PartnerFileNumber",
								
                                "transaction_type" => "fmd.TransactionType",
                                "grantors_g1" => "fmd.Grantors",
                                "street_name" => "fmd.StreetName",
                                "county" => "fmd.County",
                                "state" => "fmd.State",
                                "DocStatus" => "fer.DocumentReceived",
                                
                                "DateAdded" => "fer.created",
								"Actions" => ""
								
                            ];

	private  $columnsorder = [0=>'fmd.Id', 1=>'fmd.NATFileNumber', 2=>'fmd.PartnerFileNumber', 4=>'fmd.TransactionType', 5=>'fmd.Grantors', 6=>'fmd.StreetName', 7=>'fmd.county', 8=>'fmd.State', 9=>'fer.DocumentReceived', 11=>'fer.CheckInProcessingDate'];

	//user these model for update delete cammands
	private $otherModelName = ['FilesQcData','FilesAccountingData','FilesShiptocountyData','FilesRecordingData','FilesReturned2partner','PublicNotes'];
	
   public function initialize(): void
   { 
	   parent::initialize();
	   
	   $this->loadModel("FilesMainData");
	   $this->loadModel("CompanyFieldsMap");
	   $this->loadModel("FilesExamReceipt");
	   $this->loadModel("CompanyMst");
	   $this->loadModel('CompanyExportFields');
	   $this->loadModel("DocumentTypeMst");
	   $this->loadModel('CountyMst');
	   $this->loadModel('FilesQcData');
	   $this->loadModel('PublicNotes');
	   $this->loadModel('States');
		
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
			$filesQcData = $this->FilesExamReceipt->find()->where(['RecId'=>$fmdId])->first(); 
 			$filesQcData->barcode_generated = 'Y';  
			$this->FilesExamReceipt->save($filesQcData); 
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
		$pageTitle = 'Exam Receipt Listing';
		$this->set(compact('pageTitle'));
		
		// IF DOCUMENT RECEIVED BUTTON CLICKED
		$csvFileName = '';$townshipRecordsTable = '';
		$docstatus = $this->request->getData('docstatus');
		
		if(isset($docstatus) && (!($this->user_Gateway))) {
			 $pd = $this->request->getData();
			
			$fmd_township_division = $this->request->getData('fmd_township_division');
			$postData = ['sno'=>$this->request->getData('sno'), 'company_id'=>$this->request->getData('company_id'),'fmd_township_division'=>isset($fmd_township_division) ? $this->request->getData('fmd_township_division'): ''];
			//pr($postData);exit;	
			// physical document received process
            if($this->request->getData('docstatus') == "dr"){ 
                //$processDocument = $this->_documentReceived($postData, 'Y');
            }

            if($this->request->getData('docstatus') == "dnr"){
				//$processDocument = $this->_documentReceived($postData);
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
        //$this->set('isSearch', $this->FilesExamReceipt->isSearch());

        $FilesExamReceipt = $this->FilesExamReceipt->newEmptyEntity();

      
        //$mapArray = $this->_getMappingFields($company_mst_id);
		$partnerMapField =  $this->CompanyFieldsMap->partnerMapFields($company_mst_id,1);
	  
        $DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
       // $fileCsvMasterData =  $this->_getCsvFileListing();,'fileCsvMasterData'
        $companyMsts = $this->CompanyMst->companyListArray()->toArray();
		
		// for common data_documentReceivedtable element
		$is_index = 'Y';

        /* Added by Vinit - Start */
        $this->loadModel('Vendors');
        $vendorlist = $this->Vendors->ListArray();
        $vendor_id = 12;
        $vendor_services = $this->Vendors->get_vendor_services($vendor_id);
        /* Added by Vinit - End */

		$this->set('is_index', $is_index);
		
        $this->set(compact('FilesExamReceipt','companyMsts','DocumentTypeData','partnerMapField', 'vendorlist', 'vendor_services'));
        $this->set('_serialize', ['FilesExamReceipt']);

	  // for partner section 
	   $checkinDataSheet = $this->request->getData('checkinDataSheet');
		if(isset($checkinDataSheet))
		{
			$this->checkinRecordsSheet($this->request->getData());
		}
    }
	

	private function townshipErrorTable($townErrorRecArr=[]){
	 
		$towstxt='';

		if(empty($townErrorRecArr)) return $towstxt;

		if(count($townErrorRecArr)>0){
			$listTownError = $this->FilesMainData->getFileMainTownShipData($townErrorRecArr);
		 
			$i = 1;
			
			if(!empty($listTownError)){ 
		
				foreach($listTownError as $listTown){
					$checkboxdisabled = (($listTown["lock_status"] == 1) ? 'disabled' : '');
					$listTownshipDivision = $this->CountyMst->listTownshipDivision($listTown['state'],$listTown['county'], $listTown['Id']);

					$towstxt .='<tr>
									<td><input type="checkbox" '.$checkboxdisabled.' name="checkAll[]" value="'.$listTown['Id'].'" class="checkSingle" data-value="test"/><input type="hidden" name="documentTypeHidden" value="'.$listTown['fcd']['transaction_type'].'"><input type="hidden" name="docTypeInput" class="docinput" value="'.$listTown['fcd']['transaction_type'].'" /></td>
									<td>'.(($listTown['NATFileNumber']) ? substr($listTown['NATFileNumber'],0,65) : '').'</td>
									<td>'.$listTown['partner_file_number'].'<font size=1> ( '.$listTown['comp_mst']['cm_comp_name'].' )</font>'.'</td>
									<td>'.$listTown['dtm']['Title'].'</td>
									<td>'.$listTown['grantors_g1'].'</td>
									<td>'.$listTown['street_name'].'</td>
									<td>'.$listTown['state'].'</td>
									<td>'.$listTown['county'].'</td>	
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
				
				$partnerMapData = $this->FilesExamReceipt->partnerExportFields($companyId,'cef_fieldid4CHI','checkinsheet');
				$partnerMapFields = $partnerMapData['partnerMapFields'];
				$csvNamePrifix = $partnerMapData['csvNamePrifix'];

				//$querymapfields for both condition map fields found or not
				$listRecord = $this->FilesExamReceipt->searchByFileMainIdDocType($fileMainDataId,$fileDocType, $partnerMapFields);

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
					$this->Flash->error(__('Please select township/division for below records. The county has multiple township/division!!'), ['escape'=>false]);
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
 
			$townShipCondition = ($townShipData['countyTownship'] < 2 || $fmd_township_division != "" || $townShipData['TownshipDivision'] != "");

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
								$exists = $this->FilesExamReceipt->exists(['RecId' => $fmd_id, 'transaction_type' => $newdt]);
								if(!$exists){
									//new value NOT exist
									// insert checkin data
									$this->FilesExamReceipt->insertNewCheckinData($fmd_id,$newdt,$this->currentUser->user_id,$DocumentReceived);
									// insert public 
									$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, 'Checkin: Record Inserted','Fcd',true);

								}else{
									// new value but exist // update same rows
									$arr = $this->FilesExamReceipt->updateCheckInData($newdt,$DocumentReceived,$fmd_id);

									// update others
									$this->updateOtherRecords($fmd_id, $newdt, $docTypesarr['hiddenDocType']);

									// public data 
									$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, 'Checkin: Record Updated','Fcd',true);
								}
							}
							else
							{
								// same doctype
								$arr = $this->FilesExamReceipt->updateCheckInData($newdt,$DocumentReceived,$fmd_id,$docTypesarr['hiddenDocType']);
								// public data 
								$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, 'Checkin: Record Updated','Fcd',true);
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
							 $this->FilesExamReceipt->insertNewCheckinData($fmd_id,$newdt,$this->currentUser->user_id,$DocumentReceived);

							//delete record with doctype	
							$this->deleteOtherRecords($fmd_id, $docTypesarr['hiddenDocType']);

							// public data 
							$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, 'Checkin: Record Updated','Fcd',true);

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
								$this->FilesExamReceipt->updateCheckInData($newdt,$DocumentReceived,$fmd_id,$docTypesarr['hiddenDocType']);

								// update others
								$this->updateOtherRecords($fmd_id, $newdt, $docTypesarr['hiddenDocType']);

								// public data 
								$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, 'Checkin: Record Updated','Fcd',true);
							//}
						}
						else
						{
							// same doctype
							$arr = $this->FilesExamReceipt->updateCheckInData($newdt,$DocumentReceived,$fmd_id,$docTypesarr['hiddenDocType']);
							// public data 
							$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, 'Checkin: Record Updated','Fcd',true);
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
					$entity = $this->$modelName->find()->where(['RecId'=>$fmdId, 'transaction_type'=>$doc])->first();
					 
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
		$FilesExamReceipt = $this->FilesExamReceipt->get($id);

          if ($this->FilesExamReceipt->delete($FilesExamReceipt)) {
			// delete row from main data if deleted records is last records from check in.
			$countMainData = $this->FilesExamReceipt->countByFileId($FilesExamReceipt->RecId);
			if($countMainData < 1){
				$this->FilesMainData->deleteAll(['Id'=>$FilesExamReceipt->RecId]);
			}
			
			// delete related records from other table.
			$this->deleteOtherRecords($FilesExamReceipt->RecId,  $FilesExamReceipt->transaction_type);
			
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
			$this->$modelName->updateAll(['transaction_type' => $doctype], ['RecId'=>$fmdId, 'transaction_type IN'=>$oldDocType]);
		}
		return true;
	}

	private function fileTownshipData($fmdId=null){
		 
		$fileTownshipData = $this->FilesMainData->getFieldsByfileId($fmdId, ['county', 'state','TownshipDivision']);
		 
		$countTownship = $this->CountyMst->countTownshipDivision($fileTownshipData['state'], $fileTownshipData['county']);

		$fileTownshipData['countyTownship'] = $countTownship;

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
		
		$resultQuery = $this->FilesExamReceipt->generateQuery($query);
		
		$countRows = 0; // link 
		if($callType == 'form'){
			$countRows = $this->FilesExamReceipt->getQueryCountResult($resultQuery['query'], 'count');
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
	
	
	private function setFilterQuery($requestFormdata, $pdata, $documentReceived='', $selectedIds=null, $documentProcess=''){
		//=====================filter conditions===============================================
		//------DocumentReceived -------------
		$whereCondition = ['fva.vendorid =' => 0];
		
		if($documentReceived == "assigned"){
			$whereCondition = ['fva.vendorid >' => 0];
		}
		if($documentReceived == "notassigned"){
			$whereCondition = ['fva.vendorid =' => 0];
		}
		if($documentReceived == "all"){
			$whereCondition = [];
		}
		//------ DocumentReceived End -------------

		//------DocumentProcess -------------
		$whereConditionDocProcess = ['IFNULL(fer.RecId, 0) =' => '0'];
		
		if($documentProcess == "processed"){
			$whereConditionDocProcess = ['fer.RecId >' => '0'];
		}
		if($documentProcess == "notprocessed"){
			$whereConditionDocProcess = ['IFNULL(fer.RecId, 0) =' => '0'];
		}
		if($documentProcess == "all"){
			$whereConditionDocProcess = [];
		} 
		//------ DocumentProcess End -------------

		// date fields start
		if(isset($requestFormdata['fromdate'])){ // && !empty($requestFormdata['fromdate'])
			$fromdate = $requestFormdata['fromdate'];
		}
		if(isset($requestFormdata['todate'])){ // && !empty($requestFormdata['todate'])
			$todate = $requestFormdata['todate'];
		}
	
		/* if(isset($requestFormdata['file_start_date'])){ // && !empty($requestFormdata['file_start_date'])
			$file_start_date = $requestFormdata['file_start_date'];
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
			$whereCondition = 	array_merge($whereCondition, ['fer.RecId IN' => $selectedIds['fmd'], 'fmd.TransactionType IN' => $selectedIds['doc']]);
		}

		// date fields end
		//=====================filter conditions===============================================
		// set condtion for partner view 
		$whereCondition = 	array_merge($whereCondition,$whereConditionDocProcess);
		$whereCondition = $this->addCompanyToQuery($whereCondition);
		//if($documentReceived == "rejected"){$pdata['condition']['fields'][] = 'fqcd.status';}
		$query = $this->FilesExamReceipt->filecheckinQuery($whereCondition, $pdata, $cm_partner_cmp);
		
		if(isset($fromdate) && isset($todate)){
 
			//$query = $this->FilesExamReceipt->dateBetween($query, $fromdate, $todate, 'fcd.CheckInProcessingDate');
			$query = $this->FilesExamReceipt->dateBetween($query, $fromdate, $todate, 'fer.created');
			//debug($query); 
 
		}
		
		//print_r($whereCondition);exit;
		return $query;
	}
	

	public function postDataCondition(array $postData, $fields=false){ 
		//remove/pop extra fields
	   if(!$fields){
		   array_shift($this->columns_alise);
		   unset($this->columns_alise['Actions']);

		   $this->columns_alise["SrNo"] = "fmd.Id";
		   $this->columns_alise["checkinId"] = "fer.Id";
		   $this->columns_alise["DocumentTitle"] = "dtm.Title";
		   
	   }else{
		   $this->columns_alise = [];
		   $this->columns_alise["checkinId"] = "fer.Id";
		   
	   }
	   $this->columns_alise["ClientCompName"] = "cpm.cm_comp_name";
	   //$this->columns_alise["lock_status"] = "fer.lock_status";
	   //print_r($postData);exit;
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
	 	
	 	$documentProcess = "";
		if(isset($formdata['DocumentProcess'])){
			$documentProcess = $formdata['DocumentProcess'];
			unset($formdata['DocumentProcess']);
		}
 
		$pdata = $this->postDataCondition($this->request->getData()); //print_r($this->request->getData());exit;
		// Remove query limit for all records
		if($pdata['condition']['limit'] == -1){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']);
		} // END
		$query = $this->setFilterQuery($formdata, $pdata, $documentReceived, null, $documentProcess);
 	 	//print_r($$documentProcess);exit;
		// no groupby add
		$recordsTotal = $this->FilesExamReceipt->getQueryCountResult($query, 'count', false); 
		
		$data  =  $this->FilesExamReceipt->getQueryCountResult($query);
		//echo "<pre>"; print_r($data);exit;
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
 
	// step for datatable config : 6 custome data action
    private function getCustomParshingData(array $data){
	  
		// manual
		//echo "<pre>"; print_r($data); exit;
		foreach ($data as $key => $value) {
			 
			$checkboxdisabled = (($value["lock_status"] == 1) ? 'disabled' : '');
			if($this->user_Gateway){
				$value['Checkbox'] = '<input type="checkbox" '.$checkboxdisabled.' id="checkAll[]" name="checkAll[]" value="'.$key.'_'.$value["checkinId"].'" class="checkSingle" data-value="test"/><input type="hidden" id="fmdId_'.$key.'" name="fmdId[]" value="'.$value["SrNo"].'"/><input type="hidden" id="docTypeId_'.$key.'" name="docTypeId[]" value="'.$value["transaction_type"].'" />';
				
				$value['Actions'] = $this->CustomPagination->getUserActionButtons($this->name,$value,['checkinId','SrNo','transaction_type'], 'common');	
				
				$value['transaction_type'] = $value["transaction_type"].' ( '.$value["DocumentTitle"].' )';    

			}else{
				$value['Checkbox'] = '<input type="checkbox" '.$checkboxdisabled.' name="checkAll[]" value="'.$value["SrNo"].'" class="checkSingle"  data-value="test" />'; 
				// onclick="getBarcode(this,'.$value["FileNo"].','.$value["transaction_type"].');"
				$value['Actions'] = $this->CustomPagination->getActionButtons($this->name,$value,['SrNo','FileNo','checkinId','transaction_type','lock_status'],$prefix = "",$hideViewButton = 1);
				
				// documentTypeHidden not use in index
				$value['transaction_type'] = $value["transaction_type"] .' ( '.$value["DocumentTitle"].' )';  

			}
			$dtColor = (($value['DocStatus']=='Y') ? '' : "");
			$value['DocStatus'] = (($value['fva']['vendorid']>0)?'Yes':'No');
			$value['partner_file_number'] = $value['partner_file_number'] . ((!empty($value['ClientCompName'])) ? ' ( '.$value['ClientCompName'].' )': '' );
		 	$value['DateAdded'] = (($value['DateAdded']!='')? '<span>'.date('Y-m-d H:i:s',strtotime((string)$value['DateAdded'])).'</span>' : '');
			//$value['Extension'] =  (($value['Extension']!='')? date('Y-m-d', strtotime($value['Extension'])) : '');
			if($value['ECapable'] == "Y") {
				$value['ECapable'] = 'Both SF & CSC';
			} else if($value['ECapable'] == "S") {
				$value['ECapable'] = 'SF';
			} else if($value['ECapable'] == "C") {
				$value['ECapable'] = 'CSC';
			} else {
				$value['ECapable'] = '';
			}  
			
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
		
		$table = 'CenterBranch,loan_amount,file_start_date,ClientId,NATFileNumber,partner_file_number,grantors_g1,first_name_1_g1,first_name_2_g1,grantees_g2,first_name_1_g2,street_name,street_name,city,state,apn_parcel_number';
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
    public function add($companyId = null)
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

		$nat_file_number = '';
        $FilesExamReceipt = $this->FilesExamReceipt->newEmptyEntity();
		
        if ($this->request->is('post')) {
			$saveOpenBtn = $this->request->getData('saveOpenBtn');
			$saveBtn = $this->request->getData('saveBtn');
			
			if(isset($saveOpenBtn) || isset($saveBtn))
			{ 
				// check state and county for records
				$countyDetails = $this->CountyMst->getCountyTitleBystateCounty($this->request->getData('state'),$this->request->getData('county'));
				
				$countyDetailsCount = ((is_array($countyDetails) || $countyDetails instanceof Countable) ? count($countyDetails) : 0);

				if($countyDetailsCount >= 1)
				{
					// ADD NEW RECORDS
					$nat_file_number = $this->setnat_file_number();
					$postData = $this->request->getData(); 

					$sqlmainInt = $this->FilesExamReceipt->sqlDataInsertByForm($postData, $this->currentUser->user_id,$countyDetails['cm_file_enabled'],$nat_file_number);
 
					// new add
					$filesMainDataEnter = $this->FilesMainData->newEmptyEntity();
					$filesMainDataEnter = $this->FilesMainData->patchEntity($filesMainDataEnter, $sqlmainInt);
					
					if($this->FilesMainData->save($filesMainDataEnter))
					{
						$insId = $filesMainDataEnter->Id; 
						
						$docTypesarr = [DOCTYPE]; // set default doc type if not present 99
						$transaction_type = $this->request->getData('transaction_type');
						if( isset($transaction_type) && !empty($transaction_type)) // && strpos($this->request->data['transaction_type'], ',')
						{ 
							$docTypesarr =$this->explodeDocType($transaction_type); 
						}
						foreach($docTypesarr as $docType){
							// document type not equal to 0
							$docType = $this->setDocType($docType);
							// check for extension NEW
							//$extensionDT  = $this->FilesExamReceipt->getMainDataByMultiDocType($insId, $doctype, 'Id');
 							//Insert in CheckIn with transaction_type		
							$this->FilesExamReceipt->insertNewCheckinData($insId, $docType, $this->currentUser->user_id, $this->request->getData('DocumentReceived'));
							
							// ###### Coding for adding/updating -public_notes
							// need to ask
							$regarding = (empty(trim($this->request->getData('Regarding')))) ? 'Checkin: Record Added': trim($this->request->getData('Regarding'));
							$this->PublicNotes->insertNewPublicNotes($insId, $docType, $this->currentUser->user_id, $regarding, 'Fcd'); //$this->request->getData('Public_Internal')
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
					$this->Flash->error(__('Please Enter Correct county Name.'));
				}
				// come from GOTO function 
				errordisplay:{
					$this->Flash->error(__('Please Check Date Format.')); 
				}
			}
			
			// for open new add form
			$nat_file_number = $this->setnat_file_number();
        }
		 
		$countyList = $this->CountyMst->getCountyTitleByState();
		//pr($countyList); exit;
		$stateList = $this->States->stateListArray();
		
		$companyMsts = $this->CompanyMst->companyListArray();
		
		$this->set('partner_id', $companyId);
		$this->set('nat_file_number', $nat_file_number);
		
        $this->set(compact('FilesExamReceipt', 'companyMsts','partnerMapFields','stateList','countyList')); // 'documentList'
        $this->set('_serialize', ['FilesExamReceipt']);
    }
	
	public function searchCountyAjax()
	{
		$this->autoRender = false;
		
		$id = $this->request->getData('id');
		$countyTitle = $this->CountyMst->getCountysByStateName($id);
		
		$towstxtErrorCounty = '<select name="county" class="form-control" required="required"><option value="">Select county</option>';
		foreach($countyTitle as $key=>$countyText){
			if($countyText['cm_title'] != null){   
				$towstxtErrorCounty .= '<option value="'.$countyText['cm_title'].'"'; 
				$towstxtErrorCounty .= '>'.$countyText['cm_title'].'</option>';
			}
		}
		$towstxtErrorCounty .= '</select>';
		echo $towstxtErrorCounty; 
		exit;
	}
	
	public $setmaxLRSno='';
	public function setnat_file_number($is_loop = false)
	{
		$dbLRSnumber = '';
		if($is_loop == false){  $this->setmaxLRSno = ''; }
		
		if(empty($this->setmaxLRSno)){ 
			$lrsFilenoList = $this->FilesMainData->getMaxLRSfileno();
			$dbLRSnumber = ((is_array($lrsFilenoList)) ? $lrsFilenoList['nat_file_number'] : '');
		}else{
			//$existMaxLRS = $this->FilesExamReceipt->FilesMainData->exists(['nat_file_number'=>$this->setmaxLRSno]);
			$dbLRSnumber = $this->setmaxLRSno;
		}

		$nat_file_number = 300000;
		if(!empty($dbLRSnumber)){
			if(intval($dbLRSnumber) < 300000){
				$nat_file_number = 300000;
			}else{
				$nat_file_number = $dbLRSnumber+1;
			}
			$this->setmaxLRSno = $nat_file_number;
		}
		return $nat_file_number;
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
				// check selected state and county are correct or not
				$countyDetails = $this->CountyMst->getCountyTitleBystateCounty($this->request->getData('state'),$this->request->getData('county'));
				$countyDetails = ((is_array($countyDetails) || $countyDetails instanceof Countable) ? count($countyDetails) : 0);
					
				if($countyDetails >= 1)
				{ 
					// update file main data
					$postData = $this->request->getData();
			 	
					$this->FilesMainData->updateFileMainData($postData,$fmd_id);
				 
					/****************************************/
					//Add document Type and checkin Records
		 		 	$this->editSaveCheckinData($postData);
					/****************************************/  

					$this->Flash->success(__('Records updated successfully !!'));
					$transaction_type = $postData['transaction_type'];
					if(isset($this->request->getParam('pass')[1]) && ($this->request->getParam('pass')[1] == 'complete')){
							return $this->redirect([
								'controller' => 'PublicNotes',
								'action' => 'viewComplete/'.$fmd_id.'/'.$transaction_type/* ,
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
					$this->Flash->error(__('Please enter correct county name.'));
				}
			}
         
        }

		// fetch records from fmd and fcd table
		$FilesExamReceipt = $this->FilesMainData->getFileMainData($id); // checkIn id
 
		if(!empty($FilesExamReceipt)){
			$fmd_id = $FilesExamReceipt['Id']; // file main data id
			$companyId = $FilesExamReceipt['company_id']; // need to discuss
			
			$partnerMapFields = $this->CompanyFieldsMap->partnerMapFields($companyId);
			
			$this->set('partner_id', $companyId);
			$this->set('fmd_id', $fmd_id);
		}else{
			$this->Flash->error(__('Please select correct record.'));
			return $this->redirect(['action' => 'index']);exit;
		}
		
		
		$countyList = $this->CountyMst->getCountyTitleByState($FilesExamReceipt['state']);
		
		$stateList = $this->States->stateListArray();
		
	    $documentList =  $this->DocumentTypeMst->documentList();
		
		$companyMsts = $this->CompanyMst->companyListArray();
		
        $this->set(compact('FilesExamReceipt', 'companyMsts','partnerMapFields','stateList','countyList','documentList'));
        $this->set('_serialize', ['FilesExamReceipt']);
		
    }

	
    public function examReceiptList()
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
			//echo "<pre>";print_r($formpostdata);exit;
        }

		
        $this->set('formpostdata', $formpostdata);
        //end step
		$this->set('isSearch', $isSearch);
        //$this->set('isSearch', $this->FilesExamReceipt->isSearch());

        $FilesExamReceipt = $this->FilesExamReceipt->newEmptyEntity();

      
        //$mapArray = $this->_getMappingFields($company_mst_id);
		$partnerMapField =  $this->CompanyFieldsMap->partnerMapFields($company_mst_id,1);
	  
        $DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
       // $fileCsvMasterData =  $this->_getCsvFileListing();,'fileCsvMasterData'
        $companyMsts = $this->CompanyMst->companyListArray()->toArray();
		
		// for common data_documentReceivedtable element
		$is_index = 'Y';

        /* Added by Vinit - Start */
        $this->loadModel('Vendors');
        $vendorlist = $this->Vendors->ListArray();
        $vendor_id = 12;
        $vendor_services = $this->Vendors->get_vendor_services($vendor_id);
        /* Added by Vinit - End */

		$this->set('is_index', $is_index);
		
        $this->set(compact('FilesExamReceipt','companyMsts','DocumentTypeData','partnerMapField', 'vendorlist', 'vendor_services'));
        $this->set('_serialize', ['FilesExamReceipt']);

	  // for partner section 
	   $checkinDataSheet = $this->request->getData('checkinDataSheet');
		if(isset($checkinDataSheet))
		{
			$this->checkinRecordsSheet($this->request->getData());
		}
    }
    public function examReceiptBkp($id = null)
    {
    	$this->examReceipt($id);
    }
    public function examReceipt($id = null)
    {
		// set page title
        $pageTitle = 'Receipt of Exam';
        $this->set(compact('pageTitle')); 
		
		$sqlmainInt = [];
		$FilesMainData = $this->FilesMainData->getFileExamMainData($id);
		//echo "<pre>";print_r($FilesMainData);exit;

		if(!empty($FilesMainData)) {

			$fmd_id = $FilesMainData['Id']; // file main data id
			$companyId = $FilesMainData['company_id']; // need to discuss
			$examReceiptFields = $this->FilesExamReceipt->getMainDataAll($fmd_id);
			$partnerMapFields = $this->CompanyFieldsMap->partnerMapFields($companyId);
			
			$vesting_attributes = [];
			if(!empty($examReceiptFields->vesting_attributes)) {
				$vesting_attributes = json_decode($examReceiptFields->vesting_attributes, true);
			}
			$open_mortgage_attributes = [];
			if(!empty($examReceiptFields->open_mortgage_attributes)) {
				$open_mortgage_attributes = json_decode($examReceiptFields->open_mortgage_attributes, true);
			}
			$open_judgments_attributes = [];
			if(!empty($examReceiptFields->open_judgments_attributes)) {
				$open_judgments_attributes = json_decode($examReceiptFields->open_judgments_attributes, true);
			}
			//echo "<pre>";print_r($vesting_attributes);exit;
	        if ($this->request->is(['post', 'put'])) {

				$saveOpenBtn = $this->request->getData('saveOpenBtn');
				$saveBtn = $this->request->getData('saveBtn');
				
				if(isset($saveOpenBtn) || isset($saveBtn))
				{ 
					$examReceipt = $this->FilesExamReceipt->newEmptyEntity();
					$hasExamReceipt = $this->FilesExamReceipt->getRecordData($fmd_id);

					if(!empty($hasExamReceipt)) {  
						$examReceipt = $hasExamReceipt;
					}

			        if ($this->request->is(['post', 'put'])) {
			        	$examReceiptData = $this->request->getData();

                        // ********* Added by Vinit to upload documents start *********
                        $uploadPath = WWW_ROOT . 'uploads' . DS;
                        if (!is_dir($uploadPath)) {
                            mkdir($uploadPath, 0777, true);
                        }

                        if (
                            isset($examReceiptData['supporting_documentation']) &&
                            $examReceiptData['supporting_documentation'] instanceof \Laminas\Diactoros\UploadedFile
                        ) {
                            if ($examReceiptData['supporting_documentation']->getClientFilename()) {
                                $file = $examReceiptData['supporting_documentation'];
                                $fileName = time() . '_' . $file->getClientFilename();

                                try {
                                    // Move the file
                                    $file->moveTo($uploadPath . $fileName);

                                    // Save only the filename as a string
                                    $examReceiptData['supporting_documentation'] = $fileName;
                                } catch (\Exception $e) {
                                    $this->Flash->error(__('File upload failed: ' . $e->getMessage()));
                                    return $this->redirect(['action' => 'exam-receipt', $id]);
                                }
                            } else {
                                $examReceiptData['supporting_documentation'] = $examReceiptData->supporting_documentation;
                            }
                        } else {
                            unset($examReceiptData['supporting_documentation']);
                        }
                        // ********* Added by Vinit to upload documents end *********

			        	$examReceiptData["vesting_attributes"] = array_filter($examReceiptData["vesting_attributes"], function ($item) {
						    return !empty(array_filter($item));
						});

						$examReceiptData["open_mortgage_attributes"] = array_filter($examReceiptData["open_mortgage_attributes"], function ($item) {
						    return !empty(array_filter($item));
						});

						$examReceiptData["open_judgments_attributes"] = array_filter($examReceiptData["open_judgments_attributes"], function ($item) {
						    return !empty(array_filter($item));
						});

			        	$examReceiptData['vesting_attributes'] = json_encode($examReceiptData['vesting_attributes']);
			        	$examReceiptData['open_mortgage_attributes'] = json_encode($examReceiptData['open_mortgage_attributes']);
			        	$examReceiptData['open_judgments_attributes'] = json_encode($examReceiptData['open_judgments_attributes']);
			        	//echo "<pre>";print_r($examReceiptData);exit;
        				$examReceiptData['user_id'] = $this->currentUser->user_id;
			            $examReceipt = $this->FilesExamReceipt->patchEntity($examReceipt, $examReceiptData);
			            if ($this->FilesExamReceipt->save($examReceipt)) {
			                $this->Flash->success(__('The vendor has been updated.'));
			                return $this->redirect(['action' => 'index']);
			            }
			            $this->Flash->error(__('Unable to update the vendor.'));
			        }
					
					$this->Flash->success(__('Records added successfully !!'));
				}
				
	        }
			
			$this->set('partner_id', $companyId);
			$this->set('fmd_id', $fmd_id);

		} else {

			$this->Flash->error(__('Please select correct record.'));
			return $this->redirect(['action' => 'index']);exit;
		}
		 
		$countyList = $this->CountyMst->getCountyTitleByState();
		//pr($countyList); exit;
		$stateList = $this->States->stateListArray();
		
		$companyMsts = $this->CompanyMst->companyListArray();

        $filesExamReceiptNew = $this->FilesExamReceipt->find()
        ->select(['supporting_documentation', 'created', 'modified'])
        ->where(['RecId' => $id])
        ->first();

		$this->set('partner_id', $companyId);
		$this->set('nat_file_number', $nat_file_number);

        $this->set(compact('FilesExamReceipt','FilesMainData','examReceiptFields','open_mortgage_attributes','open_judgments_attributes','vesting_attributes','companyMsts','partnerMapFields','stateList','countyList', 'filesExamReceiptNew')); // 'documentList'
        $this->set('_serialize', ['FilesExamReceipt']);
		
    }
	
	private function editSaveCheckinData($postData){
		$regarding = (empty(trim($postData['Regarding']))) ? 'Record Updated':trim($postData['Regarding']);
		 
		$docTypesarr =$this->explodeDocType($postData['transaction_type']); 
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
		$docTypesarr = $postData['transaction_type']; // explode(',',$postData['transaction_type']);
		//$docTypesarr[0] 
		$docType = $this->setDocType($docTypesarr);

		$typeHiddenArr = $postData['documentTypeHidden'];
		$fmd_id = $postData['fmd_id'];
		
		$countFileCheckIn = $this->FilesExamReceipt->checkCountByFileIdDoctype($fmd_id, $docType);
		//if hidden doc type is single value then ??? 
		 
		// new doc type
		if($countFileCheckIn < 1)
		{
			 
			// assume typeHiddenArr is single value
			$arr = $this->FilesExamReceipt->updateCheckInData($docType,$postData['DocumentReceived'],$fmd_id,$typeHiddenArr);

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
				$arr = $this->FilesExamReceipt->updateCheckInData($docType,$postData['DocumentReceived'],$fmd_id,$typeHiddenArr);
			}
		}
 
		//insert in QC id document recived is 'Y'
		if($postData['DocumentReceived'] == 'Y'){
			$this->FilesQcData->insertNewQcData($fmd_id, $docType, $this->currentUser->user_id);
			$this->PublicNotes->insertNewPublicNotes($fmd_id, $docType, $this->currentUser->user_id, 'Checkin: Record Document Received Inserted','Fqcd',true);
		}
		
		//********  Coding for adding/updating public_notes *************** 
		$this->PublicNotes->insertNewPublicNotes($fmd_id, $docType, $this->currentUser->user_id, $regarding, 'Fcd'); //$postData['Public_Internal']
		 
		return true;

	}
	
	private function explodeDocType($transaction_type){
		
		if(is_int($transaction_type)){ 
			$docTypesarr =[$transaction_type]; 
		}else{ 
			$docTypesarr =[$transaction_type]; 
			if(strpos($transaction_type, ',') !== false){
				$docTypesarr = @explode(',', $transaction_type);
			}
		}
		return $docTypesarr;
	}

	private function saveMultiSameDocument($postData){
		$regarding = (empty(trim($postData['Regarding']))) ? 'Record Updated':trim($postData['Regarding']);
		
		$docTypesarr = $this->explodeDocType($postData['transaction_type']); 
		 
		$typeHiddenArr = $postData['documentTypeHidden'];
		$fmd_id = $postData['fmd_id'];
		
		//other insert
		foreach($docTypesarr as $newdt)
		{
			$newdt = $this->setDocType($newdt);
			
			if($newdt != $typeHiddenArr)
			{
			
				$countFileCheckIn = $this->FilesExamReceipt->checkCountByFileIdDoctype($fmd_id, $newdt);
		
				if($countFileCheckIn < 1){
					// check for extension NEW
					//$extensionDT  = $this->FilesExamReceipt->getMainDataByMultiDocType($fmd_id, $newdt, 'Id'); 
					 // insert checkin data
					 $this->FilesExamReceipt->insertNewCheckinData($fmd_id,$newdt,$this->currentUser->user_id,$postData['DocumentReceived']);
					 
					 //********  Coding for adding/updating public_notes *************** 
					 $this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, $regarding, 'Fcd'); //$postData['Public_Internal']
				}
			}else
			{
			
				$arr = $this->FilesExamReceipt->updateCheckInData($newdt,$postData['DocumentReceived'],$fmd_id,$typeHiddenArr);
				// internal
				$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, $regarding,'Fcd'); //$postData['Public_Internal']
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
		 
		$docTypesarr =$this->explodeDocType($postData['transaction_type']); 

		$typeHiddenArr = $postData['documentTypeHidden'];
		$fmd_id = $postData['fmd_id'];
		
		$first = 1;		
		foreach($docTypesarr as $newdt)
		{
			$newdt = $this->setDocType($newdt);
			//$countFileCheckIn = $this->FilesExamReceipt->checkCountByFileIdDoctype($fmd_id, $newdt);
			$exist = $this->FilesExamReceipt->exists(['RecId' => $fmd_id, 'transaction_type' => $newdt]);
			$alexist = 1;
			if(!$exist)
			{
				$alexist = 0;
				if($first)
				{
					//update files_checkin_data
					// assume typeHiddenArr is single value
					$arr = $this->FilesExamReceipt->updateCheckInData($newdt,$postData['DocumentReceived'],$fmd_id,$typeHiddenArr);
					
					//********  Coding for adding/updating public_notes ***************
					 
					 $this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, $regarding, 'Fcd'); //$postData['Public_Internal']
					  
					//update in other processe pending
					$this->updateOtherRecords($fmd_id, $newdt, $typeHiddenArr);
					
					$first = 0;
				}
				else
				{
					// check for extension NEW
					//$extensionDT  = $this->FilesExamReceipt->getMainDataByMultiDocType($fmd_id, $newdt, 'Id'); 
					// insert checkin data
					$this->FilesExamReceipt->insertNewCheckinData($fmd_id,$newdt,$this->currentUser->user_id,$postData['DocumentReceived']);
					// insert punblic notes
					
					$this->PublicNotes->insertNewPublicNotes($fmd_id, $newdt, $this->currentUser->user_id, $regarding, 'Fcd'); //$postData['Public_Internal']
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
        //$this->set('isSearch', $this->FilesExamReceipt->isSearch());

        $FilesExamReceipt = $this->FilesExamReceipt->newEmptyEntity();

      
        //$mapArray = $this->_getMappingFields($company_mst_id);
		$partnerMapField =  $this->CompanyFieldsMap->partnerMapFields($company_mst_id,1);
		
        $DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
       // $fileCsvMasterData =  $this->_getCsvFileListing();,'fileCsvMasterData'
        $companyMsts = $this->CompanyMst->companyListArray()->toArray();
		
		// for common data_documentReceivedtable element
		$is_index = 'Y';
		$this->set('is_index', $is_index);
		
        $this->set(compact('FilesExamReceipt','companyMsts','DocumentTypeData','partnerMapField'));
        $this->set('_serialize', ['FilesExamReceipt']);
      
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
		$recordsTotal = $this->FilesExamReceipt->getQueryCountResult($query, 'count', false); 
		
		$data  =  $this->FilesExamReceipt->getQueryCountResult($query);
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
		$checkinData = $this->FilesExamReceipt->updateLockRecord($formdata['chechinId'], $formdata['lock_status']);
		if(!empty($checkinData)){  
			// add insert row in public notes fcd table  
			$this->PublicNotes->insertNewPublicNotes($checkinData['RecId'], $checkinData['transaction_type'], $this->currentUser->user_id, 'Lock : '.$formdata['lock_comment'],'Fcd',true);
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
		
		$FilesExamReceipt = $this->FilesExamReceipt->getCheckInData($recordMainId, $doctype); 
		
		$documentData = $this->DocumentTypeMst->get($doctype);
		$documentDataList= [$documentData['Id']=>$documentData['Title']];
		 
		$partnerMapField = $this->CompanyFieldsMap->partnerMapFields($filesMainData['company_id'],1);

        $this->set(compact('FilesExamReceipt', 'filesMainData', 'documentData', 'documentDataList','partnerMapField'));
		
        $this->set('_serialize', ['FilesExamReceipt']);
		
    }
	
	private function generateCsvSheet($resultQuery=[], $callType='form'){
		$csvFileName ='';
		
		$partnerMapData = $this->partnerMapFields($resultQuery['companyId']);
		
		$csvNamePrifix = $partnerMapData['csvNamePrifix'].$resultQuery['limitPrifix'];
		
		$skipJoin = ['files_checkin_data'.ARCHIVE_PREFIX];
		$param  = ['partnerMapFields'=>$partnerMapData['partnerMapFields'], 'skipJoin'=>$skipJoin, 'onlyQuery'=>false];

		// behaviour call for adding extra fields for CSV sheet
		$resultQuery  = $this->FilesExamReceipt->generateQuery($resultQuery['query'], $param); 
		$resultRecord = $this->FilesExamReceipt->getQueryCountResult($resultQuery['query']); 
		$listRecord   = $this->FilesExamReceipt->setListRecords($resultRecord, $resultQuery['headerParams']);
		
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
		$partnerMapData = $this->FilesExamReceipt->partnerExportFields($companyId,'cef_fieldid4CHI','checkinsheet');
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
		$FilesExamReceipt = $this->FilesExamReceipt->get($id);

        if ($this->FilesExamReceipt->delete($FilesExamReceipt)) {
			// delete row from main data if deleted records is last records from check in.
			$countMainData = $this->FilesExamReceipt->countByFileId($FilesExamReceipt->RecId);
			if($countMainData < 1){
				$this->FilesMainData->deleteAll(['Id'=>$FilesExamReceipt->RecId]);
			}
			
			// delete related records from other table.
			$this->deleteOtherRecords($FilesExamReceipt->RecId,  $FilesExamReceipt->transaction_type);
			
            $this->Flash->success(__('The files checkin data has been deleted.'));
        } else {
            $this->Flash->error(__('The files checkin data could not be deleted. Please, try again.'));
        } 
		
        return $this->redirect(['action' => 'index']);
    }
    /*
    **	Master View Method
    **	$id input parameter
    */
    public function masterView($id = null)
    {
		//$id file check in data
		// set page title
		$pageTitle = 'NAT File Details';
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
				// check selected state and county are correct or not
				$countyDetails = $this->CountyMst->getCountyTitleBystateCounty($this->request->getData('State'),$this->request->getData('County'));
				$countyDetails = ((is_array($countyDetails) || $countyDetails instanceof Countable) ? count($countyDetails) : 0);
					
				if($countyDetails >= 1)
				{ 
					// update file main data
					$postData = $this->request->getData();
			 	
					$this->FilesMainData->updateFileMainData($postData,$fmd_id);
				 
					/****************************************/
					//Add document Type and checkin Records
		 		 	$this->editSaveCheckinData($postData);
					/****************************************/  

					$this->Flash->success(__('Records updated successfully !!'));
					$transactionType = $postData['transactionType'];
					if(isset($this->request->getParam('pass')[1]) && ($this->request->getParam('pass')[1] == 'complete')){
							return $this->redirect([
								'controller' => 'PublicNotes',
								'action' => 'viewComplete/'.$fmd_id.'/'.$transactionType/* ,
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
					$this->Flash->error(__('Please enter correct county name.'));
				}
			}
         
        }

		// fetch records from fmd and fcd table
		$FilesExamReceipt = $this->FilesMainData->getFileMainData($id); // checkIn id
 
		if(!empty($FilesExamReceipt)){
			$fmd_id = $FilesExamReceipt['Id']; // file main data id
			$companyId = $FilesExamReceipt['CompanyId']; // need to discuss
			
			$partnerMapFields = $this->CompanyFieldsMap->partnerMapFields($companyId);
			
			$this->set('partner_id', $companyId);
			$this->set('fmd_id', $fmd_id);
		}else{
			$this->Flash->error(__('Please select correct record.'));
			return $this->redirect(['action' => 'index']);exit;
		}
		
		
		$countyList = $this->CountyMst->getCountyTitleByState($FilesExamReceipt['State']);
		
		$stateList = $this->States->stateListArray();
		
	    $documentList =  $this->DocumentTypeMst->documentList();
		
		$companyMsts = $this->CompanyMst->companyListArray();
		
        $this->set(compact('FilesExamReceipt', 'companyMsts','partnerMapFields','stateList','countyList','documentList'));
        $this->set('_serialize', ['FilesExamReceipt']);
		
    }

    public function upload()
    {
        if ($this->request->is('post')) {
            $file = $this->request->getData('csv_file');

            // Validate file type
            if ($file->getClientMediaType() !== 'text/csv') {
                $this->Flash->error(__('Only CSV files are allowed.'));
                return $this->redirect(['action' => 'upload']);
            }

            $filePath = TMP . $file->getClientFilename();
            $file->moveTo($filePath);

            // Read CSV file
            $csvData = array_map('str_getcsv', file($filePath));
            unlink($filePath); // Delete file after reading

            if (!empty($csvData)) {
                $header = array_shift($csvData); // First row as header

                // Ensure columns match table fields
                $expectedFields = [
                    "RecId", "user_id", "transaction_type", "extension", "DocumentReceived",
                    "CheckInProcessingDate", "CheckInProcessingTime", "lock_status",
                    "OfficialPropertyAddress", "vesting_attributes", "open_mortgage_attributes",
                    "open_judgments_attributes", "VestingDeedType", "VestingConsiderationAmount",
                    "VestedAsGrantee", "VestingGrantor", "VestingDated", "VestingRecordedDate",
                    "VestingBookPage", "VestingInstrument", "VestingComments", "OpenMortgageAmount",
                    "OpenMortgageDated", "OpenMortgageRecordedDate", "OpenMortgageBookPage",
                    "OpenMortgageInstrument", "OpenMortgageBorrowerMortgagor", "OpenMortgageLenderMortgagee",
                    "OpenMortgageTrustee1", "OpenMortgageTrustee2", "OpenMortgageComments",
                    "OpenJudgmentsType", "OpenJudgmentsLienHolderPlaintiff", "OpenJudgmentsBorrowerDefendant",
                    "OpenJudgmentsAmount", "OpenJudgmentsDateEntered", "OpenJudgmentsDateRecorded",
                    "OpenJudgmentsBookPage", "OpenJudgmentsInstrument", "OpenJudgmentsComments",
                    "TaxStatus", "TaxYear", "TaxAmount", "TaxType", "TaxPaymentSchedule",
                    "TaxDueDate", "TaxDeliquentDate", "TaxComments", "TaxLandValue", "TaxBuildingValue",
                    "TaxTotalValue", "TaxAPNAccount", "TaxAssessedYear", "TaxTotalValue2",
                    "TaxMunicipalityCounty", "LegalDescription"
                ];

                if ($header !== $expectedFields) {
                    $this->Flash->error(__('CSV header does not match the required format.'));
                    return $this->redirect(['action' => 'upload']);
                }

                $entities = [];

                foreach ($csvData as $row) {
                    $data = array_combine($header, $row);
                    $entities[] = $this->FilesExamReceipt->newEntity($data);
                }

                if ($this->FilesExamReceipt->saveMany($entities)) {
                    $this->Flash->success(__('CSV file uploaded and data saved successfully.'));
                } else {
                    $this->Flash->error(__('Failed to save some records.'));
                }
            } else {
                $this->Flash->error(__('CSV file is empty.'));
            }

            return $this->redirect(['action' => 'upload']);
        }

        $this->set(compact('filesExamReceipt'));
    }

}