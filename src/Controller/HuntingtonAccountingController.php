<?php
/********************
 * csv upload for check cleared
 * 
 * API call from client side
 **************************** */
declare(strict_types=1); 
namespace App\Controller;
//use Cake\View\JsonView;
//use Cake\Http\Middleware\BodyParserMiddleware;
class HuntingtonAccountingController extends AppController 
{ 
    public function initialize(): void
	{ 
		parent::initialize(); 
		$this->loadModel("FilesMainData"); 
		$this->loadModel("FilesCheckinData");  
		$this->loadModel('PublicNotes'); 
        $this->loadModel("FilesAccountingData");
		$this->loadModel("CompanyMst");
	}

    public function beforeFilter(\Cake\Event\EventInterface $event)
	{
		parent::beforeFilter($event);
		$this->Authentication->addUnauthenticatedActions(['apiCheckClear']);
		$this->loginAccess();
	}
  

	//  upload Huntington to LRS 

    public $cols;   
	public $CSVFields = array('documentname','checkamount','checkcleared', 'processingdate');	
	public $CSVFieldsAcc = array('checkamount','checkcleared', 'processingdate');	
	public function index(){
		$updstr = "";
        $insstr = "";
		$insstracc = "";  
		$updstracc = "";
		$errorArr = $errrowsCFN = $fwViewData = [];
		 
		// set page title
		$pageTitle = 'Huntington Check Cleared Data';
		$this->set(compact('pageTitle'));  

		$FilesAccountingData = $this->FilesAccountingData->newEmptyEntity(); 
	
		$isFileUpload = false;
		
		if($this->request->is(['patch', 'post', 'put'])){
	
			// insert update records on upload csv
			if(($this->request->getData('saveBtn') !== null)) {
	
				$isFileUpload   = true;
			 
				$csvRecordsFile = $this->request->getData('upload_records');
				// upload csv file and add to table

				$csvRecordsFilename = $csvRecordsFile->getClientFilename();
				$GetFileExtension = $csvRecordsFile->getClientMediaType();
	
				 $GetFileExtension = substr($csvRecordsFilename,-3);
				 
				if((strtolower($GetFileExtension) != 'csv') || ($csvRecordsFile->getError() != '0'))
				{  
					$errorArr['errorArr'][] = "Please upload cvs file only !!";
					goto errordisplay; 
				}else{
	                // Code to upload the file 
                    $date = date('YmdHis');
                    $destination =  WWW_ROOT.'files/huntington/';
                    $filename = "HuntingtonRecordsImport_" . $date .".csv" ; 

                    $destination .= $filename;
  
					// upload CSV on destination
					$csvRecordsFile->moveTo($destination); 
					if ($csvRecordsFile->getError() == 0)
					{ 
						$csvFile = $destination;
						/***** Start Include file code *********/
						
						// check supported content type
						//if(mime_content_type($csvFile) != 'text/plain'){ 
						if($_FILES['upload_records']['size'] == 0){  
							$errorArr['errorArr'][] = "CSV file content type not supported.";
							goto errordisplay;
						}
	
						// data manipulate from csv import file code
						$csvFile = str_replace(["/","\\"],'/',$csvFile);
						
						if (!$myFile = @fopen(stripslashes($csvFile), "r")){  
							$errorArr['errorArr'][] = "Can\'t open CSV file. it has been moved/deleted";
							goto errordisplay;
						}else{ 
							// read csv file data for first row and upload
							$this->cols = fgetcsv($myFile);  
 
                            $trncol = $recordingdateCol =''; 
                            foreach($this->cols as $id=>$value){
                                if(!empty($value)){ 
                                     
                                    if(!in_array(strtolower(str_replace(" ","", $value)), $this->CSVFields)){ 
                                        $errorArr['isNotMatch'][] = $value; 
                                    }
                        
                                    if(strtolower(str_replace(" ","", $value)) == "documentname"){ 
                                        $documentnameCol = $id; 
                                    } 
                                    if(strtolower(str_replace(" ","", $value)) == "checkamount"){
                                        $checkamountCol = $id;
                                    }
									if(strtolower(str_replace(" ","", $value)) == "checkcleared"){
                                        $checkclearedCol = $id;
                                    }
                                    if(strtolower(str_replace(" ","", $value)) == "processingdate"){
                                        $processdateCol = $id;
                                    }
                                }else{ 
                                    $errorArr['errorArr'][] = "CSV file contain empty headers"; 
                                }
                            } 

                            if(!empty(array_filter($errorArr))){
                                goto errordisplay;
                            } 
							$countKK = 1;
						
							// read all file data
							while($rowData = fgetcsv($myFile)) 
							{
								//ignore empty Line from CSV(string) $rowData[0] != '0' and empty($rowData[0])
								if (empty(array_filter($rowData)))
								{
									continue;
								}
							 // insert / update data
								if(!empty(array_filter($rowData))) {
									 
									$PartnerFileNumber = $rowData[$documentnameCol]; 
									$tagreferenceno = $this->FilesMainData->CheckPartnerFileNumber($PartnerFileNumber);
                                   
									if(!empty($tagreferenceno) && $tagreferenceno['Id'] != "")
									{ 
										$checkInData = $this->FilesCheckinData->getCheckInDataCSC($tagreferenceno['Id']);
 
                                        $countCheckin = count($checkInData);
										if($countCheckin > 1){ 
                                            // check multiple document type and sent error code ??
                                        } // if > 1
                                        elseif($countCheckin  == 1){ 
                                            
                                            if($checkInData[0]["DocumentReceived"] != "Y"){ 
                                               
                                                // update files_checkin_data set DocumentReceived = 'Y'  
                                                $this->FilesCheckinData->updateDocumentStatus('Y', $checkInData[0]['Id']);
                                                // insert public notes
                                                $this->addPublicNotes($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], 'Record document status update from upload Huntington csv', 'Fcd');
                                            } 
                                            // select accounting data
                                            $accData = $this->FilesAccountingData->getfilesAccountingData($checkInData[0]['RecId'], $checkInData[0]['TransactionType']); 
                                             
                                            if(!empty($accData)){ 
												// update accounting details for check cleared and process date
                                                
                                                $returnAccounting = $this->accountingUpdate($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], $accData, $rowData);
                                                $updstracc .= $returnAccounting; 
													  
											}else{
                                                // accounting insert
                                                $returnAcc = $this->accountingInsert($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], $rowData);
                                                $insstracc .= $returnAcc;
                                            }
										}else{
                                            //record not found in Check In
                                            $errrowsCFN[] = $rowData;
                                        }  
                                    } else {     
                                        $errrowsCFN[] = $rowData;
                                    }	 
								}
								 
								$countKK++;
							} // while 
						}
						fclose($myFile); 
	
					} else {
						$errorArr['errorArr'][] = "Some error occur while uploading file. Please try again !!";
						goto errordisplay; 
					}
				}   

			} // end if post savebtn uload csv file  
			$fwViewData['colstext'] = implode(",",$this->cols); 
            $fwViewData['errrowsCFN'] = $this->setErrorTable($errrowsCFN);
            
            if($insstracc != ""){
                $fwViewData['insstracc'] = $this->setRecordTable($insstracc, 'CSVFields'); 
            }
         
            if($updstracc != ""){
                $fwViewData['updstracc'] = $this->setRecordTable($updstracc, 'CSVFields');   
            } 

		} // if post submit
	 
		// come from GOTO function 
		errordisplay:{
			if(!empty(array_filter($errorArr))){  
				$this->flashErrorMsg($errorArr, $this->CSVFields);
			}
		}
		 // company list 
		//$companies = $this->CompanyMst->companyListArray();
 
		$this->set(compact('FilesAccountingData', 'fwViewData')); //,'errorViewData','successArr','errorArr'
		$this->set('_serialize', ['FilesAccountingData']); 
	}

	public function setErrorTable($errorData){ 
       
        $fwViewText = "";
        if(is_array($errorData)){
            if(is_countable($errorData) && sizeof($errorData)>0){
            
                $fwViewText = "<table id='datatable_example' class='table dataTable order-column stripe table-striped table-bordered no-footer'><thead><tr><th class='headercelllisting'><b>".implode("</b></th><th class='headercelllisting'><b>",$this->cols)."</b></th></tr></thead>";
                $fwViewText .= "</tbody>";
                foreach($errorData as $errorKey){  
                    $fwViewText .= "<tr><td>".implode("</td><td>",$errorKey)."</td></tr>";
                }
                $fwViewText .= "</tbody></table>";
            
            }
        }else{ 
            $fwViewText = "<table id='form-table' style='width:98%;margin:0 auto'><tr><td class='headercelllisting'><b>".implode("</b></td><td class='headercelllisting'><b>", $this->cols)."</b></td></tr>".$errorData."</table>";
        }     
        
        return $fwViewText;
    }
	
    public function setRecordTable($tdData, $sectionType){
		return "<table id='datatable_example' class='table dataTable order-column stripe table-striped table-bordered no-footer'><thead><tr><th class='headercelllisting'><b>".implode("</b></th><th class='headercelllisting'><b>", $this->$sectionType)."</b></th></tr></thead><tbody>".$tdData."</tbody></table>";
	} 

	public function accountingInsert($RecId, $TransactionType, $data){
        $updsqlfieldsacc = array();  
        $updsqlfieldsacc["RecId"] = $RecId; 
        $updsqlfieldsacc["TransactionType"] = $TransactionType;
        
        $insstrtdacc = $insstracc = "";  
        $recfees = 0;
        $tax = 0;
        $total = 0;
		$tableFld= ['1'=>'total_final_fees', '2'=>'check_cleared', '3'=>'AccountingProcessingDate'];
		foreach($this->CSVFields as $colid => $coltext){
			if(strtolower(str_replace(" ","", $coltext)) != "documentname"){
                //for accounting
                //print_r($coltext);
				if(in_array(strtolower(str_replace(" ","", $coltext)), $this->CSVFieldsAcc)){ 
					 
					if($coltext == 'checkcleared'){
						$updsqlfieldsacc[$tableFld[$colid]] = strtoupper($data[$colid]);  
				   } else {
						$updsqlfieldsacc[$tableFld[$colid]] = $data[$colid];  
				   }
				} 
			
			}	$insstrtdacc .= "<td>".$data[$colid]."</td>";
        }  
         
        $updsqlfieldsacc["UserId"] = $this->currentUser->user_id;  // for App user is admin id 1
        $updsqlfieldsacc["LastModified"] = date("Y-m-d");
		//echo ' insert ----- ';	pr($updsqlfieldsacc);exit;
        // insert accounting
		$this->FilesAccountingData->insertNewAccountData($updsqlfieldsacc);
		$insstracc .= "<tr>".$insstrtdacc."</tr>"; 
        // public notes for accounting
        $Regarding ="<b>Accounting csv Insert </b> upload Huntington";
        $this->addPublicNotes($RecId, $TransactionType, $Regarding, 'Fad');

        return $insstracc;
    }


	public function accountingUpdate($RecId, $TransactionType, $accData, $data){ 
 
		$updstrtdacc = $updstracc = ""; 
        $updsqlacc = array(); 
        $recfees = 0;
        $tax = 0;
        $total = 0; 
		$tableFld= ['1'=>'total_final_fees', '2'=>'check_cleared', '3'=>'AccountingProcessingDate'];
		foreach($this->CSVFields as $colid => $coltext){
			if(strtolower(str_replace(" ","", $coltext)) != "documentname"){
                //for accounting
                //print_r($coltext);
				if(in_array(strtolower(str_replace(" ","", $coltext)), $this->CSVFieldsAcc)){ 
					if($coltext == 'checkcleared'){
						 $updsqlacc[$tableFld[$colid]] = strtoupper($data[$colid]);  
					} else {
						 $updsqlacc[$tableFld[$colid]] = $data[$colid];  
					}
				} 
			}
			$updstrtdacc .= "<td>".$data[$colid]."</td>";
        }  
 
		$updsqlacc["AccountingProcessingTime"] = date('H:i:s'); 
		$updsqlacc["UserId"] = $this->currentUser->user_id;

      //  pr($updsqlacc);exit;
        // update accounting table 
        $this->FilesAccountingData->updateAccountDataCSC($accData['accountId'], $updsqlacc);
         
        $updstracc .= "<tr>".$updstrtdacc."</tr>";
 
        // insert public notes accounting
        $Regarding ="<b>Accounting data update from upload Huntington</b>";
 
        $this->addPublicNotes($RecId, $TransactionType, $Regarding, 'Fad');

        return $updstracc;
	}
 
    public function addPublicNotes($recId, $docType, $regardingtext, $section){
        $regarding = (empty($regardingtext)) ? 'Accounting Record Added': $regardingtext;
        $this->PublicNotes->insertNewPublicNotes($recId, $docType, $this->currentUser->user_id, $regarding, $section);
    }


  



	//*******API******* */ 

	


    /* public function viewClasses(): array
    {
        return [JsonView::class];
    }  */
   
	public function getallheaders() {
		$headers = [];
		foreach ($_SERVER as $name => $value) {
			if (substr($name, 0, 5) == 'HTTP_') {
				$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
			}
		}
		return $headers;
	}

	public function apache_request_headers() {
        $arh = array();
        $rx_http = '/\AHTTP_/';
        foreach($_SERVER as $key => $val) {
                if( preg_match($rx_http, $key) ) {
                        $arh_key = preg_replace($rx_http, '', $key);
                        $rx_matches = array();
                        // do some nasty string manipulations to restore the original letter case
                        // this should work in most cases
                        $rx_matches = explode('_', strtolower($arh_key));
                        if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
                                foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
                                $arh_key = implode('-', $rx_matches);
                        }
                        $arh[$arh_key] = $val;
                }
        }
        if(isset($_SERVER['CONTENT_TYPE'])) $arh['Content-Type'] = $_SERVER['CONTENT_TYPE'];
        if(isset($_SERVER['CONTENT_LENGTH'])) $arh['Content-Length'] = $_SERVER['CONTENT_LENGTH'];
        return( $arh );
	}
	
	/*******
	 * 
	 * URL :  http://WEBURL/api/checkclear.json
	 * Request: [{"documentname":"101-10064834", "processingdate":"2023-04-10", "checkamount":"1", "checkcleared":"Y"},...]
	 * Response: ['msg'=>'success', 'status'=>200, 'response'=>'']
	 * Response: ['msg'=>'error', 'status'=>0, 'response'=>'']
	 * 
	 */ 
    public function apiCheckClear()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post', 'put']);
