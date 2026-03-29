<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SimplifileAccounting Controller
 *
 * @method \App\Model\Entity\SimplifileAccounting[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SimplifileAccountingController extends AppController
{
    public $cols;  public $accountingCol;  
    public $DBFieldsAcc = array();
    public $DBFieldsRec = array();
    public $DBFieldsShip = array();
    public $CSVFieldsAcc; 
    public $CSVFields;
    public $CSVFieldsRec;
    public $CSVFieldsShip;
    public $CSVFieldsOther;
    public $checkHeaderFld; 

    public function initialize(): void
	{
	   parent::initialize();
	   $this->loadModel("FilesMainData");
       $this->loadModel("FilesCheckinData");
       $this->loadModel('FilesQcData');
       $this->loadModel("FilesAccountingData");
       $this->loadModel("FilesShiptoCountyData");
       $this->loadModel("FilesRecordingData");  
	   $this->loadModel("DocumentTypeMst");
	   $this->loadModel('PublicNotes'); 
	}

	public function beforeFilter(\Cake\Event\EventInterface $event)
    {
		parent::beforeFilter($event); 
		$this->loginAccess();
	}
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        
        $fwViewData =[];
        $this->CSVFields = array('County', 'package', 'filenumber', 'document', 'type', 'pages', 'entry', 'recordingdate', 'bankdate', 'recordingfee', 'submissionfee', 'tax', 'accounting', 'carrier', 'carriertrackingnumber');
       // TransactionType, PackageName, DocumentName, State, CountyRecordingFee, Taxes, ServiceFee, Total, RecordingTime, InstrumentNumber, Book, Page, FileName, ProcessingDate
        $this->CSVFieldsAcc = array('County', 'File Number', 'Type', 'County Recording Fee', 'Taxes', 'Additionalfees', 'Total');
        $this->CSVFieldsRec = array('County', 'File Number', 'Document', 'Type', 'RecordingDate', 'RecordingTime', 'Instrument / DocumentNumber', 'Pages', 'Book', 'Page'); 
        $this->CSVFieldsShip = array('County', 'File Number', 'Type', 'Carrier', 'CarrierTrackingnumber');  
        //$this->CSVFieldsOther = array('County', 'package', 'filenumber', '*', 'accounting', 'sample database map');
  
        //Accounting 
        $this->DBFieldsAcc['Countyrecordingfee'] = 'CountyRecordingFee';
        $this->DBFieldsAcc['taxes'] = 'Taxes';
        $this->DBFieldsAcc['total'] = 'Total';
        $this->DBFieldsAcc['processingdate'] = 'AccountingProcessingDate';
  
        //Recording
        $this->DBFieldsRec['recordingdate'] = 'RecordingDate';
        $this->DBFieldsRec['recordingtime'] = 'RecordingTime';
        $this->DBFieldsRec['instrumentnumber'] = 'InstrumentNumber';
        $this->DBFieldsRec['book'] = 'Book';
        $this->DBFieldsRec['page'] = 'Page';
        $this->DBFieldsRec['filename'] = 'File';
        $this->DBFieldsRec['processingdate'] = 'RecordingProcessingDate';
        
        //Shipping
        $this->DBFieldsShip['carriername'] = 'CarrierName';
        $this->DBFieldsShip['carriertrackingno'] = 'CarrierTrackingNo';
        $this->DBFieldsShip['processingdate'] = 'ShippingProcessingDate';
         
        $delimiter = ",";
  
        $errorArr = [];
		$successArr = [];
        $isFileUpload = false;

        $errcols = array(); 
        $errrows = array();
        $errrowsCFN = array(); 
        $errrowsQC = array();
      //  $erecrows = array();
        $updstr = "";
        $insstr = "";
        $insstrqc = $insstracc = $insstrrec = $insstrship = "";  
        $updstrqc = $updstrship  = $updstracc = $updstrrec = "";
        $errorcntr = 0;   
        $multipleupdstr ="";
        $PartnerFileNumber = "";  

        $pageTitle = 'Simplifile Accounting / Recording Info Upload';
		$this->set(compact('pageTitle'));

        $FilesMainData = $this->FilesMainData->newEmptyEntity();

        if($this->request->is(['patch', 'post', 'put'])){
          
             
            if(($this->request->getData('btnProceed') !== null)) {
                $csvPostdata = $this->request->getData();
               
                $entryfieldissueinput = (isset($csvPostdata['entryfieldissueinput']) ? $csvPostdata['entryfieldissueinput'] : []);
                $recdtfieldissueinput = (isset($csvPostdata['recdtfieldissueinput']) ? $csvPostdata['recdtfieldissueinput'] : []); 
                $colstext = explode(",", $csvPostdata['colstext']);
                $this->cols = $colstext;
               
                if(!empty($csvPostdata['dt'])){
                    $this->checkHeaderCols();

                    foreach($csvPostdata['dt'] as $index => $items){
                        $records = array();
                        $records = explode("#sep#", $items);
 
                        $queryparams = array();
		                $queryparams = explode("#updsql#", $records[0]);
  
                        $field_value_array = array();
                        foreach($queryparams as $fields_value){ 
                            $field_value_array = explode("=", $fields_value); 
                            
                            if(isset($csvPostdata['recdtfieldissueinput'])) {
                                if($field_value_array[0] == 'RecordingDate') {
                                    $field_value_array[1] = $csvPostdata['recdtfieldissueinput'][$index];
                                }
                            } 
                            $csvrow[] = $field_value_array[1];  
                        }  
   
                                $csvdata[$this->checkHeaderFld['accountingCol']] = trim($csvrow[$this->checkHeaderFld['accountingCol']]);
                                $csvdata["rowdone"] = 0;
                                $finalarr = [];
                                if(!$csvdata["rowdone"] && $csvrow[$this->checkHeaderFld['trncol']] != ""){ 

                                    $csvdata = $csvrow;
                                    $csvdata["rowdone"] = 1;
                                    $csvdata["Countyrecordingfee"] = 0;
                                    $csvdata["taxes"] = 0;
                                    $csvdata["additionalfees"] = 0;

                                    $finalarr = $this->entryColFinal($csvdata[$this->checkHeaderFld['entryCol']]);
                                    
                                }
                                
                        //   echo ' ====finalarr===='; pr($finalarr);  
                                $csvdata["Countyrecordingfee"] += (isset($csvrow[$this->checkHeaderFld['recordingfeecol']]) ? floatval(preg_replace("/[^-0-9\.]/","",$csvrow[$this->checkHeaderFld['recordingfeecol']])) : 0);
                                if(isset($csvrow[$this->checkHeaderFld['taxcol']]))  $csvdata["taxes"] += (isset($csvrow[$this->checkHeaderFld['taxcol']]) ? floatval(preg_replace("/[^-0-9\.]/","",$csvrow[$this->checkHeaderFld['taxcol']])) : 0);
                                if($csvdata[$this->checkHeaderFld['accountingCol']] == "I"){
                                    $csvdata["additionalfees"] += (isset($csvrow[$this->checkHeaderFld['additionalfeescol']]) ? floatval(preg_replace("/[^-0-9\.]/","",$csvrow[$this->checkHeaderFld['additionalfeescol']])) : 0); 
                                }
                                
                                //Prepare recording fields
                                if(!empty($csvdata[$this->checkHeaderFld['documentCol']]) && !stripos($csvdata[$this->checkHeaderFld['documentCol']], ".pdf")){
                                    $csvdata[$this->checkHeaderFld['documentCol']] .= ".pdf";
                                }  

                                $recdatetime = (isset($csvdata[$this->checkHeaderFld['recordingdateCol']]) ? explode(" ", preg_replace("/[[:blank:]]+/"," ",$csvdata[$this->checkHeaderFld['recordingdateCol']])) : "");
                                $csvdata["RecordingDate"] = (isset($recdatetime[0])? $recdatetime[0] : "");
                                $csvdata["RecordingTime"] = (isset($recdatetime[1])? $recdatetime[1] : "");	
                                $csvdata["instrumentnumber"] = (isset($finalarr['I']) ? implode("", $finalarr['I']) : "");
                                $csvdata["book"] = (isset($finalarr['B']) ? implode("", $finalarr['B']) : "");
                                $csvdata["page"] =  (isset($finalarr['P']) ? implode("", $finalarr['P']) : "");
                    
                               $bankdatetime = (isset($csvdata[$this->checkHeaderFld['bankdateCol']]) ? explode(" ", preg_replace("/[[:blank:]]+/"," ",$csvdata[$this->checkHeaderFld['bankdateCol']])) : "");
                                $csvdata[$this->checkHeaderFld['bankdateCol']] = (!empty($bankdatetime[0]) ? date("Y-m-d",strtotime($bankdatetime[0])) : '');
                                $csvdata["processingtime"] = (!empty($bankdatetime[1]) ? date("H:i:s",strtotime($bankdatetime[1])) : ''); 
                        
                        $postData = $csvdata;
                        if(isset($postData[$this->checkHeaderFld['trncol']])){
                            $clifnoarr = explode(".", $postData[$this->checkHeaderFld['trncol']]);
                        }
                        // check record in accounting
                        $accData = $this->FilesAccountingData->getfilesAccountingData($records[2], $records[1]); 
                                   
                        if(!empty($accData)){
                           
                            $erarray = array("e-record", "erecord");
                            if($accData['RecId'] != ""){

                                 // qc insert update
                                 $qcReturn = $this->qcSaveUpdate($records[2], $records[1], $clifnoarr[0], $queryparams);
                                 $insstrqc .= $qcReturn['insstrqc'];
                                 $updstrqc .= $qcReturn['updstrqc'];  
                                 $errrowsQC = $qcReturn['errrowsQC']; 
                                 
                                 // update accounting
                                 $returnAccounting = $this->accountingUpdate($records[2], $records[1], $accData, $postData);
                                 $updstracc .= $returnAccounting;

                                // check for ship to County 
                                $returnShipping = $this->shippingSaveUpdate($records[2], $records[1], $postData);
                                $insstrship .= $returnShipping['insstrship'];
                                $updstrship .= $returnShipping['updstrship'];  

                                // check data for recording 
                                $returnRecording = $this->recordingSaveUpdate($records[2], $records[1], $postData);
                                $insstrrec .= $returnRecording['insstrrec'];
                                $updstrrec .= $returnRecording['updstrrec'];  

                            }
                           
                        } else{ 
                            // qc insert update
                            $qcReturn = $this->qcSaveUpdate($records[2], $records[1], $clifnoarr[0], $queryparams);
                            $insstrqc .= $qcReturn['insstrqc'];
                            $updstrqc .= $qcReturn['updstrqc'];   

                            // accounting insert
                            $returnAcc = $this->accountingInsert($records[2], $records[1], $postData);
                            $insstracc .= $returnAcc;

                            // shipping insert update
                            $returnShipping = $this->shippingSaveUpdate($records[2], $records[1], $postData);
                            $insstrship .= $returnShipping['insstrship'];
                            $updstrship .= $returnShipping['updstrship']; 

                            // recording insert update
                            $returnRecording = $this->recordingSaveUpdate($records[2], $records[1], $postData);
                            $insstrrec .= $returnRecording['insstrrec'];
                            $updstrrec .= $returnRecording['updstrrec']; 
                        }

                    }
                }
                
            } // if proceed button end

            if(($this->request->getData('saveBtn') !== null)) {

                $isFileUpload   = true;
                $csvRecordsFile = $this->request->getData('upload_records');

                $csvRecordsFilename = $csvRecordsFile->getClientFilename();
                $GetFileExtension = $csvRecordsFile->getClientMediaType();
    
                $GetFileExtension = substr($csvRecordsFilename,-3);
                
                if((strtolower($GetFileExtension) != 'csv') || ($csvRecordsFile->getError() != '0'))
                { 
                    $errorArr['errorArr'][] = "Please upload cvs files only";
                    goto errordisplay;
                } else {
 
                    $destination =  WWW_ROOT.'files/import/';
                     
                    $date = date('YmdHis');
                    $filename = "SimplifileRecordsImport_" . $date .".csv" ; 

                    $destination .= $filename;

                    $csvRecordsFile->moveTo($destination); 

                    if($csvRecordsFile->getError() == 0) {

                        $csvFile = $destination;
                        if($_FILES['upload_records']['size'] == 0){  
                            $errorArr['errorArr'][] = "CSV file content type not supported.";
                            goto errordisplay;
                        }
                        $csvFile = str_replace(["/","\\"],'/',$csvFile);
                       
                        if (!$myFile = @fopen(stripslashes($csvFile), "r")){  
                            $errorArr['errorArr'][] = "Can\'t open CSV file. it has been moved/deleted";
                            goto errordisplay;
                        }else{
                              
                            $this->cols = fgetcsv($myFile); 
                            $trncol = $recordingdateCol ='';   
                            foreach($this->cols as $id=>$value){ 
                                if(!empty($value)){ 
                                    if(!in_array(strtolower(str_replace(" ","", $value)), $this->CSVFields) && trim($value) != ""){
                                        $errorArr['isNotMatch'][] = $value;                    
                                    }  
                                }else{ 
                                    $errorArr['errorArr'][] = "CSV file contain empty headers"; 
                                }
                            } 
                          
                            if(!empty(array_filter($errorArr))){
                                goto errordisplay;
                            }

                            // check csv headers col id
                            $this->checkHeaderCols();
                            $updstr = "";
                            $insstr = "";
                            $insstrqc = "";
                            $updstrqc = "";
 
                            $csvdata = array();
                            $chargeerrarr = array();
                            $finalarr = [];
                            while ($csvrow = fgetcsv($myFile)){
                                if (empty(array_filter($csvrow)))
                                {
                                    continue;
                                }  
                            
                                $csvdata[$csvrow[$this->checkHeaderFld['trncol']]][$this->checkHeaderFld['accountingCol']] = (isset($csvrow[$this->checkHeaderFld['accountingCol']]) ? trim($csvrow[$this->checkHeaderFld['accountingCol']]) : "");
                                $csvdata[$csvrow[$this->checkHeaderFld['trncol']]]["rowdone"] = 0;
                                if(!$csvdata[$csvrow[$this->checkHeaderFld['trncol']]]["rowdone"] && $csvrow[$this->checkHeaderFld['trncol']] != ""){ 

                                    $csvdata[$csvrow[$this->checkHeaderFld['trncol']]] = $csvrow;
                                    $csvdata[$csvrow[$this->checkHeaderFld['trncol']]]["rowdone"] = 1;
                                    $csvdata[$csvrow[$this->checkHeaderFld['trncol']]]["Countyrecordingfee"] = 0;
                                    $csvdata[$csvrow[$this->checkHeaderFld['trncol']]][$this->checkHeaderFld['accountingCol']] ="";
                                    $csvdata[$csvrow[$this->checkHeaderFld['trncol']]]["taxes"] = 0;
                                    $csvdata[$csvrow[$this->checkHeaderFld['trncol']]]["additionalfees"] = 0;
                                    $finalarr = $this->entryColFinal($csvdata[$csvrow[$this->checkHeaderFld['trncol']]][$this->checkHeaderFld['entryCol']]);

                                }
                                    
                            //   echo ' ====finalarr===='; pr($finalarr);  
                                    $csvdata[$csvrow[$this->checkHeaderFld['trncol']]]["Countyrecordingfee"] += (isset($csvrow[$this->checkHeaderFld['recordingfeecol']]) ? floatval(preg_replace("/[^-0-9\.]/","",$csvrow[$this->checkHeaderFld['recordingfeecol']])) : 0);
                                    if(isset($csvrow[$this->checkHeaderFld['taxcol']]))  $csvdata[$csvrow[$this->checkHeaderFld['trncol']]]["taxes"] += (isset($csvrow[$this->checkHeaderFld['taxcol']]) ? floatval(preg_replace("/[^-0-9\.]/","",$csvrow[$this->checkHeaderFld['taxcol']])) : 0);
                                    if($csvdata[$csvrow[$this->checkHeaderFld['trncol']]][$this->checkHeaderFld['accountingCol']] == "I"){
                                        $csvdata[$csvrow[$this->checkHeaderFld['trncol']]]["additionalfees"] += (isset($csvrow[$this->checkHeaderFld['additionalfeescol']]) ? floatval(preg_replace("/[^-0-9\.]/","",$csvrow[$this->checkHeaderFld['additionalfeescol']])) : 0); 
                                    }
                                    
                                    //Prepare recording fields
                                    if(!empty($csvdata[$csvrow[$this->checkHeaderFld['trncol']]][$this->checkHeaderFld['documentCol']]) && !stripos($csvdata[$csvrow[$this->checkHeaderFld['trncol']]][$this->checkHeaderFld['documentCol']], ".pdf")){
                                        $csvdata[$csvrow[$this->checkHeaderFld['trncol']]][$this->checkHeaderFld['documentCol']] .= ".pdf";
                                    }  

                                    $recdatetime = (isset($csvdata[$csvrow[$this->checkHeaderFld['trncol']]][$this->checkHeaderFld['recordingdateCol']]) ? explode(" ", preg_replace("/[[:blank:]]+/"," ",$csvdata[$csvrow[$this->checkHeaderFld['trncol']]][$this->checkHeaderFld['recordingdateCol']])) : "");
                                    $csvdata[$csvrow[$this->checkHeaderFld['trncol']]]["RecordingDate"] = (isset($recdatetime[0])? $recdatetime[0] : "");
                                    $csvdata[$csvrow[$this->checkHeaderFld['trncol']]]["RecordingTime"] = (isset($recdatetime[1])? $recdatetime[1] : "");	
                                    $csvdata[$csvrow[$this->checkHeaderFld['trncol']]]["instrumentnumber"] = (isset($finalarr['I']) ? implode("", $finalarr['I']) : "");
                                    $csvdata[$csvrow[$this->checkHeaderFld['trncol']]]["book"] = (isset($finalarr['B']) ? implode("", $finalarr['B']) : "");
                                    $csvdata[$csvrow[$this->checkHeaderFld['trncol']]]["page"] =  (isset($finalarr['P']) ? implode("", $finalarr['P']) : "");
                        
                                    $bankdatetime = (isset($csvdata[$csvrow[$this->checkHeaderFld['trncol']]][$this->checkHeaderFld['bankdateCol']]) ? explode(" ", preg_replace("/[[:blank:]]+/"," ",$csvdata[$csvrow[$this->checkHeaderFld['trncol']]][$this->checkHeaderFld['bankdateCol']])) : "");
                                    $csvdata[$csvrow[$this->checkHeaderFld['trncol']]][$this->checkHeaderFld['bankdateCol']] = (!empty($bankdatetime[0]) ? date("Y-m-d",strtotime($bankdatetime[0])) : '');
                                    $csvdata[$csvrow[$this->checkHeaderFld['trncol']]]["processingtime"] = (!empty($bankdatetime[1]) ? date("H:i:s",strtotime($bankdatetime[1])) : ''); 
                             
                            } // while
    
                            $errorcntr = 0;
                             
                            foreach($csvdata as $key=>$data){
                                if (empty(array_filter($data)))
                                {
                                    continue;
                                }
                             
                                if(isset($data[$this->checkHeaderFld['trncol']]) && $data[$this->checkHeaderFld['trncol']] != ""){
                                    $detailUsers = array(); 

                                    // insert / update data
                                    if(!empty(array_filter($data))) { 
                                        $clifnoarr = explode(".", $data[$this->checkHeaderFld['trncol']]);
                                        $PartnerFileNumber = $clifnoarr[0]; 
                                        $tagreferenceno = $this->FilesMainData->CheckPartnerFileNumber($PartnerFileNumber);
            
                                        if(!empty($tagreferenceno) && $tagreferenceno['Id'] != "")
                                        { 
                                            
                                            $checkInData = $this->FilesCheckinData->getCheckInDataCSC($tagreferenceno['Id']);
            
                                            $entryfieldissue = 0;
                                            if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬]/', $data[$this->checkHeaderFld['entryCol']])){
                                                // one or more of the 'special characters' found in $string
                                                $entryfieldissue = 1;
                                            }
                                            
                                            $recdtfieldissue = 0; 
                                            if (!trim($data[$this->checkHeaderFld['recordingdateCol']])){
                                                // Empty recording date
                                                $recdtfieldissue = 1;
                                            } 

                                            $countCheckin = count($checkInData);
                                            if($countCheckin > 1 || $entryfieldissue || $recdtfieldissue){
                                                $returnDocType = $this->checkMultiDocType($checkInData, $data, $errorcntr, $entryfieldissue, $recdtfieldissue); 
                                                $multipleupdstr .= $returnDocType; 
                                                $errorcntr++;
                                            } // if > 1
                                            elseif($countCheckin  == 1){
                            
                                                if($checkInData[0]["DocumentReceived"] != "Y"){ 
                                                    $this->FilesCheckinData->updateDocumentStatus('Y', $checkInData[0]['Id']);
                                                    // insert public notes
                                                    $this->addPublicNotes($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], 'Checkin update', 'Fcd');
                                                } 
                                                
                                                // select accounting data
                                                $accData = $this->FilesAccountingData->getfilesAccountingData($checkInData[0]['RecId'], $checkInData[0]['TransactionType']); 
                                
                                                if(!empty($accData)){
                                                    $erarray = array("e-record", "erecord");
                                                    if($accData['RecId'] != ""){

                                                        // qc insert update
                                                        $qcReturn = $this->qcSaveUpdate($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], $clifnoarr[0]);
                                                        $insstrqc .= $qcReturn['insstrqc'];
                                                        $updstrqc .= $qcReturn['updstrqc'];  
                                                        
                                                        // Update accounting
                                                        if(in_array(strtolower($accData['CountyRecordingFee']), $erarray) || in_array(strtolower($accData['Taxes']), $erarray) ||
                                                            in_array(strtolower($accData['AdditionalFees']), $erarray) || in_array(strtolower($accData['Total']), $erarray)){
                                                            $erecrows[] = $data;
                                                        }else{
                                                            $returnAccounting = $this->accountingUpdate($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], $accData, $data);
                                                            $updstracc .= $returnAccounting; 
                                                        }
                                                        // check for ship to County 
                                                        $returnShipping = $this->shippingSaveUpdate($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], $data);
                                                        $insstrship .= $returnShipping['insstrship'];
                                                        $updstrship .= $returnShipping['updstrship'];  

                                                        // check data for recording 
                                                        $returnRecording = $this->recordingSaveUpdate($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], $data);
                                                        $insstrrec .= $returnRecording['insstrrec'];
                                                        $updstrrec .= $returnRecording['updstrrec'];   
                                                    } // if accounting
                                                }else{  
                                                    //Record doesn't exist in account, check in QC, if exist, then insert in accounting
                                                    // qc insert update
                                                    $qcReturn = $this->qcSaveUpdate($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], $clifnoarr[0]);
                                                    $insstrqc .= $qcReturn['insstrqc'];
                                                    $updstrqc .= $qcReturn['updstrqc'];   

                                                    // accounting insert
                                                    $returnAcc = $this->accountingInsert($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], $data);
                                                    $insstracc .= $returnAcc;

                                                    // shipping insert update
                                                    $returnShipping = $this->shippingSaveUpdate($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], $data);
                                                    $insstrship .= $returnShipping['insstrship'];
                                                    $updstrship .= $returnShipping['updstrship']; 

                                                    // recording insert update
                                                    $returnRecording = $this->recordingSaveUpdate($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], $data);
                                                    $insstrrec .= $returnRecording['insstrrec'];
                                                    $updstrrec .= $returnRecording['updstrrec']; 

                                                } //else accounting 
                                            } //elseif == 1
                                            else{
                                                //recor not found in Check In
                                                $errrowsCFN[] = $data;
                                            }  
                                        } else {  
                                            $errrowsCFN[] = $data;
                                        }	 
                                        
                                    } 
                                } // End of isset($data[$this->checkHeaderFld['trncol']]) 
                              
                            } // End foreach   exit;
                        }   
                        fclose($myFile);   
                    } else {
                        $errorArr['errorArr'][] = "Some error occur while uploading file. Please try again !!";
					    goto errordisplay;
                    } 
                } 

            } // end save btn
   
            $fwViewData['colstext'] = implode(",",$this->cols);
            
            $fwViewData['DBFieldsAcc'] = implode(",", $this->DBFieldsAcc);
            $fwViewData['DBFieldsShip'] = implode(",", $this->DBFieldsShip);
            $fwViewData['DBFieldsRec'] = implode(",", $this->DBFieldsRec);
           
            $fwViewData['errrows'] = $this->setErrorTable($errrows);
            //    $fwViewData['erecrows'] = $this->setErrorTable($erecrows);
            $fwViewData['errrowsCFN'] = $this->setErrorTable($errrowsCFN);
            $fwViewData['errrowsQC'] = $this->setErrorTable($errrowsQC);
 
            if(isset($multipleupdstr) && $multipleupdstr != ""){
                $fwViewData['multipleupdstr'] = $this->setErrorTable($multipleupdstr); 
            }

            if($insstracc != ""){
                $fwViewData['insstracc'] = $this->setRecordTable($insstracc, 'CSVFieldsAcc'); 
            }
            if($insstrship != ""){
                $fwViewData['insstrship'] = $this->setRecordTable($insstrship, 'CSVFieldsShip');  
            }
            if($insstrrec != ""){
                $fwViewData['insstrrec'] = $this->setRecordTable($insstrrec, 'CSVFieldsRec');  
            }
            if($updstracc != ""){
                $fwViewData['updstracc'] = $this->setRecordTable($updstracc, 'CSVFieldsAcc');   
            }
            if($updstrship != ""){
                $fwViewData['updstrship'] = $this->setRecordTable($updstrship, 'CSVFieldsShip');  
            }
            if($updstrrec != ""){
                $fwViewData['updstrrec'] = $this->setRecordTable($updstrrec, 'CSVFieldsRec'); 
            }  
        }  // end of post
 
        errordisplay:{
            if(!empty(array_filter($errorArr))){  
                $this->flashErrorMsg($errorArr, $this->CSVFields); 
            } 
        }

        $this->set('FilesMainData',$FilesMainData);
        $this->set('fwViewData',$fwViewData);
        
        $this->set('_serialize', ['FilesMainData']);

    } 

    public function entryColFinal($entryData){
        $entryval = str_replace("Pg", "P", str_replace("Bk", "B", str_replace(" ","", $entryData)));
        $entryvalchars = str_split($entryval);
        // echo ' ====entryvalchars===='; pr($entryvalchars);   
        $firstchar = 1;
        $finalarr = array();
        $currarr = "";
        foreach($entryvalchars as $entryvalchar){
            if($firstchar){
                if($entryvalchar != "E" && $entryvalchar != "B" && $entryvalchar != "P"){
                    $finalarr["I"][] = $entryvalchar;
                    $currarr = "I";
                }elseif($entryvalchar == "E"){
                    $currarr = "I";
                }elseif($entryvalchar == "B"){
                    $currarr = "B";
                }elseif($entryvalchar == "P"){
                    $currarr = "P";
                }
                $firstchar = 0;
            }elseif($entryvalchar == "E"){
                $currarr = "I";
            }elseif($entryvalchar == "B"){
                $currarr = "B";
            }elseif($entryvalchar == "P"){
                $currarr = "P";
            }else{
                $finalarr[$currarr][] = $entryvalchar;
            }
        }

        return $finalarr;
    }

    public function extractData($tableData){
        $removearr = ['rowdone','Countyrecordingfee','taxes','additionalfees','RecordingDate',
        'RecordingTime','instrumentnumber','book', 'page', 'processingtime'];
        foreach($tableData as $key=>$rowdata){
            if(@in_array($key, $removearr)){ 
                if($key != '0'){ unset($tableData[$key]);} 
            }
         }  
         return $tableData;
    }
    
    public function setErrorTable($errorData){ 
       
        $fwViewText = "";
        if(is_array($errorData)){
            if(is_countable($errorData) && sizeof($errorData)>0){
            
                $fwViewText = "<table id='datatable_example' class='table dataTable order-column stripe table-striped table-bordered no-footer'><thead><tr><th class='headercelllisting'><b>".implode("</b></th><th class='headercelllisting'><b>",$this->cols)."</b></th></tr></thead>";
                $fwViewText .= "</tbody>";
                foreach($errorData as $errorKey){ 
                    $errorKey = $this->extractData($errorKey); 
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

    public function qcSaveUpdate($RecId,$TransactionType, $clifnoarr='', $queryparams=''){
        $qcData = $this->FilesQcData->getQCData($RecId, $TransactionType); // select data
        $insstrtdqc = $insstrqc=""; $updstrtdqc = $updstrqc = ""; $errrowsQC = [];  $data1 = array();
        if(empty($qcData)){
            // insert qc data
            $qcinsert = ['RecId'=>$RecId, 'TransactionType'=>$TransactionType, 'UserId'=>$this->currentUser->user_id, 'Status'=>'OK', 'QCProcessingDate'=>Date("Y-m-d"), 'QCProcessingTime'=>Date("H:i:s")];
           
            $this->FilesQcData->saveQCData($qcinsert);
            
            if(!empty($queryparams)){  $fwarray = array ();
                foreach($queryparams as $fields_value){
                    
                    $fwarray = explode("=", $fields_value);
                    $data1[] = $fwarray[1];
                    $insstrtdqc .= "<td>".$fwarray[1]."</td>";
                }
                $errrowsQC[] = $data1;
                $insstrqc .= "<tr>".$insstrtdqc."</tr>";
            }else{
                $insstrtdqc .= "<td>".$clifnoarr."</td><td>".$TransactionType;
                $insstrqc .= "<tr>".$insstrtdqc."</tr>";
            }

            // insert public notes
            $this->addPublicNotes($RecId, $TransactionType, 'QC insert', 'Fqcd');

        }else{  
            if($qcData['Status'] != "OK"){
                // update qc for status OK
                $this->FilesQcData->updateQCData($qcData['Id'], ['status'=>'OK']); 
                
                if(!empty($queryparams)){   $fwarray = array ();
                    foreach($queryparams as $fields_value){
                       
                        $fwarray = explode("=", $fields_value);
                        $data1[] = $fwarray[1];
                        $updstrtdqc .= "<td>".$fwarray[1]."</td>";
                    }
                    $errrowsQC[] = $data1;
                    $updstrqc .= "<tr>".$updstrtdqc."</tr>";
                }else{
                    $updstrtdqc .= "<td>".$clifnoarr."</td><td>".$TransactionType; 
                    $updstrqc .= "<tr>".$updstrtdqc."</tr>";  
                }
    
                // insert public notes
                $this->addPublicNotes($RecId, $TransactionType, 'QC update', 'Fqcd');
            }else{
                if(!empty($queryparams)){  
                     $fwarray = array ();
                    foreach($queryparams as $fields_value){ 
                        $fwarray = explode("=", $fields_value);
                        $data1[] = $fwarray[1];
                    }
                    $errrowsQC[] = $data1;
                }
            }

        }

        return ['insstrqc'=>$insstrqc,'updstrqc'=>$updstrqc, 'errrowsQC'=>$errrowsQC];
    }
 
    public function checkHeaderCols(){
        $checkHeader = ['trncol'=>'', 'recordingfeecol'=>'','packagecol'=>'','taxcol'=>'','ProcessingDateCol'=>'','bankdateCol'=>'','DTVar'=>'','CountyCol'=>'','carrierCol'=>'','trackingCol'=>'',
        'documentCol'=>'','recordingdateCol'=>'','entryCol'=>'','pagesCol'=>'','accountingCol'=>'','additionalfeescol'=>''];
        foreach($this->cols as $id=>$value){ 
            if(!empty($value)){   
                if(strtolower(str_replace(" ","", $value)) == "filenumber"){                   
                    $checkHeader['trncol'] = $id;                    
                }
                if(strtolower(str_replace(" ","", $value)) == "recordingfee"){
                    $checkHeader['recordingfeecol'] = $id;
                }
                if(strtolower(str_replace(" ","", $value)) == "package"){
                    $checkHeader['packagecol'] = $id;
                }
                if(strtolower(str_replace(" ","", $value)) == "tax"){
                    $checkHeader['taxcol'] = $id;
                }
                if(strtolower(str_replace(" ","", $value)) == "processingdate"){
                    $checkHeader['ProcessingDateCol'] = $id;
                }
                if(strtolower(str_replace(" ","", $value)) == "bankdate"){
                    $checkHeader['bankdateCol'] = $id;
                }
                if(strtolower(str_replace(" ","", $value)) == "type"){
                    $checkHeader['DTVar'] = $id; 
                }
                if(strtolower(str_replace(" ","", $value)) == "County"){
                    $checkHeader['CountyCol'] = $id;
                }
                if(strtolower(str_replace(" ","", $value)) == "carrier"){
                    $checkHeader['carrierCol'] = $id;
                }                    
                if(strtolower(str_replace(" ","", $value)) == "carriertrackingnumber"){
                    $checkHeader['trackingCol'] = $id;
                }                    
                if(strtolower(str_replace(" ","", $value)) == "document"){
                    $checkHeader['documentCol'] = $id;
                }
                if(strtolower(str_replace(" ","", $value)) == "recordingdate"){
                    $checkHeader['recordingdateCol'] = $id;
                }
                
                if(strtolower(str_replace(" ","", $value)) == "entry"){
                    $checkHeader['entryCol'] = $id;
                }
                if(strtolower(str_replace(" ","", $value)) == "pages"){
                    $checkHeader['pagesCol'] = $id;
                }
                if(strtolower(str_replace(" ","", $value)) == "accounting"){
                    $checkHeader['accountingCol'] = $id;
                }
                if(strtolower(str_replace(" ","", $value)) == "submissionfee"){
                    $checkHeader['additionalfeescol'] = $id;
                }
            }
        }

        $this->checkHeaderFld = $checkHeader;
    }


    public function accountingInsert($RecId, $TransactionType, $data){
        $updsqlfieldsacc = array();  
        $acctotal = $data['Countyrecordingfee'] + $data['taxes'] + $data['additionalfees'];
        $updsqlfieldsacc["RecId"] = $RecId; 
        $updsqlfieldsacc["TransactionType"] = $TransactionType; 
        $updsqlfieldsacc["CountyRecordingFee"] = $data['Countyrecordingfee'];
        $updsqlfieldsacc["Taxes"] = $data['taxes']; 
        $updsqlfieldsacc["AdditionalFees"] = $data['additionalfees']; 
        $updsqlfieldsacc["Total"] = $acctotal; 

        $updsqlfieldsacc["jrf_final_fees"] = $data['Countyrecordingfee'];
        $updsqlfieldsacc["it_final_fees"] = $data['taxes'];
        $updsqlfieldsacc["of_final_fees"] = $data['additionalfees'];
        $updsqlfieldsacc["total_final_fees"] = $acctotal;
 
        if(isset($data[$this->checkHeaderFld['accountingCol']]) && ($data[$this->checkHeaderFld['accountingCol']] == "I")){ 
            $updsqlfieldsacc["EPortalActual"] = $acctotal; 
            $updsqlfieldsacc["UploadedCountyrecordingfee"] = $data['Countyrecordingfee']; 
            $updsqlfieldsacc["UploadedTaxes"] = $data['taxes']; 
            $updsqlfieldsacc["UploadedAdditionalfees"] = $acctotal;
            $updsqlfieldsacc["UploadedTotal"] = $data['additionalfees']; 
            $updsqlfieldsacc["UploadedDateTime"] = date("Y-m-d H:i:s"); 
        }

        $updsqlfieldsacc["AccountingProcessingDate"] = date("Y-m-d", strtotime($data[$this->checkHeaderFld['bankdateCol']])); 
        $updsqlfieldsacc["AccountingProcessingTime"] = $data["processingtime"]; 

        $updsqlfieldsacc["UserId"] = $this->currentUser->user_id;  
        $updsqlfieldsacc["LastModified"] = date("Y-m-d");
        
        $insstracc = "";
        
        $insstracc .= "<tr><td>".$data[$this->checkHeaderFld['CountyCol']]."</td> <td>".$data[$this->checkHeaderFld['trncol']]."</td> <td>".$data[$this->checkHeaderFld['DTVar']]."</td> <td>".$data['Countyrecordingfee']."</td> <td>".$data['taxes']."</td><td>".$data['additionalfees']."</td><td>".$acctotal."</td></tr>";
  
        // insert accounting
        $this->FilesAccountingData->insertNewAccountData($updsqlfieldsacc);
        
        // public notes for accounting
        $Regarding = "<b>Accounting Insert </b> (Jurisdiction Recording Fee: ".$data['Countyrecordingfee'].", Other Fees: ".$data['additionalfees'].", Intangible / Mtg Tax: ".$data['taxes'].", Total: ".$acctotal.")";
        $this->addPublicNotes($RecId, $TransactionType, $Regarding, 'Fad');

        return $insstracc;
    }

    public function accountingUpdate($RecId, $TransactionType, $accData, $data){ 
      
        $existingaccdata = '<b>Existing Accounting Data</b>: <br>CountyRecordingFee = "'.$accData['CountyRecordingFee'].'", Taxes = "'.$accData['Taxes'].'", AdditionalFees = "'.$accData['AdditionalFees'].'", Total = "'.$accData['Total'].'"';
 
        $updstracc = ""; 
        $updsqlacc = array(); 
       
        $acctotal = $data['Countyrecordingfee'] + $data['taxes'] + $data['additionalfees'];
        
        if(isset($data[$this->checkHeaderFld['accountingCol']]) && ($data[$this->checkHeaderFld['accountingCol']] == "I")){ 
            $updsqlacc["EPortalActual"] = $acctotal;
            $updsqlacc["UploadedCountyrecordingfee"] = $data['Countyrecordingfee'];
            $updsqlacc["UploadedTaxes"] = $data['taxes'];
            $updsqlacc["UploadedAdditionalfees"] = $data['additionalfees'];
            $updsqlacc["UploadedTotal"] = $acctotal;
            $updsqlacc["UploadedDateTime"] = date("Y-m-d H:i:s");
        }else{
            $updsqlacc["CountyRecordingFee"] = $data['Countyrecordingfee'];
            $updsqlacc["Taxes"] = $data['taxes'];
            $updsqlacc["AdditionalFees"] = $data['additionalfees'];
            $updsqlacc["Total"] = $acctotal;
            $updsqlacc["AccountingProcessingDate"] = date("Y-m-d", strtotime($data[$this->checkHeaderFld['bankdateCol']]));
            $updsqlacc["AccountingProcessingTime"] = $data["processingtime"];
        }

        $updsqlacc["jrf_final_fees"] = $data['Countyrecordingfee'];
        $updsqlacc["it_final_fees"] = $data['taxes'];
        $updsqlacc["of_final_fees"] = $data['additionalfees'];
        $updsqlacc["total_final_fees"] = $acctotal;

        $updsqlacc["UserId"] = $this->currentUser->user_id;
   
        // update accounting table 
        $this->FilesAccountingData->updateAccountDataCSC($accData['accountId'], $updsqlacc);
         
        $updstracc .= "<tr><td>".$data[$this->checkHeaderFld['CountyCol']]."</td><td>".$data[$this->checkHeaderFld['trncol']]."</td><td>".$data[$this->checkHeaderFld['DTVar']]."</td><td>".$data['Countyrecordingfee']."</td><td>".$data['taxes']."</td><td>".$data['additionalfees']."</td><td>".$acctotal."</td></tr>";
 
        // insert public notes accounting 
        $Regarding = "<b>Accounting update</b> (Jurisdiction Recording Fee: ".$data['Countyrecordingfee'].", Other Fees: ".$data['additionalfees'].", Intangible / Mtg Tax: ".$data['taxes'].", Total: ".$acctotal.")";
        
        if(isset($data[$this->checkHeaderFld['accountingCol']]) && ($data[$this->checkHeaderFld['accountingCol']] == "I")){
            $Regarding .= " (Accounting: I)";
        }
        $this->addPublicNotes($RecId, $TransactionType, $Regarding, 'Fad');

        return $updstracc;
    }

    public function shippingSaveUpdate($RecId, $TransactionType, $data){
        $insstrtdship = ""; $insstrship=""; $updstrship="";
        $shiptoCountyData = $this->FilesShiptoCountyData->fetchS2CDataCSC($RecId, $TransactionType);
        if(empty($shiptoCountyData)){
            // insert shipping data

            $updsqlfieldsship = array(); 

            $updsqlfieldsship["RecId"] = $RecId;  
            $updsqlfieldsship["TransactionType"] = $TransactionType;

            if(!$data[$this->checkHeaderFld['carrierCol']]){
                $updsqlfieldsship["CarrierName"] = 'E-Record';
                $updsqlfieldsship["CarrierTrackingNo"] = 'E-Record'; 
            }else{
                $updsqlfieldsship["CarrierName"] = $data[$this->checkHeaderFld['carrierCol']];
                $updsqlfieldsship["CarrierTrackingNo"] = $data[$this->checkHeaderFld['trackingCol']]; 
            }
            $updsqlfieldsship["ShippingProcessingDate"] = date("Y-m-d", strtotime($data[$this->checkHeaderFld['bankdateCol']]));
            $updsqlfieldsship["ShippingProcessingTime"] = $data["processingtime"];
            $updsqlfieldsship["UserId"] =$this->currentUser->user_id;
 
            // insert
            $this->FilesShiptoCountyData->saveShippingData($updsqlfieldsship);
               
            $insstrship .= "<tr><td>".$data[$this->checkHeaderFld['CountyCol']]."</td> <td>".$data[$this->checkHeaderFld['trncol']]."</td> <td>".$data[$this->checkHeaderFld['DTVar']]."</td> <td>".$data[$this->checkHeaderFld['carrierCol']]."</td> <td>".$data[$this->checkHeaderFld['trackingCol']]."</td></tr>";
            // insert public data ship
            $Regarding ="<b>Shipping insert</b> (CarrierName: ".$updsqlfieldsship["CarrierName"].", CarrierTrackingNo: ".$updsqlfieldsship["CarrierTrackingNo"].")";
            $this->addPublicNotes($RecId, $TransactionType, $Regarding, 'Fsd');
        }else{
            // update shipping data 
           
            $updsqlship = array();

            if(!$data[$this->checkHeaderFld['carrierCol']]){
                $updsqlship["CarrierName"] = 'E-Record';
                $updsqlship["CarrierTrackingNo"] = 'E-Record';
            }else{
                $updsqlship["CarrierName"] = $data[$this->checkHeaderFld['carrierCol']];
                $updsqlship["CarrierTrackingNo"] = $data[$this->checkHeaderFld['trackingCol']];
            }
            $updsqlship["ShippingProcessingDate"] = date("Y-m-d", strtotime($data[$this->checkHeaderFld['bankdateCol']]));;
            $updsqlship["ShippingProcessingTime"] = $data["processingtime"];
            $updsqlship["UserId"] =$this->currentUser->user_id;
 
            $this->FilesShiptoCountyData->updateShippingData($shiptoCountyData['Id'], $updsqlship);
       
            $updstrship .= "<tr><td>".$data[$this->checkHeaderFld['CountyCol']]."</td> <td>".$data[$this->checkHeaderFld['trncol']]."</td> <td>".$data[$this->checkHeaderFld['DTVar']]."</td> <td>".$data[$this->checkHeaderFld['carrierCol']]."</td> <td>".$data[$this->checkHeaderFld['trackingCol']]."</td></tr>";
            // insert public data
            $Regarding ="<b>Shipping update</b> (CarrierName: ".$updsqlship["CarrierName"].", CarrierTrackingNo: ".$updsqlship["CarrierTrackingNo"].")";
            $this->addPublicNotes($RecId, $TransactionType, $Regarding, 'Fsd');
        }

       return ['insstrship'=>$insstrship, 'updstrship'=>$updstrship];
    }


    public function recordingSaveUpdate($RecId, $TransactionType, $data){
        $recordingData = $this->FilesRecordingData->fetchRecordingDataCSC($RecId, $TransactionType);
        $insstrrec = ""; $updstrrec = "";
        if(empty($recordingData)){
            // insert Recording data
            $updsqlfieldsrec = array();
            $updsqlvaluesrec = array();

            $updsqlfieldsrec["RecId"] = $RecId;  
            $updsqlfieldsrec["TransactionType"] = $TransactionType;
            $updsqlfieldsrec["File"] = @$data[$this->checkHeaderFld['documentCol']]; 
            $updsqlfieldsrec["RecordingDate"] = $data["RecordingDate"];            
            $updsqlfieldsrec["RecordingTime"] = $data["RecordingTime"];            
            $updsqlfieldsrec["InstrumentNumber"] = $data["instrumentnumber"];            
            $updsqlfieldsrec["Pages"] = @$data[$this->checkHeaderFld['pagesCol']];            
            $updsqlfieldsrec["Book"] = $data["book"];            
            $updsqlfieldsrec["Page"] = $data["page"];            
            $updsqlfieldsrec["RecordingProcessingDate"] = @date("Y-m-d", strtotime($data[$this->checkHeaderFld['bankdateCol']]));           
            $updsqlfieldsrec["RecordingProcessingTime"] = $data["processingtime"];            
            $updsqlfieldsrec["UserId"] = $this->currentUser->user_id; 
            $updsqlfieldsrec["KNI"] = 2;   
 
            $insstrrec .= "<tr><td>".$data[$this->checkHeaderFld['CountyCol']]."</td> <td>".$data[$this->checkHeaderFld['trncol']]."</td> <td>".$data[$this->checkHeaderFld['documentCol']]."</td> <td>".$data[$this->checkHeaderFld['DTVar']]." </td> <td>".$data["RecordingDate"]."</td> <td>".$data["RecordingTime"]."</td> <td>".$data["instrumentnumber"]."</td> <td>".$data[$this->checkHeaderFld['pagesCol']]."</td> <td>".$data["book"]."</td> <td>".$data["page"]."</td></tr>";
            
            $this->FilesRecordingData->saveFRDData($updsqlfieldsrec); 
            // inseert public data recording
            $Regarding = " <b>Recording insert</b>(File: ".$updsqlfieldsrec['File'].", Recording Date: ".$updsqlfieldsrec['RecordingDate'].", Recording Time: ".$updsqlfieldsrec['RecordingTime'].",Instrument Number: ".$updsqlfieldsrec['InstrumentNumber'].", Book: ".$updsqlfieldsrec['Book'].", Page: ".$updsqlfieldsrec['Page'].", Recording Processing Date: ".$updsqlfieldsrec['RecordingProcessingDate'].", Recording Processing Time: ".$updsqlfieldsrec['RecordingProcessingTime'].")";
            $this->addPublicNotes($RecId, $TransactionType, $Regarding, 'Frd');

        }else{
            // update Recording data 
            
            $updsqlrec = array();
            $updsqlrec["File"] = @$data[$this->checkHeaderFld['documentCol']];
            $updsqlrec["RecordingDate"] = $data["RecordingDate"];
            $updsqlrec["RecordingTime"] = $data["RecordingTime"];
            
            if($data["instrumentnumber"] != ""){
                $updsqlrec["InstrumentNumber"] = $data["instrumentnumber"];
            }
            $updsqlrec["Pages"] =  @$data[$this->checkHeaderFld['pagesCol']];
            if($data["book"] != ""){
                $updsqlrec["Book"] = $data["book"];
            }
            if($data["page"] != ""){
                $updsqlrec["Page"] = $data["page"];
            }

            $updsqlrec["RecordingProcessingDate"] = @date("Y-m-d", strtotime($data[$this->checkHeaderFld['bankdateCol']]));
            $updsqlrec["RecordingProcessingTime"] = $data["processingtime"];
 
            $updsqlrec["UserId"] =  $this->currentUser->user_id;
            $updsqlrec["KNI"] = 2;

            $updstrrec .= "<tr><td>".@$data[$this->checkHeaderFld['CountyCol']]."</td> <td>".@$data[$this->checkHeaderFld['trncol']]."</td> <td>".@$data[$this->checkHeaderFld['documentCol']]."</td> <td>".@$data[$this->checkHeaderFld['DTVar']]." </td> <td>".$data["RecordingDate"]."</td> <td>".$data["RecordingTime"]."</td> <td>".$data["instrumentnumber"]."</td> <td>".@$data[$this->checkHeaderFld['pagesCol']]."</td> <td>".$data["book"]."</td> <td>".$data["page"]."</td></tr>";
            
            $this->FilesRecordingData->updateFRDData($recordingData['Id'], $updsqlrec);
            $Regarding = " <b>Recording update</b>(File: ".$updsqlrec['File'].", Recording Date: ".$updsqlrec['RecordingDate'].", Recording Time: ".$updsqlrec['RecordingTime'].",Instrument Number: ".$updsqlrec['InstrumentNumber'].", Book: ".$updsqlrec['Book'].", Page: ".$updsqlrec['Page'].", Recording Processing Date: ".$updsqlrec['RecordingProcessingDate'].", Recording Processing Time: ".$updsqlrec['RecordingProcessingTime'].")";
            // insert public data recording
            $this->addPublicNotes($RecId, $TransactionType, $Regarding, 'Frd');
           
        }

        return ['insstrrec'=>$insstrrec, 'updstrrec'=>$updstrrec];
    }

    public function checkMultiDocType($checkInData, $data, $errorcntr, $entryfieldissue, $recdtfieldissue){
        $rowdone = 0; $multipleupdstrtd= $multipleupdstr= ""; $docname = $multopt = "";
        $countCheckin = count($checkInData);
        
        $updsql = array();
        $updsqlarr = array();
        $updsqlacc = array();
        $updsqlship = array();
        $updsqlrec = array();
        $updsqlother = array();
      
        foreach($checkInData as $checkin){ 

            if(!$rowdone){ 
                foreach($this->cols as $colid => $coltext){
                    $coltext = strtolower(str_replace(" ","", $coltext));
                    if($coltext == "filenumber"){
                        $multipleupdstrtd .= "<td>".$data[$colid]." #dt#</td>";
                        $docname = $data[$colid];
                    }elseif($coltext == "entry"){
                        if($entryfieldissue){
                            $multipleupdstrtd .= "<td><input type='text' name='entryfieldissueinput[".$errorcntr."]' style='border:1px solid red;padding:3px' rows='2' pattern='[^£$%&*()}{@#~?><>,|=_+]+' title=\"Characters '£$%&*()}{@#~?><>,|=_+' are not allowed\" value='".$data[$colid]."' size='40'></td>";
                        }else{
                            $multipleupdstrtd .= "<td>".$data[$colid]."</td>";
                        }
						$docname = $data[$colid];
                    }elseif($coltext == "recordingdate"){
                        if($recdtfieldissue){
                            $multipleupdstrtd .= "<td><input type='text' name='recdtfieldissueinput[".$errorcntr."]' style='border:1px solid red;padding:3px' rows='2' required  title=\"Blank value not allowed\" value='".$data[$colid]."' size='20'></td>";
                        }else{
                            $multipleupdstrtd .= "<td>".$data[$colid]."</td>";
                        }
						$docname = $data[$colid];
                    }else{
                        $multipleupdstrtd .= "<td>".$data[$colid]."</td>";
                    }
                }
 
                $updsqlarr[0] = 'County='.(!empty($data[$this->checkHeaderFld['CountyCol']]) ? $data[$this->checkHeaderFld['CountyCol']] : '');
                
                $updsqlarr[1] = 'Package='.(!empty($data[$this->checkHeaderFld['packagecol']]) ? $data[$this->checkHeaderFld['packagecol']] : '');
                $updsqlarr[2] = 'FileNumber='.(!empty($this->checkHeaderFld['trncol']) ? $data[$this->checkHeaderFld['trncol']] : '');
                $updsqlarr[3] = "File=".(!empty($this->checkHeaderFld['documentCol']) ? $data[$this->checkHeaderFld['documentCol']] : '');
                $updsqlarr[4] = 'Type='.(!empty($this->checkHeaderFld['DTVar']) ? $data[$this->checkHeaderFld['DTVar']] : '');
                $updsqlarr[5] = "Pages=".(!empty($this->checkHeaderFld['pagesCol']) ? $data[$this->checkHeaderFld['pagesCol']] : '');
                $updsqlarr[6] = "Entry=";
                $updsqlarr[7] = "RecordingDate=".$data["RecordingDate"].' '.$data["RecordingTime"]; 
                
                $updsqlarr[8] = "ProcessingDate=".(!empty($this->checkHeaderFld['bankdateCol']) ? $data[$this->checkHeaderFld['bankdateCol']].' '.$data["processingtime"] : '');
                $updsqlarr[9] = "CountyRecordingFee=".$data['Countyrecordingfee']; 
                $updsqlarr[10] = "AdditionalFees=".$data['additionalfees']; 
                $updsqlarr[11] = "Taxes=".$data['taxes'];
                $updsqlarr[12] = "Accounting=".(!empty($this->checkHeaderFld['accountingCol']) ? $data[$this->checkHeaderFld['accountingCol']] : '');
                $carrierCol = (!empty($this->checkHeaderFld['carrierCol']) ? $data[$this->checkHeaderFld['carrierCol']] : '');
                if(!$carrierCol){
                    $updsqlarr[13] = "CarrierName=E-Record";
                    $updsqlarr[14] = "CarrierTrackingNo=E-Record";
                }else{
                    $updsqlarr[13] = "CarrierName=".(!empty($this->checkHeaderFld['carrierCol']) ? $data[$this->checkHeaderFld['carrierCol']] : '');
                    $updsqlarr[14] = "CarrierTrackingNo=".(!empty($this->checkHeaderFld['trackingCol']) ? $data[$this->checkHeaderFld['trackingCol']] : '');
                }
  
                $multipleupdstr .= "<tr>".$multipleupdstrtd."</tr>";
                $rowdone = 1; 
            } 
 
            if($countCheckin > 1){ 
                $docType= $this->DocumentTypeMst->getDocumentTitle($checkin["TransactionType"]); 
                $multopt .= '<option value = "' . implode("#updsql#", $updsqlarr) . '#sep#' . $checkin["TransactionType"] . '#sep#' . $checkin["RecId"] .'#sep#U#sep#'.$docname.'#sep#'.$this->currentUser->user_id.'">' . $docType['Title'] . '</option>';
 
            }/* else{  
                $multopt = '<input type="hidden" name="dt['.$errorcntr.']" value = "' . implode("#updsql#", $updsqlarr) . '#sep#' . $checkin["TransactionType"] . '#sep#' . $checkin["RecId"] .'#sep#U#sep#'.$docname.'#sep#'.$this->currentUser->user_id.'">';
            } */

        }

        if($countCheckin > 1){
            $multipleupdstr = str_replace('#dt#', '<select name="dt['.$errorcntr.']" style="border:1px solid red" required><option value="">Select Document Type</option>'.$multopt.'</select>',$multipleupdstr);
        }/* else{
            $multipleupdstr = str_replace('#dt#', $multopt, $multipleupdstr);
        } */
         
        return $multipleupdstr;
 
    }
 
    public function addPublicNotes($recId, $docType, $regardingtext, $section){
        $regarding = (empty($regardingtext)) ? 'Record Added': $regardingtext;
        $this->PublicNotes->insertNewPublicNotes($recId, $docType, $this->currentUser->user_id, 'Simplifile '.$regarding, $section, false, 'Simplifile');
    }
   
}