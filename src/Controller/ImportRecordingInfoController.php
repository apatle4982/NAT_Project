<?php
declare(strict_types=1);
namespace App\Controller;
/**
 * ImportRecordingInfo Controller
 *
 * @method \App\Model\Entity\ImportRecordingInfo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ImportRecordingInfoController extends AppController
{
    public $cols;  public $accountingCol;    
    public $CSVFields;  
    
    public function initialize(): void
	{
	   parent::initialize();
       $this->loadModel("CompanyMst");
	   $this->loadModel("FilesMainData");
       $this->loadModel("FilesCheckinData");
       $this->loadModel('FilesShiptoCountyData');
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
        $this->CSVFields = array('fortheperiod', 'documentname', 'e', 'b', 'p', 'recorddate', 'time');
        $this->DBFields = array();

        $this->DBFields['fortheperiod'] = 'RecordingProcessingDate';
        $this->DBFields['documentname'] = 'PartnerFileNumber';
        $this->DBFields['e'] = 'InstrumentNumber';
        $this->DBFields['b'] = 'Book';
        $this->DBFields['p'] = 'Page';
        $this->DBFields['recorddate'] = 'RecordingDate'; 
        $this->DBFields['time'] = 'RecordingTime'; 
        
        $delimiter = ",";
 
        $errorArr = [];
		$successArr = [];
        $isFileUpload = false;
        $updstr = "";
        $insstr = "";
        $insstracc = "";  
        $updstracc = "";
        $errorcntr = 0;   
        $multipleupdstr ="";
        $documentNumber = "";  
  
        $errcols = array(); 
        $errrows = array();
        $errrowsCFN = array(); 
        $errrowsSHIP = array(); 
 
        $pageTitle = 'Import Recording Info';
		$this->set(compact('pageTitle'));

        $FilesMainData = $this->FilesMainData->newEmptyEntity();

        if($this->request->is(['patch', 'post', 'put'])){ 

            $formpostdata = $this->request->getData();
            $this->set('formpostdata', $formpostdata);

            if(($this->request->getData('btnProceed') !== null)) {
                $csvPostdata = $this->request->getData();
                 
                $colstext = explode(",", $csvPostdata['colstext']);
                $this->cols = $colstext;

                if(!empty($csvPostdata['dt'])){
                     
                    foreach($csvPostdata['dt'] as $index => $items){
                        $records = array();
                        $records = explode("#sep#", $items);
                        
                        $queryparams = array();
		                $queryparams = explode("#updsql#", $records[0]);
                         
                        $field_value_array = $postData = array();
                        foreach($queryparams as $fields_value){ 
                            $field_value_array = explode("=", $fields_value); 
                            if($field_value_array[0] == 'RecordingProcessingDate' || $field_value_array[0] == 'RecordingDate')
                                $postData[] = date("Y-m-d", strtotime($field_value_array[1]));
                            else
                                $postData[] = $field_value_array[1];

                        } 
                           

                        // check record in accounting
                        $recData = $this->FilesRecordingData->getRecordingData($records[2], $records[1]); 
                                                
                        if(!empty($recData)){
 
                            if($recData['RecId'] != ""){  
                                $returnRecording = $this->recordingUpdate($records[2], $records[1], $recData, $postData); 
                                $updstracc .= $returnRecording;
                            }
                           
                        } else{ 
                            $shipData = $this->FilesShiptoCountyData->getS2CData($records[2], $records[1]); 
                            if($shipData['RecId'] != ""){ 
                                // recording insert
                                $returnAcc = $this->recordingInsert($records[2], $records[1], $postData);
                                $insstracc .= $returnAcc; 
                            } else {

                                $errrowsSHIPcell = array();
                                $queryparams = array();
                                $queryparams = explode("#updsql#", $records[0]);
                                foreach($queryparams as $fields_value){
                                    $field_value_array = array();
                                    $field_value_array = explode("=", $fields_value);

                                    if($field_value_array[0] == "File"){
                                        $docType= $this->DocumentTypeMst->getDocumentTitle($records[1]);
                                        $errrowsSHIPcell[] = $field_value_array[1]." (Document type: ".$docType['Title'].")";
                                    }elseif($field_value_array[0] != "UserId" && $field_value_array[0] != "KNI"){
                                        $errrowsSHIPcell[] = $field_value_array[1];
                                    }
                                }
                                $errrowsSHIP[] = $errrowsSHIPcell;
 
                            } 
                        }

                    } 
                }
                
            } // if proceed button end

            if(($this->request->getData('saveBtn') !== null)) {

                $isFileUpload   = true;
                $company_id = $this->request->getData('company_id');
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
                    $filename = "RecordsImport_" . $date .".csv" ;  
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
                            
                            $trncol = ''; 
                            foreach($this->cols as $id=>$value){
                                if(!empty($value)){ 
                                     
                                    if(!in_array(strtolower(str_replace(" ","", $value)), $this->CSVFields)){ 
                                        $errorArr['isNotMatch'][] = $value; 
                                    }
                        
                                    if(strtolower(str_replace(" ","", $value)) == "documentname"){ 
                                        $trncol = $id; 
                                    }
                                }else{ 
                                    $errorArr['errorArr'][] = "CSV file contain empty headers"; 
                                }
                            } 

                            if(!empty(array_filter($errorArr)) || !empty(array_filter($errcols))){
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
                                
                                    $documentNumber = $clifnoarr[0]; 
                                    $tagreferenceno = $this->FilesMainData->CheckPartnerFileNumber($documentNumber,$company_id);
                
                                    if(!empty($tagreferenceno) && $tagreferenceno['Id'] != "")
                                    { 
                                        $checkInData = $this->FilesCheckinData->getCheckInDataCSC($tagreferenceno['Id']);
  
                                        $countCheckin = count($checkInData);
                                        if($countCheckin > 1){ 
                                            $returnDocType = $this->checkMultiDocType($checkInData, $data); 
                                            $multipleupdstr .= $returnDocType; 
                                        } // if > 1
                                        elseif($countCheckin  == 1){                             
                                            // select accounting data
                                            $recData = $this->FilesRecordingData->getRecordingData($checkInData[0]['RecId'], $checkInData[0]['TransactionType']); 
                                
                                            if(!empty($recData)){  
                                                if($recData['RecId'] != ""){
                                                    $returnRecording = $this->recordingUpdate($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], $recData, $data);
                                                    $updstracc .= $returnRecording;  
                                                } // if accounting
                                            }else{
                                                $shipData = $this->FilesShiptoCountyData->getS2CData($checkInData[0]['RecId'], $checkInData[0]['TransactionType']); 
                                                 
                                                if(!empty($shipData)){ 
                                                    if($shipData['RecId'] != ""){ 
                                                        // accounting insert
                                                        if(sizeof($this->DBFields) != sizeof($data)){
                                                            $errrows[] = $data;
                                                        }else{    
                                                            $returnAcc = $this->recordingInsert($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], $data);
                                                            $insstracc .= $returnAcc;
                                                        } 
                                                    }  
                                                } else {
                                                    $errrowsSHIP[] = $data;
                                                }

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
              
            $fwViewData['errrows'] = $this->setErrorTable($errrows); 
            $fwViewData['errrowsCFN'] = $this->setErrorTable($errrowsCFN);
            $fwViewData['errrowsSHIP'] = $this->setErrorTable($errrowsSHIP); 

            if(isset($multipleupdstr) && $multipleupdstr != ""){
                $fwViewData['multipleupdstr'] = $this->setErrorTable($multipleupdstr); 
            }

            if($insstracc != ""){
                $fwViewData['insstracc'] = $this->setRecordTable($insstracc); 
            }
              
            if($updstracc != ""){
                $fwViewData['updstracc'] = $this->setRecordTable($updstracc);   
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

        $companyMsts = $this->CompanyMst->companyListArray()->toArray();
        $this->set('companyMsts',$companyMsts);

    } 

    public function setErrorTable($errorData){ 
        $fwViewText = "";
        if(is_array($errorData)){
            if(is_countable($errorData) && sizeof($errorData)>0){
            
                $fwViewText = "<table id='datatable_example' class='table dataTable order-column stripe table-striped table-bordered no-footer'><thead><tr><th class='headercelllisting'><b>".implode("</b></th><th class='headercelllisting'><b>",$this->cols)."</b></th></tr></thead>";
                $fwViewText .= "</tbody>";
                foreach($errorData as $errorKey){ 
                    //$errorKey = $this->extractData($errorKey); 
                    $fwViewText .= "<tr><td>".implode("</td><td>",$errorKey)."</td></tr>";
                }
                $fwViewText .= "</tbody></table>";
            
            }
        }else{ 
            $fwViewText = "<table id='form-table' style='width:98%;margin:0 auto'><tr><td class='headercelllisting'><b>".implode("</b></td><td class='headercelllisting'><b>", $this->cols)."</b></td></tr>".$errorData."</table>";
        }     
        
        return $fwViewText;
    }

    public function setRecordTable($tdData){
       return "<table id='datatable_example' class='table dataTable order-column stripe table-striped table-bordered no-footer'><thead><tr><th class='headercelllisting'><b>".implode("</b></th><th class='headercelllisting'><b>", $this->cols)."</b></th></tr></thead><tbody>".$tdData."</tbody></table>";
    }
  
    public function recordingUpdate($RecId, $TransactionType, $recData, $data){
       
        $updstrtdrec = ""; $updstrrec = "";
        
        $updsqlrec = array();
        foreach($this->cols as $colid => $coltext){
   
            if(in_array(strtolower(str_replace(" ","", $coltext)), $this->CSVFields)){
                if(trim($data[$colid]) != ""){

                    if(strtolower(str_replace(" ","", $coltext)) == 'fortheperiod' || strtolower(str_replace(" ","", $coltext)) == 'recorddate') {
                        $updsqlrec[$this->DBFields[strtolower(str_replace(" ","", $coltext))]] =  date("Y-m-d", strtotime($data[$colid]));  
                    } elseif(strtolower(str_replace(" ","", $coltext)) == "documentname"){
                        $updsqlrec['File'] =  str_replace("'","", $data[$colid]) ;
                    }elseif(strtolower(str_replace(" ","", $coltext)) == "e"){
                        $instrnoarr = array();
                        $instrnoarr = explode("B", $data[$colid]); 
                        $updsqlrec['InstrumentNumber'] =  trim(substr($instrnoarr[0],1,strlen($instrnoarr[0]))) ;
                    }else{
                        $updsqlrec[$this->DBFields[strtolower(str_replace(" ","", $coltext))]] =  $data[$colid] ;
                    }
                }
            }
            
            $updstrtdrec .= "<td>".$data[$colid]."</td>";
        }
        $updsqlrec["UserId"] =  $this->currentUser->user_id;
        $updsqlrec["KNI"] = 2;

        $updstrrec .= "<tr>".$updstrtdrec."</tr>";
         
        $this->FilesRecordingData->updateFRDData($recData['Id'], $updsqlrec);
        
        // insert public data recording
        $Regarding = " <b>Recording Updated</b> (File: ".$updsqlrec['File'].", Recording Date: ".$updsqlrec['RecordingDate'].", Recording Time: ".$updsqlrec['RecordingTime'].",Instrument Number: ".$updsqlrec['InstrumentNumber'].", Book: ".$updsqlrec['Book'].", Page: ".$updsqlrec['Page'].", Recording Processing Date: ".$updsqlrec['RecordingProcessingDate'].")";
        $this->addPublicNotes($RecId, $TransactionType, $Regarding, 'Frd');
         
        return $updstrrec;
    }

    public function recordingInsert($RecId, $TransactionType, $data){
         
        $insstrtdrec = ""; $insstrrec = ""; 
        
        $updsqlfieldsrec = array(); 

        $updsqlfieldsrec["RecId"] = $RecId;  
        $updsqlfieldsrec["TransactionType"] = $TransactionType;
           
        foreach($this->cols as $colid => $coltext){
             
            if(in_array(strtolower(str_replace(" ","", $coltext)), $this->CSVFields)){
                
                if(strtolower(str_replace(" ","", $coltext)) == 'fortheperiod' || strtolower(str_replace(" ","", $coltext)) == 'recorddate') {
                    $updsqlfieldsrec[$this->DBFields[strtolower(str_replace(" ","", $coltext))]] =  date("Y-m-d", strtotime($data[$colid]));  
                } elseif(strtolower(str_replace(" ","", $coltext)) == "documentname"){
                    $updsqlfieldsrec['File'] =  str_replace("'","", $data[$colid]) ;
                }elseif(strtolower(str_replace(" ","", $coltext)) == "e"){
                    $instrnoarr = array();
                    $instrnoarr = explode("B", $data[$colid]);
                    $updsqlfieldsrec['InstrumentNumber'] =  trim(substr($instrnoarr[0],1,strlen($instrnoarr[0]))) ;
                }else{
                    $updsqlfieldsrec[$this->DBFields[strtolower(str_replace(" ","", $coltext))]] = $data[$colid];
                }

            }
            
            $insstrtdrec .= "<td>".$data[$colid]."</td>";
        } 

        $updsqlfieldsrec["UserId"] = $this->currentUser->user_id;            
        $updsqlfieldsrec["KNI"] = 2;  
        $insstrrec .= "<tr>".$insstrtdrec."</tr>";
              
        $this->FilesRecordingData->saveFRDData($updsqlfieldsrec); 
        // inseert public data recording
        $Regarding = " <b>Recording Added</b> (File: ".$updsqlfieldsrec['File'].", Recording Date: ".$updsqlfieldsrec['RecordingDate'].", Recording Time: ".$updsqlfieldsrec['RecordingTime'].",Instrument Number: ".$updsqlfieldsrec['InstrumentNumber'].", Book: ".$updsqlfieldsrec['Book'].", Page: ".$updsqlfieldsrec['Page'].", Recording Processing Date: ".$updsqlfieldsrec['RecordingProcessingDate'].")";
        $this->addPublicNotes($RecId, $TransactionType, $Regarding, 'Frd');
         
        return $insstrrec;
    }

   
    public function checkMultiDocType($checkInData, $data){
        $rowdone = 0; $multipleupdstrtd= $multipleupdstr =""; $docname = $multopt = "";
        $countCheckin = count($checkInData);
        foreach($checkInData as $checkin){ 
            if(!$rowdone){ 
                $updsql = array(); 

                foreach($this->cols as $colid => $coltext){
                    if(strtolower(str_replace(" ","", $coltext)) == "documentname"){
                        $updsql[] = "File=".$data[$colid];
                        $multipleupdstrtd .= "<td>".$data[$colid]." (#dt#)</td>";
                    }/* elseif(strtolower(str_replace(" ","", $coltext)) == "e"){
                        $instrnoarr = array();
                        $instrnoarr = explode("B", $data[$colid]);
                        $updsql[] = " InstrumentNumber=".trim(substr($instrnoarr[0],1,strlen($instrnoarr[0])));
                        $multipleupdstrtd .= "<td>".trim(substr($instrnoarr[0],1,strlen($instrnoarr[0])))."</td>";
                    } */else{
                        $updsql[] = $this->DBFields[strtolower(str_replace(" ","", $coltext))]."=".$data[$colid];
                        $multipleupdstrtd .= "<td>".$data[$colid]."</td>";
                    }
                }

                $updsql[] = "KNI=2"; 
 
                $multipleupdstr .= "<tr>".$multipleupdstrtd."</tr>";
                $rowdone = 1;
            }
            
            if($countCheckin > 1){
                $docType= $this->DocumentTypeMst->getDocumentTitle($checkin["TransactionType"]);
                $multopt .= '<option value = "' . implode("#updsql#", $updsql) . '#sep#' . $checkin["TransactionType"] . '#sep#' . $checkin["RecId"] .'#sep#U#sep#'.$docname.'#sep#'.$this->currentUser->user_id.'">' . $docType['Title'] . '</option>';
            } 
        }

        if($countCheckin > 1){
            $multipleupdstr = str_replace('#dt#', '<select name="dt[]" style="border:1px solid red" required><option value="">Select Document Type</option>'.$multopt.'</select>',$multipleupdstr);
        } 
        return $multipleupdstr;
 
    }
  
    public function addPublicNotes($recId, $docType, $regardingtext, $section){
        $regarding = (empty($regardingtext)) ? 'Record Added': $regardingtext;
        $this->PublicNotes->insertNewPublicNotes($recId, $docType, $this->currentUser->user_id, $regarding, $section, false, 'Import Recording CSV'); 
    }
   
}
