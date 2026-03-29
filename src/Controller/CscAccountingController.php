<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CscAccounting Controller
 *
 * @method \App\Model\Entity\CscAccounting[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CscAccountingController extends AppController
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
        $this->CSVFields = array('TransactionType', 'packagename', 'documentname', 'County', 'State', 'Countyrecordingfee', 'taxes', 'servicefee', 'total', 'accounting','recordingdate', 'recordingtime', 'instrumentnumber', 'book', 'page', 'filename', 'processingdate', 'carriername', 'carriertrackingno');	

        $this->CSVFieldsAcc = array('Countyrecordingfee', 'taxes', 'total', 'processingdate');	
        $this->CSVFieldsRec = array('recordingdate', 'recordingtime', 'instrumentnumber', 'book', 'page', 'filename', 'processingdate');
        $this->CSVFieldsShip = array('carriername', 'carriertrackingno', 'processingdate');	
        $this->CSVFieldsOther = array('TransactionType', 'packagename', 'documentname', 'County', 'State', 'servicefee', 'accounting');
        //TransactionType	PackageName	DocumentName	County	State	CountyRecordingFee	Taxes	ServiceFee	Total	RecordingDate	RecordingTime	InstrumentNumber	Book	Page	FileName	ProcessingDate		
         
        //Accounting
        
        $this->DBFieldsAcc['Countyrecordingfee'] = 'CountyRecordingFee';
        $this->DBFieldsAcc['taxes'] = 'Taxes';
        $this->DBFieldsAcc['total'] = 'Total';
        $this->DBFieldsAcc['processingdate'] = 'AccountingProcessingDate';
        //$this->DBFieldsAcc['additionalfees'] = 'AdditionalFees';
        
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
        $updstr = "";
        $insstr = "";
        $insstrqc = $insstracc = $insstrrec = $insstrship = "";  
        $updstrqc = $updstrship  = $updstracc = $updstrrec = "";
        $errorcntr = 0;   
        $multipleupdstr ="";
        $documentNumber = "";  
  
        $errcols = array(); 
        $errrows = array();
        $errrowsCFN = array(); 
        $errrowsQC = array();
        $erecrows = array();
 
        $pageTitle = 'CSC Accounting / Recording Info Upload';
		$this->set(compact('pageTitle'));

        $FilesMainData = $this->FilesMainData->newEmptyEntity();

        if($this->request->is(['patch', 'post', 'put'])){ 

            if(($this->request->getData('btnProceed') !== null)) {
                $csvPostdata = $this->request->getData();
                 
                $colstext = explode(",", $csvPostdata['colstext']);
                $this->cols = $colstext;

                if(!empty($csvPostdata['dt'])){
                    $trncol = $recordingdateCol ='';
                    foreach($this->cols as $id=>$value){ 
            
                        if(strtolower(str_replace(" ","", $value)) == "documentname"){ 
                            $trncol = $id; 
                        }
             
                        if(strtolower(str_replace(" ","", $value)) == "accounting"){
                            $this->accountingCol = $id;
                        }
                    } 
 

                    foreach($csvPostdata['dt'] as $index => $items){
                        $records = array();
                        $records = explode("#sep#", $items);

                        $queryparams = array();
		                $queryparams = explode("#updsql#", $records[0]);
                         
                        $field_value_array = $postData = array();
                        foreach($queryparams as $fields_value){ 
                            $field_value_array = explode("=", $fields_value); 
                            
                            if(isset($csvPostdata['recdtfieldissueinput'])) {
                                if($field_value_array[0] == 'RecordingDate') {
                                    $field_value_array[1] = $csvPostdata['recdtfieldissueinput'][$index];
                                }
                            } 
                            $postData[] = $field_value_array[1];
                        } 
                          
                        if(isset($postData[$trncol])){
                            $clifnoarr = explode(".", $postData[$trncol]);
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
                                 if(in_array(strtolower($accData['CountyRecordingFee']), $erarray) || in_array(strtolower($accData['Taxes']), $erarray) ||
                                    in_array(strtolower($accData['AdditionalFees']), $erarray) || in_array(strtolower($accData['Total']), $erarray)){
                                    $erecrows[] = $postData;
                                }else{
                                    $returnAccounting = $this->accountingUpdate($records[2], $records[1], $accData, $postData);
                                    $updstracc .= $returnAccounting;
                                }
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
                    /* $csvRecordsFilename =  preg_replace('/[^A-Z0-9._]/i', '_', $csvRecordsFilename);
                    $filename = $csvRecordsFilename;
                  
                    if(file_exists($destination.$filename)&& !(empty($filename)))
                    {
                        $ExplodeFileName = explode(".",$filename);
                        $ExplodeFileName[sizeof($ExplodeFileName)-2] .= "_".$this->CustomPagination->randomDigit();
                        $filename = implode(".", $ExplodeFileName);
                        
                    } */
                    $date = date('YmdHis');
                    $filename = "CSCRecordsImport_" . $date .".csv" ;  
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
                                     
                                    if(!in_array(strtolower(str_replace(" ","", $value)), $this->CSVFields)){ 
                                        $errorArr['isNotMatch'][] = $value; 
                                    }
                        
                                    if(strtolower(str_replace(" ","", $value)) == "documentname"){ 
                                        $trncol = $id; 
                                    }
                        
                                    if(strtolower(str_replace(" ","", $value)) == "recordingdate"){
                                        $recordingdateCol = $id;
                                    }
                                    if(strtolower(str_replace(" ","", $value)) == "accounting"){
                                        $this->accountingCol = $id;
                                    }
                                }else{ 
                                    $errorArr['errorArr'][] = "CSV file contain empty headers"; 
                                }
                            } 

                            if(!empty(array_filter($errorArr))){
                                goto errordisplay;
                            } 
                           
                            while($data = fgetcsv($myFile)) {
              
                                if (empty(array_filter($data)))
                                {
                                    continue;
                                }
                             
                              
                                // insert / update data
                                if(!empty(array_filter($data))) {
                                  if(isset($data[$trncol])){
                                    $clifnoarr = explode(".", $data[$trncol]);
                                  }
                                
                                    $documentNumber = $data[$trncol]; 
                                    $tagreferenceno = $this->FilesMainData->CheckPartnerFileNumber($documentNumber);
                
                                    if(!empty($tagreferenceno) && $tagreferenceno['Id'] != "")
                                    { 
                                        $checkInData = $this->FilesCheckinData->getCheckInDataCSC($tagreferenceno['Id']);

                                        $recdtfieldissue = 0; 
                                        if (!empty($data[$recordingdateCol])){
                                            // Empty recording date
                                            $recdtfieldissue = 1;
                                        } 

                                        $countCheckin = count($checkInData);
                                        if($countCheckin > 1){ 
                                            $returnDocType = $this->checkMultiDocType($checkInData, $data, $errorcntr, $recdtfieldissue); 
                                            $multipleupdstr .= $returnDocType; 
                                            $errorcntr++;
                                        } // if > 1
                                        elseif($countCheckin  == 1){
                            
                                            if($checkInData[0]["DocumentReceived"] != "Y"){ 
                                                // qc insert update
                                                $qcReturn = $this->qcSaveUpdate($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], $clifnoarr[0]);
                                                $insstrqc .= $qcReturn['insstrqc'];
                                                $updstrqc .= $qcReturn['updstrqc'];   

                                                // update files_checkin_data set DocumentReceived = 'Y'  
                                                $this->FilesCheckinData->updateDocumentStatus('Y', $checkInData[0]['Id']);
                                                // insert public notes
                                                $this->addPublicNotes($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], 'Record document status update', 'Fcd');
                                            } 
                                            
                                            // select accounting data
                                            $accData = $this->FilesAccountingData->getfilesAccountingData($checkInData[0]['RecId'], $checkInData[0]['TransactionType']); 
                                
                                            if(!empty($accData)){ 
                                                $erarray = array("e-record", "erecord");
                                                if($accData['RecId'] != ""){
                                                    $returnAccounting = $this->accountingUpdate($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], $accData, $data);
                                                    $updstracc .= $returnAccounting; 
                                                    
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
                            } // End While 
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
            $fwViewData['erecrows'] = $this->setErrorTable($erecrows);
            $fwViewData['errrowsCFN'] = $this->setErrorTable($errrowsCFN);
            $fwViewData['errrowsQC'] = $this->setErrorTable($errrowsQC); 

            if(isset($multipleupdstr) && $multipleupdstr != ""){
                $fwViewData['multipleupdstr'] = $this->setErrorTable($multipleupdstr); 
            }

            if($insstracc != ""){
                $fwViewData['insstracc'] = $this->setRecordTable($insstracc); 
            }
            if($insstrship != ""){
                $fwViewData['insstrship'] = $this->setRecordTable($insstrship);  
            }
            if($insstrrec != ""){
                $fwViewData['insstrrec'] = $this->setRecordTable($insstrrec);  
            }
            if($updstracc != ""){
                $fwViewData['updstracc'] = $this->setRecordTable($updstracc);   
            }
            if($updstrship != ""){
                $fwViewData['updstrship'] = $this->setRecordTable($updstrship);  
            }
            if($updstrrec != ""){
                $fwViewData['updstrrec'] = $this->setRecordTable($updstrrec); 
            } 

        }
 
        errordisplay:{
            if(!empty(array_filter($errorArr))){ 
                $this->flashErrorMsg($errorArr, $this->CSVFields); //
            }
        }

        $this->set('FilesMainData',$FilesMainData);
        $this->set('fwViewData',$fwViewData);
        
        $this->set('_serialize', ['FilesMainData']);

    } 

    public function setErrorTable($errorData){ 
        $fwViewText = "";
        if(is_countable($errorData) && sizeof($errorData)>0){
    
            $fwViewText = "<table id='datatable_example' class='table dataTable order-column stripe table-striped table-bordered no-footer'><thead><tr><th class='headercelllisting'><b>".implode("</b></th><th class='headercelllisting'><b>",$this->cols)."</b></th></tr></thead>";
            $fwViewText .= "</tbody>";
            foreach($errorData as $errorKey){
                $fwViewText .= "<tr><td>".implode("</td><td>",$errorKey)."</td></tr>";
            }
            $fwViewText .= "</tbody></table>";
           
        } 
        return $fwViewText;
    }

    public function setRecordTable($tdData){
       return "<table id='datatable_example' class='table dataTable order-column stripe table-striped table-bordered no-footer'><thead><tr><th class='headercelllisting'><b>".implode("</b></th><th class='headercelllisting'><b>", $this->cols)."</b></th></tr></thead><tbody>".$tdData."</tbody></table>";
    }

    public function qcSaveUpdate($RecId,$TransactionType, $clifnoarr='', $queryparams=''){
        $qcData = $this->FilesQcData->getQCData($RecId, $TransactionType); // select data
        $insstrtdqc = $insstrqc=""; $updstrtdqc = $updstrqc = ""; $errrowsQC = [];  $data1 = array();
        if(empty($qcData)){
            // insert qc data
            $qcinsert = ['RecId'=>$RecId, 'TransactionType'=>$TransactionType, 'UserId'=>$this->currentUser->user_id, 'Status'=>'OK',   'QCProcessingDate'=>Date("Y-m-d"), 'QCProcessingTime'=>Date("H:i:s")];
           
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
 

    public function accountingInsert($RecId, $TransactionType, $data){
        $updsqlfieldsacc = array();  
        $updsqlfieldsacc["RecId"] = $RecId; 
        $updsqlfieldsacc["TransactionType"] = $TransactionType;
        
        $insstrtdacc = $insstracc = "";  
        $recfees = 0;
        $tax = 0;
        $total = 0;
 
        foreach($this->cols as $colid => $coltext){
            if(strtolower(str_replace(" ","", $coltext)) != "documentname"){
                //for accounting
                //print_r($coltext);
                if(in_array(strtolower(str_replace(" ","", $coltext)), $this->CSVFieldsAcc)){
                    if(strtolower(str_replace(" ","", $coltext)) == "total"){
                        $total = $data[$colid];
                        $updsqlfieldsacc[$this->DBFieldsAcc[strtolower(str_replace(" ","", $coltext))]] = floatval(preg_replace("/[^-0-9\.]/","",$data[$colid]));
                        
                        if(isset($data[$this->accountingCol]) && ($data[$this->accountingCol] == "I")){
                            $updsqlfieldsacc["EPortalActual"] = $total; 
                            $updsqlfieldsacc["UploadedTotal"] = $total; 
                        }
                        $updsqlfieldsacc["total_final_fees"] = $total;
                    }elseif(strtolower(str_replace(" ","", $coltext)) == "Countyrecordingfee"){
                        $recfees = $data[$colid];
                        $updsqlfieldsacc[$this->DBFieldsAcc[strtolower(str_replace(" ","", $coltext))]] = floatval(preg_replace("/[^-0-9\.]/","",$data[$colid]));

                        if(isset($data[$this->accountingCol]) && ($data[$this->accountingCol] == "I")){
                            $updsqlfieldsacc["UploadedCountyrecordingfee"] = $recfees; 
                        }
                        $updsqlfieldsacc["jrf_final_fees"] = $recfees;
                    }elseif(strtolower(str_replace(" ","", $coltext)) == "taxes"){
                        $tax = $data[$colid];
                        $updsqlfieldsacc[$this->DBFieldsAcc[strtolower(str_replace(" ","", $coltext))]] = floatval(preg_replace("/[^-0-9\.]/","",$data[$colid]));
                        
                        if(isset($data[$this->accountingCol]) && ($data[$this->accountingCol] == "I")){
                            $updsqlfieldsacc["UploadedTaxes"] = $tax; 
                        }
                        $updsqlfieldsacc["it_final_fees"] = $tax;
                    }elseif(strtolower(str_replace(" ","", $coltext)) == "processingdate"){
                        if(isset($data[$this->accountingCol]) && ($data[$this->accountingCol] == "I")){
                            $updsqlfieldsacc["UploadedDateTime"] = date("Y-m-d H:i:s"); 
                        }
                        $updsqlfieldsacc[$this->DBFieldsAcc[strtolower(str_replace(" ","", $coltext))]] = date("Y-m-d", strtotime($data[$colid]));
                    }else{
                        $updsqlfieldsacc[$this->DBFieldsAcc[strtolower(str_replace(" ","", $coltext))]] = $data[$colid]; 
                    }
                }
            }
            $insstrtdacc .= "<td>".$data[$colid]."</td>";
        } 

 
        if(isset($data[$this->accountingCol]) && ($data[$this->accountingCol] == "I")){  
            $updsqlfieldsacc["UploadedAdditionalfees"] =  $data[7];  
        } 
        $updsqlfieldsacc["AdditionalFees"] =0;  
        $updsqlfieldsacc["of_final_fees"] = 0;
        $updsqlfieldsacc["UserId"] = $this->currentUser->user_id; 
        $updsqlfieldsacc["LastModified"] = date("Y-m-d");

        // insert accounting
            $this->FilesAccountingData->insertNewAccountData($updsqlfieldsacc);
            $insstracc .= "<tr>".$insstrtdacc."</tr>";
        // public notes for accounting
        $Regarding ="<b>Accounting Insert </b> (Jurisdiction Recording Fee: ".$recfees.", Intangible / Mtg Tax: ".$tax.", Total: ".$total.")";
        $this->addPublicNotes($RecId, $TransactionType, $Regarding, 'Fad');

        return $insstracc;
    }

    public function accountingUpdate($RecId, $TransactionType, $accData, $data){ 
     
        $existingaccdata = '<b>Existing Accounting Data</b>: <br>CountyRecordingFee = "'.$accData['CountyRecordingFee'].'", Taxes = "'.$accData['Taxes'].'", AdditionalFees = "'.$accData['AdditionalFees'].'", Total = "'.$accData['Total'].'"';
        $updstrtdacc = $updstracc = ""; 
        $updsqlacc = array(); 
        $recfees = 0;
        $tax = 0;
        $total = 0;
     
        foreach($this->cols as $colid => $coltext){
            if(strtolower(str_replace(" ","", $coltext)) != "documentname"){
                //for accounting
                if(in_array(strtolower(str_replace(" ","", $coltext)), $this->CSVFieldsAcc)){

                    if(strtolower(str_replace(" ","", $coltext)) == "total"){
                        $total = $data[$colid];
                        if(isset($data[$this->accountingCol]) && ($data[$this->accountingCol] == "I")){
                            $updsqlacc["EPortalActual"] = $total;
                            $updsqlacc["UploadedTotal"] = $total;
                        }else{
                            $updsqlacc[$this->DBFieldsAcc[strtolower(str_replace(" ","", $coltext))]] =  floatval(preg_replace("/[^-0-9\.]/","",$data[$colid])) ;
                        }
                        $updsqlacc["total_final_fees"] = $total;
                    }elseif(strtolower(str_replace(" ","", $coltext)) == "Countyrecordingfee"){
                        $recfees = $data[$colid];
                        if(isset($data[$this->accountingCol]) && ($data[$this->accountingCol] == "I")){
                            $updsqlacc["UploadedCountyrecordingfee"] =$recfees;
                        }else{
                            $updsqlacc[$this->DBFieldsAcc[strtolower(str_replace(" ","", $coltext))]] = floatval(preg_replace("/[^-0-9\.]/","",$data[$colid]));
                        }
                        $updsqlacc["jrf_final_fees"] = $recfees;
                    }elseif(strtolower(str_replace(" ","", $coltext)) == "taxes"){
                        $tax = $data[$colid];
                        if(isset($data[$this->accountingCol]) && ($data[$this->accountingCol] == "I")){
                            $updsqlacc["UploadedTaxes"] = $tax;
                        }else{
                            $updsqlacc[$this->DBFieldsAcc[strtolower(str_replace(" ","", $coltext))]] = floatval(preg_replace("/[^-0-9\.]/","",$data[$colid]));
                        }
                        $updsqlacc["it_final_fees"] = $tax;
                    } 
                    elseif(strtolower(str_replace(" ","", $coltext)) == "processingdate"){
                        if(isset($data[$this->accountingCol]) && ($data[$this->accountingCol] == "I")){
                            $updsqlacc["UploadedDateTime"] = date("Y-m-d H:i:s");
                        }else{
                            $updsqlacc[$this->DBFieldsAcc[strtolower(str_replace(" ","", $coltext))]] = date("Y-m-d", strtotime($data[$colid]));
                        }
                    }else{
                        $updsqlacc[$this->DBFieldsAcc[strtolower(str_replace(" ","", $coltext))]] = $data[$colid];
                    }


                }
            }
            $updstrtdacc .= "<td>".$data[$colid]."</td>";
        } // foreach
 
        
        if(isset($data[$this->accountingCol]) && ($data[$this->accountingCol] == "I")){  
            $updsqlacc["UploadedAdditionalfees"] = $data[7]; // ServiceFee ==> 7 in column
            //$updsqlacc["of_final_fees"] = $data[7];
 
        }else{
            $updsqlacc["AdditionalFees"] =0;
            $updsqlacc["of_final_fees"] = 0;
        }
        $updsqlacc["UserId"] = $this->currentUser->user_id;
        
        // update accounting table 
        $this->FilesAccountingData->updateAccountDataCSC($accData['accountId'], $updsqlacc);
         
        $updstracc .= "<tr>".$updstrtdacc."</tr>";
 
        // insert public notes accounting
        $Regarding ="<b>Accounting update</b> (Jurisdiction Recording Fee: ".$recfees.", Intangible / Mtg Tax: ".$tax.", Total: ".$total.")";

        if(isset($data[$this->accountingCol]) && ($data[$this->accountingCol] == "I")){
            $Regarding .= " (Accounting: I)";
        }
        $this->addPublicNotes($RecId, $TransactionType, $Regarding, 'Fad');

        return $updstracc;
    }

    public function shippingSaveUpdate($RecId, $TransactionType, $data){
        $insstrtdship = ""; $insstrship=""; $updstrtdship = ""; $updstrship="";
        $shiptoCountyData = $this->FilesShiptoCountyData->fetchS2CDataCSC($RecId, $TransactionType);
        if(empty($shiptoCountyData)){
            // insert shipping data

            $updsqlfieldsship = array();
            $updsqlvaluesship = array();

            $updsqlfieldsship["RecId"] = $RecId;  
            $updsqlfieldsship["TransactionType"] = $TransactionType;
              
            foreach($this->cols as $colid => $coltext){
                if(strtolower(str_replace(" ","", $coltext)) != "documentname"){

                    if(in_array(strtolower(str_replace(" ","", $coltext)), $this->CSVFieldsShip)){

                        if(strtolower(str_replace(" ","", $coltext)) == "processingdate"){
                            $updsqlfieldsship[$this->DBFieldsShip[strtolower(str_replace(" ","", $coltext))]] = str_replace("'","", date("Y-m-d", strtotime($data[$colid])));
                        }else{
                            $updsqlfieldsship[$this->DBFieldsShip[strtolower(str_replace(" ","", $coltext))]] = $data[$colid];
                        } 
                    }
                }
                $insstrtdship .= "<td>".$data[$colid]."</td>";
            }
            if(!in_array("CarrierName", $updsqlfieldsship)){
                $updsqlfieldsship["CarrierName"] = "E-Record"; 
                $updsqlfieldsship["CarrierTrackingNo"] = "E-Record";
                $Regarding ="<b>Shipping insert</b> (CarrierName: E-Record, CarrierTrackingNo: E-Record)";
            } else {
                $Regarding ="Shipping insert";
            }

            $updsqlfieldsship["UserId"] = $this->currentUser->user_id;
            
            // insert
            $this->FilesShiptoCountyData->saveShippingData($updsqlfieldsship);
               
            $insstrship .= "<tr>".$insstrtdship."</tr>";
            // insert public data ship 
            $this->addPublicNotes($RecId, $TransactionType, $Regarding, 'Fsd');
        }else{
            // update shipping data 
           
            $updsqlship = array();
            $CarrierNameexist = 0;
            foreach($this->cols as $colid => $coltext){
                if(strtolower(str_replace(" ","", $coltext)) != "documentname"){
                    //for accounting
                    if(in_array(strtolower(str_replace(" ","", $coltext)), $this->CSVFieldsShip)){

                        if(strtolower(str_replace(" ","", $coltext)) == "processingdate"){
                            $updsqlship[$this->DBFieldsShip[strtolower(str_replace(" ","", $coltext))]] = str_replace("'","", date("Y-m-d", strtotime($data[$colid])));
                        }else{
                            $updsqlship[$this->DBFieldsShip[strtolower(str_replace(" ","", $coltext))]] = $data[$colid];
                        }
 
                        if($this->DBFieldsShip[strtolower(str_replace(" ","", $coltext))] == "CarrierName"){
                            $CarrierNameexist = 1;
                        }
                    }
                }
                //Check this variable for other sections
                $updstrtdship .= "<td>".$data[$colid]."</td>";
            }
            if(!$CarrierNameexist){
                $updsqlship["CarrierName"] = 'E-Record';
                $updsqlship["CarrierTrackingNo"] = 'E-Record';
                $Regarding ="<b>Shipping update</b> (CarrierName: E-Record, CarrierTrackingNo: E-Record)";
            } else {
                $Regarding ="Shipping update";
            }

            $updsqlship["UserId"] =$this->currentUser->user_id;
           
            $this->FilesShiptoCountyData->updateShippingData($shiptoCountyData['Id'], $updsqlship);
       
            $updstrship .= "<tr>".$updstrtdship."</tr>";
            // insert public data
            $this->addPublicNotes($RecId, $TransactionType, $Regarding, 'Fsd');
        }

       return ['insstrship'=>$insstrship, 'updstrship'=>$updstrship];
    }


    public function recordingSaveUpdate($RecId, $TransactionType, $data){
        $recordingData = $this->FilesRecordingData->fetchRecordingDataCSC($RecId, $TransactionType);
        $insstrtdrec = ""; $insstrrec = ""; $updstrtdrec = ""; $updstrrec = "";
        if(empty($recordingData)){
            // insert Recording data
            $updsqlfieldsrec = array();
            $updsqlvaluesrec = array();

            $updsqlfieldsrec["RecId"] = $RecId;  
            $updsqlfieldsrec["TransactionType"] = $TransactionType;
     
            foreach($this->cols as $colid => $coltext){
                if(strtolower(str_replace(" ","", $coltext)) != "documentname"){
                    if(in_array(strtolower(str_replace(" ","", $coltext)), $this->CSVFieldsRec)){
                        
                        if(strtolower(str_replace(" ","", $coltext)) == "instrumentnumber"){
                            $updsqlfieldsrec[$this->DBFieldsRec[strtolower(str_replace(" ","", $coltext))]] = str_replace("'","", $data[$colid]);
                        }elseif((strtolower(str_replace(" ","", $coltext)) == "recordingdate") || (strtolower(str_replace(" ","", $coltext)) == "processingdate")){
                            $updsqlfieldsrec[$this->DBFieldsRec[strtolower(str_replace(" ","", $coltext))]] = str_replace("'","", date("Y-m-d", strtotime($data[$colid])));
                        }else{
                            $updsqlfieldsrec[$this->DBFieldsRec[strtolower(str_replace(" ","", $coltext))]] = $data[$colid];
                        }

                    }
                }
                $insstrtdrec .= "<td>".$data[$colid]."</td>";
            } 

            $updsqlfieldsrec["UserId"] = $this->currentUser->user_id;
                
            $updsqlfieldsrec["KNI"] = 2;  
            $insstrrec .= "<tr>".$insstrtdrec."</tr>";
             
            $this->FilesRecordingData->saveFRDData($updsqlfieldsrec); 
            // inseert public data recording
            $Regarding = " <b>Recording insert</b>(File: ".$updsqlfieldsrec['File'].", Recording Date: ".$updsqlfieldsrec['RecordingDate'].", Recording Time: ".$updsqlfieldsrec['RecordingTime'].",Instrument Number: ".$updsqlfieldsrec['InstrumentNumber'].", Book: ".$updsqlfieldsrec['Book'].", Page: ".$updsqlfieldsrec['Page'].", Recording Processing Date: ".$updsqlfieldsrec['RecordingProcessingDate'].")";
            $this->addPublicNotes($RecId, $TransactionType, $Regarding, 'Frd');

        }else{
            // update Recording data 
            
            $updsqlrec = array();
            foreach($this->cols as $colid => $coltext){
                if(strtolower(str_replace(" ","", $coltext)) != "documentname"){
                    //for recounting
                    if(in_array(strtolower(str_replace(" ","", $coltext)), $this->CSVFieldsRec)){
                        if(trim($data[$colid]) != ""){
                            if(strtolower(str_replace(" ","", $coltext)) == "instrumentnumber"){
                                $updsqlrec[$this->DBFieldsRec[strtolower(str_replace(" ","", $coltext))]] =  str_replace("'","", $data[$colid]) ;
                            }elseif((strtolower(str_replace(" ","", $coltext)) == "recordingdate") || (strtolower(str_replace(" ","", $coltext)) == "processingdate")){
                                $updsqlrec[$this->DBFieldsRec[strtolower(str_replace(" ","", $coltext))]] = str_replace("'","", date("Y-m-d", strtotime($data[$colid])));
                            }else{
                                $updsqlrec[$this->DBFieldsRec[strtolower(str_replace(" ","", $coltext))]] =  $data[$colid] ;
                            }
                        }
                    }
                }
                //Check this variable for other sections
                $updstrtdrec .= "<td>".$data[$colid]."</td>";
            }
            $updsqlrec["UserId"] =  $this->currentUser->user_id;
            $updsqlrec["KNI"] = 2;

            $updstrrec .= "<tr>".$updstrtdrec."</tr>";
             
            $this->FilesRecordingData->updateFRDData($recordingData['Id'], $updsqlrec);
         
            // insert public data recording 
            $Regarding = " <b>Recording update</b>(File: ".$updsqlrec['File'].", Recording Date: ".$updsqlrec['RecordingDate'].", Recording Time: ".$updsqlrec['RecordingTime'].",Instrument Number: ".$updsqlrec['InstrumentNumber'].", Book: ".$updsqlrec['Book'].", Page: ".$updsqlrec['Page'].", Recording Processing Date: ".$updsqlrec['RecordingProcessingDate'].")";
            $this->addPublicNotes($RecId, $TransactionType, $Regarding, 'Frd');
           
        }

        return ['insstrrec'=>$insstrrec, 'updstrrec'=>$updstrrec];
    }

    public function checkMultiDocType($checkInData, $data, $errorcntr, $recdtfieldissue){
        $rowdone = 0; $multipleupdstrtd= $multipleupdstr =""; $docname = $multopt = "";
        $countCheckin = count($checkInData);
        foreach($checkInData as $checkin){ 
            if(!$rowdone){ 
                $updsql = array(); 
                foreach($this->cols as $colid => $coltext){
                    if(in_array(strtolower(str_replace(" ","", $coltext)), $this->CSVFieldsAcc)){
                        $updsql[] = $this->DBFieldsAcc[strtolower(str_replace(" ","", $coltext))]."=".$data[$colid];
                    }elseif(in_array(strtolower(str_replace(" ","", $coltext)), $this->CSVFieldsShip)){
                        $updsql[] = $this->DBFieldsShip[strtolower(str_replace(" ","", $coltext))]."=".$data[$colid];
                    }elseif(in_array(strtolower(str_replace(" ","", $coltext)), $this->CSVFieldsRec)){
                        if(strtolower(str_replace(" ","", $coltext)) == "instrumentnumber"){
                            $updsql[] = $this->DBFieldsRec[strtolower(str_replace(" ","", $coltext))]."=".str_replace("'","", $data[$colid]);
                        }else{
                            $updsql[] = $this->DBFieldsRec[strtolower(str_replace(" ","", $coltext))]."=".$data[$colid];
                        }
                    }elseif(in_array(strtolower(str_replace(" ","", $coltext)), $this->CSVFieldsOther)){
                        $updsql[] = $coltext."=".$data[$colid];
                    }

                    if(strtolower(str_replace(" ","", $coltext)) == "documentname"){
                        $multipleupdstrtd .= "<td>".$data[$colid]." #dt#</td>";
                        $docname = $data[$colid];

                    }elseif(strtolower(str_replace(" ","", $coltext)) == "recordingdate"){
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
                

                $multipleupdstr .= "<tr>".$multipleupdstrtd."</tr>";
                $rowdone = 1;
            }
            
            if($countCheckin > 1){
                $docType= $this->DocumentTypeMst->getDocumentTitle($checkin["TransactionType"]);
                $multopt .= '<option value = "' . implode("#updsql#", $updsql) . '#sep#' . $checkin["TransactionType"] . '#sep#' . $checkin["RecId"] .'#sep#U#sep#'.$docname.'#sep#'.$this->currentUser->user_id.'">' . $docType['Title'] . '</option>';
            }/* else{ 
                
                $multopt = '<input type="text" name="dt['.$errorcntr.']" value = "' . implode("#updsql#", $updsql) . '#sep#' . $checkin["TransactionType"] . '#sep#' . $checkin["RecId"] .'#sep#U#sep#'.$docname.'#sep#'.$this->currentUser->user_id.'">';
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
        $this->PublicNotes->insertNewPublicNotes($recId, $docType, $this->currentUser->user_id, 'CSC '.$regarding, $section,false,'CSC');
    }
   
}