<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Routing\Router;
/**
 * FilesShiptoCountyData Controller
 *
 * @property \App\Model\Table\FilesShiptoCountyDataTable $FilesShiptoCountyData
 * @method \App\Model\Entity\FilesShiptoCountyData[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilesShiptoCountyDataController extends AppController
{

    private $columns_alise = [  "Checkbox" => "",
                                "FileNo" => "fmd.NATFileNumber",
                                "PartnerFileNumber" => "fmd.PartnerFileNumber",
                                "TransactionType" => "fcd.TransactionType",
                                "Grantors" => "fmd.Grantors",
                                "StreetName" => "fmd.StreetName",
                                "County" => "fmd.County",
                                "State" => "fmd.State",  
                                "ECapable" => "fmd.ECapable", 
								"shipLabelURL" => "fsad.shipLabelURL"
                            ];

	private $columnsorder = [0=>'fmd.Id', 1=>'fmd.NATFileNumber', 2=>'fmd.PartnerFileNumber', 3=>'fsad.TransactionType', 4=>'fmd.Grantors', 5=>'fmd.StreetName', 6=>'fmd.County', 7=>'fmd.State', 8=>'fmd.ECapable',9=>'fsad.shipLabelURL'];

    private $pageType = 'index';
	
	public function initialize(): void
	{
		parent::initialize();
		$this->loadModel("CompanyFieldsMap");
		$this->loadModel("DocumentTypeMst");
		$this->loadModel("CompanyMst");
		$this->loadModel("FilesMainData"); 
		 
		$this->loadModel('CountyMst');
		$this->loadModel('FilesQcData');
		$this->loadModel('PublicNotes');
		$this->loadModel('FedexShippingSetting');

		$this->loadComponent('GeneratePDF');
	}
	
	public function beforeFilter(\Cake\Event\EventInterface $event)
    {
		parent::beforeFilter($event);
		$this->loginAccess();
	}

	public function indexPartner(){
		$this->index('MSTP'); 
	}
	
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($pageType = '')
    {
		$pageTitle = 'Manage Shipping';
		$this->set(compact('pageTitle'));

		$this->setPageType($pageType);
		
		$this->setExtraFields();
		
		// set company Id in app controller
		$requestData = $this->request->getData();
		$company_mst_id = $this->setCompanyId($requestData); 
		$generateShipping = $this->request->getData('generateShipping');
		$recordingData = $this->request->getData('recordingData');
        $sendRecordingDataSheet = $this->request->getData('sendRecordingDataSheet');

		/************** Index page Post****************/
		// Add recording details RecordingData  sendRecordingDataSheet
		if(isset($recordingData)){
			$this->_processShippingData($this->request->getData());
		}
		
		if(isset($generateShipping)){
			$this->_processShippingDataAuto($this->request->getData());
		}
		/************END Index page Post******************/
		
		// Check user is admin or not
		if($this->user_Gateway){
			$noOrder = ['Actions'];
			unset($this->columns_alise['Checkbox']);
		}else{ 
			$noOrder = ['Checkbox', 'Actions'];
		}
		$this->set('dataJson', $this->CustomPagination->setDataJson($this->columns_alise,$noOrder));
 
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
        
		$partnerMapField =  $this->CompanyFieldsMap->partnerMapFields($company_mst_id,1);
		 
        $documentTypeData = $this->DocumentTypeMst->documentTypeListing();
        $companyMsts = $this->CompanyMst->companyListArray()->toArray();

		// partener company List
		$partnerCompanyList = $this->CompanyMst->partnerCompanyList();
        
		$FilesShiptoCountyData = $this->FilesShiptoCountyData->newEmptyEntity();
        $this->set(compact('FilesShiptoCountyData', 'companyMsts', 'documentTypeData','partnerMapField', 'partnerCompanyList'));
		
		$this->set('datatblHerader', $this->columns_alise);
        $this->set('_serialize', ['FilesShiptoCountyData']);		
		
		// call page 
		$this->set('pageType', $this->pageType);
		
		// generate sheets on differant pages
		//shipping management page
        $generateDataSheet = $this->request->getData('generateDataSheet');
		if(isset($generateDataSheet) && ($this->pageType == 'MSTP')){
			$this->shippingManagementData($this->request->getData(), $this->pageType);
		}
		
		// index page button 
		if(isset($sendRecordingDataSheet)){
			$this->shippingManagementData($this->request->getData(), $this->pageType);
			$this->_processShippingData($this->request->getData(), true);
		}

    }

    private function setPageType($pageType){
		// set default
		$this->pageType = (empty($pageType)) ? $this->pageType : $pageType;;
	}
    
    public function ajaxListIndex(){

		$this->autoRender = false;
 
	    $is_index = $this->request->getData('is_index');
	    $this->setPageType($is_index);

	    $this->setExtraFields();

	    $processingstatus = 'dns'; // not processed
		$formdata = $this->request->getData('formdata');
 
		if(isset($formdata['ShippingStatus'])){
			$processingstatus = $formdata['ShippingStatus'];
			unset($formdata['ShippingStatus']);
		}
 
		$pdata = $this->postDataCondition($this->request->getData(), false);
		
		// Remove query limit for all records
		if($pdata['condition']['limit'] == -1){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']);
		} // END
		
//print_r($pdata);exit;
		$query = $this->setFilterQuery($formdata, $pdata, $processingstatus);
//echo $query;exit;
		$recordsTotal = $this->FilesShiptoCountyData->getQueryCountResult($query, 'count');
        $data =  $this->FilesShiptoCountyData->getQueryCountResult($query);

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
			array_shift($this->columns_alise); 
			unset($this->columns_alise['Actions']);
			$this->columns_alise["SrNo"] = "fmd.Id";
			$this->columns_alise["recId"] = "fsad.Id";
			$this->columns_alise["DocumentTitle"] = "dtm.Title";
		}else{
			// generate sheet call
			$this->columns_alise = []; 
			$this->columns_alise["recId"] = "fsad.Id";
			$this->columns_alise["SrNo"] = "fmd.Id";
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

    private function getCustomParshingData(array $data){
       
		$count = 1; 
        foreach ($data as $key => $value) {
			 
			if($this->pageType != 'MSTP'|| ($this->user_Gateway)){ // manage custome
				$checkboxdisabled = (($value["lock_status"] == 1) ? 'disabled' : '');
				$value['Checkbox'] = '<input type="checkbox" id="checkAll[]" '.$checkboxdisabled.' name="checkAll[]" value="'.$key.'_'.$value["recId"].'" class="checkSingle"/>
				<input type="hidden" id="fmdId_'.$key.'" name="fmdId[]" value="'.$value["SrNo"].'"/>
				<input type="hidden" id="docTypeId_'.$key.'" name="docTypeId[]" value="'.$value["TransactionType"].'" />
				<input type="hidden" id="LRSNum_'.$key.'" value="'.$value["FileNo"].'_'.$value["TransactionType"].'" />';
			}else{ $value['Checkbox'] = $count; }

			// prifix not use in  hideViewButton == 2
			if($this->user_Gateway){
				$value['Actions'] = $this->CustomPagination->getUserActionButtons($this->name,$value,['recId','SrNo','TransactionType'], 'common');
			}else{

				if(!empty($value["shipLabelURL"]) && $value["shipLabelURL"] !='') { //hide edit link
					$value['Actions'] = $this->CustomPagination->getActionButtons($this->name,$value,['SrNo','County','recId','TransactionType'],$prefix = '', $hideViewButton = 5); 
				} else {
					$value['Actions'] = $this->CustomPagination->getActionButtons($this->name,$value,['SrNo','County','recId','TransactionType'],$prefix = '', $hideViewButton = 2); 
				}
				
			}
			if(!empty($value["shipLabelURL"]) && $value["shipLabelURL"] !='') {
				$value['shipLabelURL'] = '<a href="'.$value["shipLabelURL"].'" target="_blank">Shipping Label</a>'; 
			}

			$value['PartnerFileNumber'] = $value['PartnerFileNumber'] . ((!empty($value['ClientCompName'])) ? ' ( '.$value['ClientCompName'].' )': '' );
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
 
			$count++;
        }

        unset($data['recId']);
        return $data;
    }

    private function setFilterQuery($requestFormdata=[], $pdata=[], $processingstatus='dns', $selectedIds=null){
		 
		$whereCondition = [];
		 
		if(!empty($pdata['condition']['search']['AccountingStartDate']) || !empty($pdata['condition']['search']['AccountingEndDate'])) { 
			$whereCondition = ['fad.AccountingProcessingDate IS NOT' => NULL];
		}
		// complete records
		if(isset($processingstatus)){ 
			if($processingstatus == 'dns'){
				$whereCondition = ['OR' => ['fsad.ShippingProcessingDate IS' => NULL, 'fsad.ShippingProcessingDate' => '0000-00-00']]; 
			}
			if($processingstatus == 'ds'){
				$whereCondition =  ['OR' => ['fsad.ShippingProcessingDate IS NOT' => NULL, 'fsad.ShippingProcessingDate !=' => '0000-00-00']];  
			} 
		}

		// for records sheet of only selected records
		if(!is_null($selectedIds)){
			$selectedIds = $this->CustomPagination->setOnlyRecordIds($selectedIds, $requestFormdata);
			$whereCondition = array_merge($whereCondition, ['fsad.RecId IN' => $selectedIds['fmd'], 'fsad.TransactionType IN' => $selectedIds['doc']]);
		}
		
		// set condtion for partner view
		$whereCondition = $this->addCompanyToQuery($whereCondition);
		
		$query = $this->FilesMainData->shipCountyQuery($whereCondition, $pdata['condition']);
		$query = $this->FilesMainData->dateFieldsAddtoQuery($query, $requestFormdata,['files_accounting_data'.ARCHIVE_PREFIX,'files_qc_data'.ARCHIVE_PREFIX, 'files_shiptoCounty_data'.ARCHIVE_PREFIX]);
		 
		return $query;
	}

    private function setExtraFields(){
  
	   if($this->pageType=="index" || $this->pageType =='MSTP'){
		    
			$this->columns_alise["CarrierName"] = "fsad.CarrierName";
			$this->columns_alise["CarrierTrackingNo"] = "fsad.CarrierTrackingNo";
			if($this->pageType !='MSTP'){
				$this->columns_alise["Actions"] = ""; 
			}
			
			if($this->user_Gateway){
				// remove and rearrange order for number key array
				unset($this->columns_alise["FileNo"]);
				array_splice($this->columnsorder,1,1); // 1-> key number, 1->count
				$this->columns_alise["Actions"] = ""; 
			}	 
 
			$this->columnsorder[] = "fsad.CarrierName";
			$this->columnsorder[] = "fsad.CarrierTrackingNo";
	   }
	}

	private function _processShippingData(array $postData, $sent2recording=false){

		$data= [];$return = false;
		if(isset($postData['checkAll'])){
			$cntyArr = []; 
			foreach($postData['checkAll'] as $checkValue){
				if(!empty($checkValue)){
					$postkeys = explode('_',$checkValue);
					$keyVal = $postkeys[0];
					$recordVal = $postkeys[1];

					$filesMainId = $postData['fmdId'][$keyVal];
					$documentTypeId = $postData['docTypeId'][$keyVal];
					
					if($sent2recording == false){						
						if(isset($postData['CarrierName']) && !empty($postData['CarrierName'])) {
							$data['CarrierName'] =  $postData['CarrierName'];
						}
					
						if(isset($postData['CarrierTrackingNo']) && !empty($postData['CarrierTrackingNo'])) {
							$data['CarrierTrackingNo'] =  $postData['CarrierTrackingNo'];
						}
					}
					// send to recording 
					if($sent2recording){
						$data['ShippingProcessingDate'] = Date("Y-m-d");
						$data['ShippingProcessingTime'] = Date("H:i:s");
					}

					$return = $this->_addUpdateShippingDetails($filesMainId, $documentTypeId, $data, $recordVal);
				}
			} // foreach
		}
		if($return){
			if($sent2recording == false){
				$this->Flash->success(__('Shipping data has been saved.'));
			}
		}else{
			$this->Flash->error(__('Shipping data could not be saved. Please, try again.'));
		}

	}

    private function _processShippingDataAuto(array $postData, $sent2recording=false){

		$data= [];$return = false;
		if(isset($postData['checkAll'])){
			$cntyArr = []; $fedExErr = false; $errLRSNo ='';
			foreach($postData['checkAll'] as $checkValue){
				if(!empty($checkValue)){
					$postkeys = explode('_',$checkValue);
					$keyVal = $postkeys[0];
					$recordVal = $postkeys[1];

					$filesMainId = $postData['fmdId'][$keyVal];
					$documentTypeId = $postData['docTypeId'][$keyVal];
					
					if($sent2recording == false){
						$data['CarrierName'] =  'FED EX';
						
						$getFmdDetails = $this->FilesMainData->getFieldsByfileId($filesMainId);

						$keyCnty = $getFmdDetails['State']."#".$getFmdDetails['County'];
						
						if (array_key_exists($keyCnty,$cntyArr)) {
							
							$temp = explode("##",$cntyArr[$keyCnty]);
							$data['CarrierTrackingNo'] = $temp[0];
							$data['shipLabelURL'] = $temp[1]; 

						} else {
							$fedExDetails = $this->getFedExDetails($getFmdDetails['State'],$getFmdDetails['County']);
							if(isset($fedExDetails["error"])) {
								$fedExErr = true;
								$errLRSNo .= $getFmdDetails['NATFileNumber'].", ";
							} else {
								$data['CarrierTrackingNo'] = $fedExDetails['trackingNumber'];
								$data['shipLabelURL'] = $fedExDetails['labelUrl']; 
							}
							 
							$valCnty = $fedExDetails['trackingNumber']."##".$fedExDetails['labelUrl'];
							$cntyArr[$keyCnty] = $valCnty;
						}
					}
					// send to recording 
					if($sent2recording){
						$data['ShippingProcessingDate'] = Date("Y-m-d");
						$data['ShippingProcessingTime'] = Date("H:i:s");
					}

					if($fedExErr == false) {
						$return = $this->_addUpdateShippingDetails($filesMainId, $documentTypeId, $data, $recordVal);
					} 
				}
			} // foreach
		}
		if($return){
			if($sent2recording == false){
				$this->Flash->success(__('Shipping data has been saved.'));
			}			
		}/* else{
			$this->Flash->error(__('Shipping data could not be saved. Please, try again.'));
		} */
		if($fedExErr == true) {
			$this->Flash->error(__('Shipping Label not generated for '.rtrim($errLRSNo, ', ').'. <b>Error:</b> '.$fedExDetails["error"]), ['escape'=>false]);
		}
	}

    private function _addUpdateShippingDetails($filesMainId, $documentTypeId, array $data, $checkValue=''){
		$return = FALSE;
		$publicType = 'P';
		$section = 'SH';
				
		$data['RecId'] = $filesMainId;
		$data['TransactionType'] =$documentTypeId;
		$data['UserId'] = $this->currentUser->user_id;
		$data['AddingDate'] = date("Y-m-d");

		if(isset($data['publicData'])){
			$postRegarding = $data['publicData']['regarding'];
			$publicType = $data['publicData']['publicType'];
			unset($data['publicData']);
		}
		 
		//data insert/update for QC rejection carrier name & number
		if(empty($checkValue)){
			$return = $this->FilesShiptoCountyData->saveShippingData($data);
			$Regarding = (isset($postRegarding)) ? $postRegarding: 'Record Added';
		}else{
		
			$return = $this->FilesShiptoCountyData->updateShippingData($checkValue, $data);
     		$Regarding = (isset($postRegarding)) ? $postRegarding: 'Record Updated';
		}
		//echo "<pre>";print_r($return);exit;
		if($return){
			
			// only for fedEx section public note changes COUSTOM CHANGE
			if(isset($data['FedexShipping']) && ($data['FedexShipping'] == 1)){
				$section = 'FED';
			}
			
			if(!empty($data['CarrierName'])) {
				 
				$Regarding .= " <b>(Carrier Name: ".$data['CarrierName'].", Carrier Tracking No: ".$data['CarrierTrackingNo'];
				 
				if(!empty($data['shipLabelURL']))
					$Regarding .= ", Ship Label URL: ".$data['shipLabelURL'];

				if(!empty($data['ShippingProcessingDate'])) 
					$Regarding .= ", Shipping Processing Date: ".$data['ShippingProcessingDate'];
				if(!empty($data['ShippingProcessingTime'])) 
					$Regarding .= ", Shipping Processing Time: ".$data['ShippingProcessingTime'];

				$Regarding .= ")</b>"; 
			}
			// add public notes 
			$this->PublicNotes->insertNewPublicNotes($filesMainId, $documentTypeId, $this->currentUser->user_id, $Regarding, 'Fsd', true, $section);
		}

		return $return;
		
	}


	private function getFedExDetails($State, $County){
 
		$token = $this->getToken();
		if(isset($token['error'])) {
			return $shipLabelDts = array("error"=>$token['error']);
		} else {
			$shipLabelDts = $this->generateShipLabel($token, $State, $County); 
			if(isset($shipLabelDts['error'])) { 
				return $shipLabelDts = array("error"=>$shipLabelDts['error']);
			} else { 
				return $shipLabelDts;
			}
		} 
		
	}


	private function getToken() {

		$body = 'grant_type=client_credentials&client_id=l764bcb84bd42f4319a5c390efcdddeeeb&client_secret=8c0221b401624b9bb5b3ad5e67365e1b';
		$url = 'https://apis-sandbox.fedex.com/oauth/token';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			$error_msg = curl_error($ch);
			$result = array("error"=>$error_msg);
		} else {
			$json = json_decode($response, true);
			$result = $json["access_token"];
		} 
		curl_close($ch); 
		return $result;
		
	}

	private function generateShipLabel($token, $State,$County) {


		$shippingData = $this->FedexShippingSetting->getShippingData();

		$fedExDtls = $this->CountyMst->fedExDetailByStateCounty($State,$County);
		$CountyDetailsCount = ((is_array($fedExDtls) || $fedExDtls instanceof Countable) ? count($fedExDtls) : 0);
		if($CountyDetailsCount >= 1 && !empty($fedExDtls['fedex_phone_number'])) {

			$data = array(
				"labelResponseOptions"=> "URL_ONLY",
				"requestedShipment"=> array(
					"shipper"=> array(
						"contact"=> array(
							"personName"=> $shippingData['s_name'],
							"phoneNumber"=> $shippingData['s_number'],
							"companyName"=> $shippingData['s_company_name']
						),
						"address"=> array(
							"streetLines"=> [
								$shippingData['s_address']
							],
							"City"=> $shippingData['s_City'],
							"StateOrProvinceCode"=> $shippingData['s_State'],
							"postalCode"=> $shippingData['s_zip'],
							"countryCode"=> $shippingData['s_country']
						)
					),
					"recipients"=> [
						array(
							"contact"=> array(
							"personName"=> $fedExDtls['fedex_person_name'],
							"phoneNumber"=>$fedExDtls['fedex_phone_number'],
							"companyName"=> $fedExDtls['fedex_company_name'],
							),
							"address"=> array(
							"streetLines"=> [
								$fedExDtls['fedex_address_1'],
								$fedExDtls['fedex_address_2']
							],
							"City"=> $fedExDtls['fedex_City'],
							"StateOrProvinceCode"=> $fedExDtls['fedex_State'],
							"postalCode"=> $fedExDtls['fedex_postal'],
							"countryCode"=> $fedExDtls['fedex_country_code']
							)
						)
					],
					"shipDatestamp"=> date("Y-m-d"),
					"serviceType"=> "STANDARD_OVERNIGHT",
					"packagingType"=> "FEDEX_ENVELOPE",
					"pickupType"=> "USE_SCHEDULED_PICKUP",
					"blockInsightVisibility"=> false,
					"shippingChargesPayment"=> array(
						"paymentType"=> "SENDER"
					),
					"labelSpecification"=> array(
						"imageType"=> "PDF", //PNG
						"labelStockType"=> "PAPER_85X11_TOP_HALF_LABEL" //PAPER_4X6
					), 
					"requestedPackageLineItems"=> [
						array(
							"weight"=> array(
							"value"=> $shippingData['s_fedexWeight'],
							"units"=> $shippingData['s_fedexWeight_unit']
							) 
						)
					]
				),
				"accountNumber"=> array(
					"value"=> "740561073"
				)
			);
			
			$post_data = json_encode($data); 
			$url = 'https://apis-sandbox.fedex.com/ship/v1/shipments';
			
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'X-locale: en_US',
			'Authorization: Bearer ' . $token));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$responseShip = curl_exec($ch);
			 
			if (curl_errno($ch)) {
				$error_msg = curl_error($ch);//print_r($error_msg);exit;
				$result = array("error"=>$error_msg);
			} else {
				$jsonShip = json_decode($responseShip, true); //print_r($jsonShip);exit;
				if(!empty($jsonShip)) {
					$result = array('trackingNumber' => $jsonShip['output']['transactionShipments'][0]['pieceResponses'][0]['trackingNumber'], 'labelUrl' => $jsonShip['output']['transactionShipments'][0]['pieceResponses'][0]['packageDocuments'][0]['url']);
				} else {
					$result = array("error"=>"Something went wrong, please check and try again.");
				}					
			} 
			curl_close($ch); 
			return $result;
		} else {
			return array("error"=>"Shipping details are missing under County.");
		} 
	}


	/**
     * Edit method
     *
     * @param string|null $id Files ShiptoCounty Data id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$recordMainId = $this->request->getParam('fmd');
		$doctype = $this->request->getParam('doctype');
		$section = $this->request->getParam('section');
		
		if(empty($recordMainId) || empty($doctype)){
			return $this->redirect(['action' => 'index']);exit;
		}
		
        if ($this->request->is(['patch', 'post', 'put']))
		{
			$data= [];$return = false;
			$postData = $this->request->getData();
			
			$filesMainId = $postData['fmdId'];
			$documentTypeId = $postData['docTypeId'];
			$shippingId =  $postData['shippingId'];
			
			if(isset($postData['CarrierName']) && !empty($postData['CarrierName'])) {
				$data['CarrierName'] =  $postData['CarrierName'];
			}
			
			if(isset($postData['CarrierTrackingNo']) && !empty($postData['CarrierTrackingNo'])) {
				$data['CarrierTrackingNo'] =  $postData['CarrierTrackingNo'];
			}
 
			if(isset($postData['ShippingProcessingDate'])) {
				$data['ShippingProcessingDate'] = (!empty($postData['ShippingProcessingDate'])) ? date("Y-m-d", strtotime($postData['ShippingProcessingDate'])) : date('Y-m-d');
				$data['ShippingProcessingTime'] = date("H:i:s");
			}
			 
			$data['publicData']['publicType'] = "I";
			$data['publicData']['regarding'] = $postData['Regarding'];
			
			$return = $this->_addUpdateShippingDetails($filesMainId, $documentTypeId, $data, $shippingId);

			if($return){
				$this->Flash->success(__('Shipping data has been saved.'));
				 
				if(isset($section) && ($section == 'complete')){
					return $this->redirect([
						'controller' => 'PublicNotes',
						'action' => 'viewComplete',$recordMainId,$doctype
					]);
				}else{ 
					return $this->redirect(['action' => 'index']);
				}
				 
			}else{
				$this->Flash->error(__('Shipping data could not be saved. Please, try again.'));
			}

        }
				
		$filesMainData = $this->FilesMainData->searchMainDataForAll($recordMainId);
		if(empty($filesMainData)){
			$this->Flash->error(__('Please select correct record.'));
			return $this->redirect(['action' => 'index']);exit;
		}
		
		$filesShippingData = $this->FilesShiptoCountyData->getS2CEditData($recordMainId,$doctype);

		$documentData = $this->DocumentTypeMst->get($doctype);
		$documentDataList= [$documentData['Id']=>$documentData['Title']];
		
		$partnerMapField = $this->CompanyFieldsMap->partnerMapFields($filesMainData['company_id'],1);

		$pageTitle = 'Shipping info Entry For <u>'.$filesMainData['PartnerFileNumber']."</u>";
		$this->set(compact('pageTitle'));
		
		$this->set('section', $section);
        $this->set(compact('filesShippingData', 'filesMainData', 'documentData', 'documentDataList','partnerMapField'));
        $this->set('_serialize', ['filesShippingData']);

    }


	public function shippingManagementData(array $postData=[], $isWhere='MSTP'){
		
		$queryData = $this->request->getQuery();
		
		if(isset($queryData) && !empty($queryData) && empty($postData)){

			$this->autoRender = false;
			$postData = $queryData;
			$getLimit = explode('-',$postData['limit']);
			unset($postData['limit']);
			
			$isWhere = $postData['isWhere']; // NP - P - RJ
			unset($postData['isWhere']);
		}
		if(isset($postData['generateSheetBtn'])){ unset($postData['generateSheetBtn']); }
		
		// get unique comapnyid from post records
		$companyId = $this->setCompanyId($postData);
		
		//===================== generete csv file data & name to export data====================//	
		
		$pdata = $this->postDataCondition(['formdata'=>$postData,'draw' => 1,'order'=>null], true);

		$processing = (empty($postData['ShippingStatus'])) ? 'ds' : $postData['ShippingStatus']; //ds;
	
		if(isset($postData['checkAll']) && !empty($postData['checkAll'])){
			$selectedIds = $postData['checkAll'];
			$query = $this->setFilterQuery($postData, $pdata, $processing, $selectedIds);
		}else{
			$query = $this->setFilterQuery($postData, $pdata, $processing);
		}
		  
		$callType = 'form';
		$limitPrifix = '';
 
		if(!empty($queryData) && is_array($getLimit)){ 
			$limitPrifix = "_".($getLimit[0]+1)."-".($getLimit[0] + $getLimit[1]);

			$callType = 'link';  
			$query = $query->limit($getLimit[1])->offset($getLimit[0]);
		}
		
		$resultQuery = $this->FilesShiptoCountyData->generateQuery($query);
		
		$countRows = 0; 
		if($callType == 'form'){
			$countRows = $this->FilesShiptoCountyData->getQueryCountResult($resultQuery['query'], 'count');
		}
		// add csvNamePrifix to result array

		if($countRows <= ROWLIMIT){
			$resultQuery['companyId'] = $companyId;
			$resultQuery['limitPrifix'] = $limitPrifix;
			// generate CSV sheet to download
			$this->generateCsvSheet($resultQuery, $callType);
			
		}else{
			// generate CSV link to download call from component 
			$postData['isWhere'] = $isWhere;
			$pagelink = Router::url(['controller'=>$this->name,'action'=>'shippingManagementData', '?'=>$postData]);

			$pdfDownloadLinks = $this->CustomPagination->generateCsvLink($countRows,$pagelink);
			if(!empty($pdfDownloadLinks)){
				$this->set('pdfDownloadLinks',$pdfDownloadLinks);
				$this->Flash->success(__('Shipping records links listed.'));
			}else{
				$this->Flash->error(__('Records not found.'));
			}
		}

	}
 
	private function generateCsvSheet($resultQuery=[], $callType = 'form'){
		$csvFileName ='';
		
		$skipJoin = ['files_accounting_data'.ARCHIVE_PREFIX, 'files_qc_data'.ARCHIVE_PREFIX, 'files_shiptoCounty_data'.ARCHIVE_PREFIX, 'files_checkin_data'.ARCHIVE_PREFIX];
		 
		$partnerMapData = $this->_getpartnerMapData($resultQuery['companyId']);
		 
		$csvNamePrifix = $partnerMapData['csvNamePrifix'].$resultQuery['limitPrifix'];

		$param  = ['partnerMapFields'=>$partnerMapData['partnerMapFields'], 'skipJoin'=>$skipJoin, 'onlyQuery'=>false];

		// behaviour call for adding extra fields for CSV sheet
		$resultQuery = $this->FilesShiptoCountyData->generateQuery($resultQuery['query'], $param);
		 
		$resultRecord = $this->FilesShiptoCountyData->getQueryCountResult($resultQuery['query']);
		 
		$listRecord = $this->FilesShiptoCountyData->setListRecords($resultRecord, $resultQuery['headerParams']);
		  
		if(array_key_exists(0,$listRecord))
		{	
			if($callType == 'link'){
				$this->downloadCsv($listRecord, array_keys($resultQuery['headerParams']), $csvNamePrifix);
				//$this->sampleExport($csvFileName,'export');
			} else {
				$csvFileName = $this->CustomPagination->recordExport($listRecord, array_keys($resultQuery['headerParams']), $csvNamePrifix, 'export');
				$this->set('csvFileName', $csvFileName);
			} 
		}else{
			$this->Flash->error(__('Records not found.'));
		}

	}

	private function _getpartnerMapData($companyId){
		
		$partnerMapData = $this->FilesMainData->partnerExportFields($companyId,'cef_fieldid4SC','s2csheet');
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
     * @param string|null $id Files ShiptoCounty Data id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$pageTitle = 'Shipping Details';
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
		
		$filesShippingData = $this->FilesShiptoCountyData->getS2CEditData($recordMainId,$doctype);
		
		$documentData = $this->DocumentTypeMst->get($doctype);
		$documentDataList= [$documentData['Id']=>$documentData['Title']];
		
		$this->loadModel("CompanyFieldsMap");
		$partnerMapField = $this->CompanyFieldsMap->partnerMapFields($filesMainData['company_id'],1);

        $this->set(compact('filesShippingData', 'filesMainData', 'documentData', 'documentDataList','partnerMapField'));
        $this->set('_serialize', ['filesShippingData']);
    }


	public function generateShippingSheet(){
 
		$pageTitle = 'Generate Shipping CSV Sheet';
		$this->set(compact('pageTitle'));
		$ShipStartDate = $ShipEndDate = '';
		$FilesShiptoCountyData = $this->FilesShiptoCountyData->newEmptyEntity(); 
		
		if ($this->request->is(['patch', 'post', 'put'])) 
		{
			$generateSheetBtn = $this->request->getData('generateSheetBtn');
			$ShipStartDate = $this->request->getData('ShipStartDate');
			$ShipEndDate = $this->request->getData('ShipEndDate');
			if(isset($generateSheetBtn)){
				$postData = $this->request->getData();
				$companyId = $postData['company_id'];
 
				$chkStartDate = $this->validateDate($ShipStartDate); 
				$chkEndDate = $this->validateDate($ShipEndDate); 
				
				if($chkStartDate == 1 && $chkEndDate == 1) {
					if(!empty($companyId)){
						$this->shippingManagementData($this->request->getData(), 'ShippingSheet');
					}else{
						$this->Flash->error(__('Please select partner.'));
					}
				} else {
					$this->Flash->error(__('Please enter proper From Date / To Date.'));
				}
 
			}
		}
		
		$this->set('ShipStartDate',$ShipStartDate);
		$this->set('ShipEndDate',$ShipEndDate);
		
		$companyMsts = $this->CompanyMst->companyListArray();
		
        $this->set(compact('FilesShiptoCountyData', 'companyMsts'));
        $this->set('_serialize', ['FilesShiptoCountyData']);
	}
}