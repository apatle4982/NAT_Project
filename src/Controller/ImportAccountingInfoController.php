<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ImportAccountingInfo Controller
 *
 * @method \App\Model\Entity\ImportAccountingInfo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ImportAccountingInfoController extends AppController
{

    public $cols;  public $accountingCol;    
    public $CSVFields;  
    
    public function initialize(): void
	{
	   parent::initialize();
       $this->loadModel("CompanyMst");
	   $this->loadModel("FilesMainData");
       $this->loadModel("FilesCheckinData");
       $this->loadModel('FilesQcData');
       $this->loadModel("FilesAccountingData");  
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
        $this->CSVFields = array('fortheperiod', 'documentname', 'Countyrecordingfee', 'taxes', 'additionalfees', 'total');


        $this->DBFields = array();

        $this->DBFields['fortheperiod'] = 'AccountingProcessingDate';
        $this->DBFields['documentname'] = 'PartnerFileNumber';
        $this->DBFields['Countyrecordingfee'] = 'CountyRecordingFee';
        $this->DBFields['taxes'] = 'Taxes';
        $this->DBFields['additionalfees'] = 'AdditionalFees';
        $this->DBFields['total'] = 'Total'; 
        
        $delimiter = ",";
 
        $errorArr = [];
		$successArr = [];
        $isFileUpload = false;
        $updstr = "";
        $insstr = "";
        $insstrqc = $insstracc = "";  
        $updstrqc = $updstracc = "";
        $errorcntr = 0;   
        $multipleupdstr ="";
        $documentNumber = "";  
  
        $errcols = array(); 
        $errrows = array();
        $errrowsCFN = array(); 
        $errrowsQC = array();
        $erecrows = array();
 
        $pageTitle = 'Import Accounting Info';
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
                             
                            $postData[] = $field_value_array[1];
                        } 
                          
                        if(isset($postData[$trncol])){
                            $clifnoarr = explode(".", $postData[$trncol]);
                        }

                        // check record in accounting
                        $accData = $this->FilesAccountingData->getfilesAccountingData($records[2], $records[1]); 
                                   
                        if(!empty($accData)){
 
                            if($accData['RecId'] != ""){  
                                $returnAccounting = $this->accountingUpdate($records[2], $records[1], $accData, $postData); 
                                $updstracc .= $returnAccounting;
                            }
                           
                        } else{ 
                            $qcData = $this->FilesQcData->getNewFilesQcData($records[2], $records[1]); 
                            if($qcData['RecId'] != ""){ 
                                // accounting insert
                                $returnAcc = $this->accountingInsert($records[2], $records[1], $postData);
                                $insstracc .= $returnAcc; 
                            } else {

                                $errrowsQCcell = array();
                                $queryparams = array();
                                $queryparams = explode("#updsql#", $records[0]);
                                //print_r($queryparams);
                                foreach($queryparams as $fields_value){
                                    $field_value_array = array();
                                    $field_value_array = explode("=", $fields_value);
 
                                    if($field_value_array[0] == "PartnerFileNumber"){
                                        $docType= $this->DocumentTypeMst->getDocumentTitle($records[1]);
                                        $errrowsQCcell[] = $field_value_array[1].(($field_value_array[0] == "PartnerFileNumber") ? " (Document type: ".$docType['Title'].")" : "");
                                    }elseif($field_value_array[0] != "UserId"){
                                        $errrowsQCcell[] = $field_value_array[1];
                                    }
                                }
                                $errrowsQC[] = $errrowsQCcell; 
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
                            
                            $trncol = $recordingdateCol =''; 
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
                                            $accData = $this->FilesAccountingData->getfilesAccountingData($checkInData[0]['RecId'], $checkInData[0]['TransactionType']); 
                                
                                            if(!empty($accData)){  
                                                if($accData['RecId'] != ""){
                                                    $returnAccounting = $this->accountingUpdate($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], $accData, $data);
                                                    $updstracc .= $returnAccounting;  
                                                } // if accounting
                                            }else{
                                                $qcData = $this->FilesQcData->getNewFilesQcData($checkInData[0]['RecId'], $checkInData[0]['TransactionType']); 
                                                if(!empty($qcData)){ 
                                                    if($qcData['RecId'] != ""){ 
                                                        // accounting insert
                                                        $returnAcc = $this->accountingInsert($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], $data);
                                                        $insstracc .= $returnAcc; 
                                                    }  
                                                } else {
                                                    $errrowsQC[] = $data;
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
            $fwViewData['erecrows'] = $this->setErrorTable($erecrows);
            $fwViewData['errrowsCFN'] = $this->setErrorTable($errrowsCFN);
            $fwViewData['errrowsQC'] = $this->setErrorTable($errrowsQC); 

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
 
    public function accountingInsert($RecId, $TransactionType, $data){
        $updsqlfieldsacc = array();  
        $updsqlfieldsacc["RecId"] = $RecId; 
        $updsqlfieldsacc["TransactionType"] = $TransactionType;
        
        $insstrtdacc = $insstracc = "";  
        
        foreach($this->cols as $colid => $coltext){
            if(strtolower(str_replace(" ","", $coltext)) != "documentname"){  
                if(in_array(strtolower(str_replace(" ","", $coltext)), $this->CSVFields)){ 
                    if (strtolower(str_replace(" ","", $coltext)) == "total") {
                        $updsqlfieldsacc[$this->DBFields[strtolower(str_replace(" ","", $coltext))]] = $data[$colid];
                        $updsqlfieldsacc["total_final_fees"] = $data[$colid];
                    } elseif (strtolower(str_replace(" ","", $coltext)) == "Countyrecordingfee") {
                        $updsqlfieldsacc[$this->DBFields[strtolower(str_replace(" ","", $coltext))]] = $data[$colid];
                        $updsqlfieldsacc["jrf_final_fees"] = $data[$colid];
                    } elseif(strtolower(str_replace(" ","", $coltext)) == "taxes") { 
                        $updsqlfieldsacc[$this->DBFields[strtolower(str_replace(" ","", $coltext))]] = $data[$colid];
                        $updsqlfieldsacc["it_final_fees"] = $data[$colid];
                    } elseif(strtolower(str_replace(" ","", $coltext)) == "additionalfees") { 
                        $updsqlfieldsacc[$this->DBFields[strtolower(str_replace(" ","", $coltext))]] = $data[$colid];
                        $updsqlfieldsacc["of_final_fees"] = $data[$colid];
                    } elseif(strtolower(str_replace(" ","", $coltext)) == "fortheperiod") { 
                        $updsqlfieldsacc[$this->DBFields[strtolower(str_replace(" ","", $coltext))]] = date("Y-m-d", strtotime($data[$colid]));                        
                    } else {
                        $updsqlfieldsacc[$this->DBFields[strtolower(str_replace(" ","", $coltext))]] = $data[$colid];
                    }
                }
            }
            $insstrtdacc .= "<td>".$data[$colid]."</td>";
        } 
  
        $updsqlfieldsacc["UserId"] = $this->currentUser->user_id; 
        $updsqlfieldsacc["LastModified"] = date("Y-m-d");

        // insert accounting
        $this->FilesAccountingData->insertNewAccountData($updsqlfieldsacc);
        $insstracc .= "<tr>".$insstrtdacc."</tr>";
        // public notes for accounting 
        $Regarding ="<b>Accounting Added</b> (Jurisdiction Recording Fee: ".$updsqlfieldsacc['jrf_final_fees'].", Other Fees: ".$updsqlfieldsacc['of_final_fees'].", Intangible / Mtg Tax: ".$updsqlfieldsacc['it_final_fees'].", Total: ".$updsqlfieldsacc['total_final_fees'].")";
        $this->addPublicNotes($RecId, $TransactionType, $Regarding, 'Fad');

        return $insstracc;
    }

    public function accountingUpdate($RecId, $TransactionType, $accData, $data){ 
      
        $updstrtdacc = $updstracc = ""; 
        $updsqlacc = array(); 
         
        foreach($this->cols as $colid => $coltext){ 
            if(strtolower(str_replace(" ","", $coltext)) != "documentname"){ 
                if(in_array(strtolower(str_replace(" ","", $coltext)), $this->CSVFields)){
                    if (strtolower(str_replace(" ","", $coltext)) == "total") {
                        $updsqlacc[$this->DBFields[strtolower(str_replace(" ","", $coltext))]] = $data[$colid];
                        $updsqlacc["total_final_fees"] = $data[$colid];
                    } elseif (strtolower(str_replace(" ","", $coltext)) == "Countyrecordingfee") {
                        $updsqlacc[$this->DBFields[strtolower(str_replace(" ","", $coltext))]] = $data[$colid];
                        $updsqlacc["jrf_final_fees"] = $data[$colid];
                    } elseif(strtolower(str_replace(" ","", $coltext)) == "taxes") { 
                        $updsqlacc[$this->DBFields[strtolower(str_replace(" ","", $coltext))]] = $data[$colid];
                        $updsqlacc["it_final_fees"] = $data[$colid];
                    } elseif(strtolower(str_replace(" ","", $coltext)) == "additionalfees") { 
                        $updsqlacc[$this->DBFields[strtolower(str_replace(" ","", $coltext))]] = $data[$colid];
                        $updsqlacc["of_final_fees"] = $data[$colid];
                    } elseif(strtolower(str_replace(" ","", $coltext)) == "fortheperiod") { 
                        $updsqlacc[$this->DBFields[strtolower(str_replace(" ","", $coltext))]] = date("Y-m-d", strtotime($data[$colid]));                        
                    } else {
                        $updsqlacc[$this->DBFields[strtolower(str_replace(" ","", $coltext))]] = $data[$colid];
                    }                    
                } 
            }
            $updstrtdacc .= "<td>".$data[$colid]."</td>";
        } // foreach
  
        $updsqlacc["UserId"] = $this->currentUser->user_id;
   
        // update accounting table 
        $this->FilesAccountingData->updateAccountDataCSC($accData['accountId'], $updsqlacc);
         
        $updstracc .= "<tr>".$updstrtdacc."</tr>";
 
        // insert public notes accounting 
        $Regarding ="<b>Accounting Updated</b> (Jurisdiction Recording Fee: ".$updsqlacc['jrf_final_fees'].", Other Fees: ".$updsqlacc['of_final_fees'].", Intangible / Mtg Tax: ".$updsqlacc['it_final_fees'].", Total: ".$updsqlacc['total_final_fees'].")";
        $this->addPublicNotes($RecId, $TransactionType, $Regarding, 'Fad');

        return $updstracc;
    }
   
    public function checkMultiDocType($checkInData, $data){
        $rowdone = 0; $multipleupdstrtd= $multipleupdstr =""; $docname = $multopt = "";
        $countCheckin = count($checkInData);
        foreach($checkInData as $checkin){ 
            if(!$rowdone){ 
                $updsql = array(); 
                foreach($this->cols as $colid => $coltext){
                    if(in_array(strtolower(str_replace(" ","", $coltext)), $this->CSVFields)){
                        $updsql[] = $this->DBFields[strtolower(str_replace(" ","", $coltext))]."=".$data[$colid];
                    }
                    if(strtolower(str_replace(" ","", $coltext)) == "documentname"){
                        $multipleupdstrtd .= "<td>".$data[$colid]." #dt#</td>";
                        $docname = $data[$colid];

                    } else{
                        $multipleupdstrtd .= "<td>".$data[$colid]."</td>";
                    }
                } 
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
        $this->PublicNotes->insertNewPublicNotes($recId, $docType, $this->currentUser->user_id, $regarding, $section,false,'Import Accounting CSV');
    }
   
}