/*         $getallheaders	= $this->getallheaders();
        $apheaders		= $this->apache_request_headers();
       $token = $_GET['token'];
pr($getallheaders); echo ' --- apheaders --- ';pr($token);  */
         $postData =  $this->request->getData();
        // POST WITH RAW DATA
        if(empty($postData)){$postData = json_decode(file_get_contents('php://input'), TRUE);}
		 
 	 
        if(!empty($postData)){
            $returnSuccess = $this->updateAccounting($postData);
            echo  json_encode(['msg'=>'success', 'status'=>200, 'response'=>$returnSuccess]);
        }else{
            echo  json_encode(['msg'=>'Error', 'status'=>0, 'response'=>'Data not posted.']);
        } 
		//$this->viewBuilder()->setOption('serialize', ['postData']); 
    }
 
    public function updateAccounting($postData){
  
        $insstracc =  $updstracc = $errrowsCFN = []; 

        $trncol = $recordingdateCol =''; 
        foreach($this->CSVFields as $id=>$value){
        
            if(strtolower(str_replace(" ","", $value)) == "documentname"){ 
                $documentnameCol = $value; //$id; 
            } 
            if(strtolower(str_replace(" ","", $value)) == "checkamount"){
                $checkamountCol = $value; //$id; 
            }
            if(strtolower(str_replace(" ","", $value)) == "checkcleared"){
                $checkclearedCol = $value; //$id; 
            }
            if(strtolower(str_replace(" ","", $value)) == "processingdate"){
                $processdateCol = $value; //$id; 
            }
        
        } 
 
        if(!empty($postData)){
            
            foreach($postData as $rowData) 
            { 
            // insert / update data
                if(!empty(array_filter($rowData))) { 

                    $PartnerFileNumber = $rowData[$documentnameCol]; 
                    $tagreferenceno = $this->FilesMainData->CheckPartnerFileNumber($PartnerFileNumber);
 
                    if(!empty($tagreferenceno) && $tagreferenceno['Id'] != "")
                    { 
                        $checkInData = $this->FilesCheckinData->getCheckInDataCSC($tagreferenceno['Id']);
    
                        $countCheckin = count($checkInData);
                        if($countCheckin > 1){ 
                            // check multiple document type and sent error code ??
                        } // if > 1
                        elseif($countCheckin  == 1){ 
                            if($checkInData[0]["DocumentReceived"] != "Y"){ 
                            
                                // update files_checkin_data set DocumentReceived = 'Y'  
                                $this->FilesCheckinData->updateDocumentStatus('Y', $checkInData[0]['Id']);
                                // insert public notes
                                $this->addPublicNotesApi($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], 'Record document status update from upload Huntington Api', 'Fcd');
                            } 
                            // select accounting data
                            $accData = $this->FilesAccountingData->getfilesAccountingData($checkInData[0]['RecId'], $checkInData[0]['TransactionType']); 
            
                            if(!empty($accData)){ 
                                // update accounting details for check cleared and process date
                            
                                $returnAccounting = $this->accountingUpdateApi($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], $accData, $rowData);
                                $updstracc[] = $returnAccounting; 
                                     
                            }else{
                                // accounting insert
                                $returnAcc = $this->accountingInsertApi($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], $rowData);
                                $insstracc[] = $returnAcc;
                            }
                        }else{
                            //record not found in Check In
                            $errrowsCFN[] = $rowData;
                        }  
                    } else {     
                        $errrowsCFN[] = $rowData;
                    }	 
                }
            } // foreach 
        }

        return ['updatedRecords'=>$updstracc, 'insertedRecords'=>$insstracc, 'errors'=>$errrowsCFN];
    }
       
	public function accountingInsertApi($RecId, $TransactionType, $data){
        $updsqlfieldsacc = array();  
        $updsqlfieldsacc["RecId"] = $RecId; 
        $updsqlfieldsacc["TransactionType"] = $TransactionType;
        
        $insstrtdacc = "";  
        $recfees = 0;
        $tax = 0;
        $total = 0;
		$tableFld= ['1'=>'total_final_fees', '2'=>'check_cleared', '3'=>'AccountingProcessingDate'];

		foreach($this->CSVFields as $colid => $coltext){
			if(strtolower(str_replace(" ","", $coltext)) != "documentname"){
                //for accounting 
				if(in_array(strtolower(str_replace(" ","", $coltext)), $this->CSVFieldsAcc)){  
					if($coltext == 'checkcleared'){
						$updsqlfieldsacc[$tableFld[$colid]] = strtoupper($data[$coltext]);  
					} else {
						$updsqlfieldsacc[$tableFld[$colid]] = $data[$coltext];  
					}
				}  
			}
        }  

        $insstrtdacc = (isset($data['documentname']) ? $data['documentname'] : "");

        $updsqlfieldsacc["UserId"] = 1; //default Admin ID 
        $updsqlfieldsacc["LastModified"] = date("Y-m-d");
		 
        // insert accounting
		$this->FilesAccountingData->insertNewAccountData($updsqlfieldsacc);
		 
        // public notes for accounting
        $Regarding ="<b>Accounting API Insert </b> upload Huntington";
        $this->addPublicNotesApi($RecId, $TransactionType, $Regarding, 'Fad');

        return $insstrtdacc;
    } 

	public function accountingUpdateApi($RecId, $TransactionType, $accData, $data){ 
 
		$updstrtdacc = ""; 
        $updsqlacc = array(); 
        $recfees = 0;
        $tax = 0;
        $total = 0; 
		$tableFld= ['1'=>'total_final_fees', '2'=>'check_cleared', '3'=>'AccountingProcessingDate'];
		foreach($this->CSVFields as $colid => $coltext){
			if(strtolower(str_replace(" ","", $coltext)) != "documentname"){
                //for accounting
           
				if(in_array(strtolower(str_replace(" ","", $coltext)), $this->CSVFieldsAcc)){ 
					if($coltext == 'checkcleared'){
						 $updsqlacc[$tableFld[$colid]] = strtoupper($data[$coltext]);  
					} else {
						 $updsqlacc[$tableFld[$colid]] = $data[$coltext];  
					} 
				}  
			} 
        }   

        $updstrtdacc = (isset($data['documentname']) ? $data['documentname'] : "");
           
		$updsqlacc["AccountingProcessingTime"] = date('H:i:s'); 
		$updsqlacc["UserId"] = 1; //default Admin ID  
        // update accounting table 
        $this->FilesAccountingData->updateAccountDataCSC($accData['accountId'], $updsqlacc); 
        // insert public notes accounting
        $Regarding ="<b>Accounting API update from her</b> upload Huntington";
 
        $this->addPublicNotesApi($RecId, $TransactionType, $Regarding, 'Fad');

        return $updstrtdacc;
	} 

	public function addPublicNotesApi($recId, $docType, $regardingtext, $section){
		$userId = 1; //admin default id
        $regarding = (empty($regardingtext)) ? 'Accounting Record Added': $regardingtext;
        $this->PublicNotes->insertNewPublicNotes($recId, $docType, $userId, $regarding, $section);
    }
}