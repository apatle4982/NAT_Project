<?php
declare(strict_types=1);
namespace App\Controller;
/**
 * ImportShippingInfo Controller
 *
 * @method \App\Model\Entity\ImportShippingInfo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ImportShippingInfoController extends AppController
{
    public $cols;    
    public $CSVFields;  
    
    public function initialize(): void
	{
	   parent::initialize();
       $this->loadModel("CompanyMst");
	   $this->loadModel("FilesMainData");
       $this->loadModel("FilesCheckinData");
       $this->loadModel('FilesShiptoCountyData'); 
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
        $this->CSVFields = array('vendorreferenceno', 'tagreferenceno', 'borrower', 'jurisdiction', 'State', 'carrier', 'carrierreferenceno'); 
        
        $errcols = array();
		$errrows = array();
		$errrowsCFN = array();
		$errrowsQC = array();
		$erecrows = array();
        
        $updstr = "";
		$insstr = "";
		$insstrship = "";
		$updstrship = "";
		$errorcntr = 0;


        $errorArr = [];
		$successArr = [];  
        $insstracc = "";  
        $updstracc = ""; 
        $multipleupdstr ="";
        $documentNumber = "";  
    
        $pageTitle = 'Upload eSub Sheet';
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
                            $postData[] = $field_value_array[1]; 
                        } 
                         
                        // check record in shipping
                        $shipData = $this->FilesShiptoCountyData->getS2CData($records[2], $records[1]); 
                                                
                        if(!empty($shipData)){ 
                            if($shipData['RecId'] != ""){  
                                $returnShipping = $this->shippingUpdate($records[2], $records[1], $shipData, $postData); 
                                $updstracc .= $returnShipping;
                            }                           
                        } else{
                            // shipping insert
                            $returnAcc = $this->shippingInsert($records[2], $records[1], $postData);
                            $insstracc .= $returnAcc; 
                        }

                    } 
                }
                
            } // if proceed button end

            if(($this->request->getData('saveBtn') !== null)) {
  
                $csvRecordsFile = $this->request->getData('upload_records');

                $csvRecordsFilename = $csvRecordsFile->getClientFilename();
                $GetFileExtension = $csvRecordsFile->getClientMediaType();
    
                $GetFileExtension = substr($csvRecordsFilename,-3);
                
                if((strtolower($GetFileExtension) != 'csv') || ($csvRecordsFile->getError() != '0'))
                { 
                    $errorArr['errorArr'][] = "Please upload cvs files only";
                    goto errordisplay;
                } else {
 
                    $destination =  WWW_ROOT.'files/importRecord/';
                    
                    $date = date('YmdHis');
                    $filename = "Shipping_eSub_" . $date .".csv" ;  
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
                        
                                    if(strtolower(str_replace(" ","", $value)) == "tagreferenceno"){ 
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
                                      
                                        $documentNumber = $data[$trncol]; 
                                        $tagreferenceno = $this->FilesMainData->CheckPartnerFileNumber($documentNumber);
                    
                                        if(!empty($tagreferenceno) && $tagreferenceno['Id'] != "")
                                        { 
                                            $checkInData = $this->FilesCheckinData->getCheckInDataCSC($tagreferenceno['Id']);
    
                                            $countCheckin = count($checkInData);
                                            if($countCheckin > 1){
                                                $returnDocType = $this->checkMultiDocType($checkInData, $data); 
                                                $multipleupdstr .= $returnDocType; 
                                            } // if > 1
                                            elseif($countCheckin  == 1){                             
                                                // select shipping data
                                                $shipData = $this->FilesShiptoCountyData->getS2CData($checkInData[0]['RecId'], $checkInData[0]['TransactionType']); 
                                    
                                                if(!empty($shipData)){  
                                                    if($shipData['RecId'] != ""){
                                                        $returnShipping = $this->shippingUpdate($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], $shipData, $data);
                                                        $updstracc .= $returnShipping;  
                                                    } // if shipping
                                                }else{
                                                     
                                                    $returnAcc = $this->shippingInsert($checkInData[0]['RecId'], $checkInData[0]['TransactionType'], $data);
                                                    $insstracc .= $returnAcc; 

                                                } //else shipping 
                                            } //elseif == 1
                                            else{
                                                //recor not found in Check In
                                                $errrowsCFN[] = $data;
                                            }  
                                        } else {     
                                            $errrowsCFN[] = $data;
                                        }
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
  
    public function shippingUpdate($RecId, $TransactionType, $shipData, $data){
       
        $updstrtdship = ""; $updstrship = "";
        
        $updsqlship = array();

        $updsqlship["CarrierName"] = "ERECORD";
        $updsqlship["CarrierTrackingNo"] = "ERECORD";
        $updsqlship["ShippingProcessingDate"] = date("Y-m-d");
        $updsqlship["ShippingProcessingTime"] = date("H:i:s");

        foreach($this->cols as $colid => $coltext){
            $updstrtdship .= "<td>".$data[$colid]."</td>";
        }
         
        $updsqlship["UserId"] =  $this->currentUser->user_id;
       
        $updstrship .= "<tr>".$updstrtdship."</tr>";
          
        $this->FilesShiptoCountyData->updateShippingData($shipData['Id'], $updsqlship);

        // insert public data shipping
        $this->addPublicNotes($RecId, $TransactionType, '<b>Shipping Updated</b> (CarrierName: ERECORD, CarrierTrackingNo: ERECORD)', 'Fsd');
         
        return $updstrship;
    }

    public function shippingInsert($RecId, $TransactionType, $data){
         
        $insstrtdship = ""; $insstrship = ""; 
        
        $updsqlfieldsship = array(); 

        $updsqlfieldsship["RecId"] = $RecId;  
        $updsqlfieldsship["TransactionType"] = $TransactionType;
        
        $updsqlfieldsship["CarrierName"] = "ERECORD";
        $updsqlfieldsship["CarrierTrackingNo"] = "ERECORD";
        $updsqlfieldsship["ShippingProcessingDate"] = date("Y-m-d");
        $updsqlfieldsship["ShippingProcessingTime"] = date("H:i:s");

        foreach($this->cols as $colid => $coltext){               
            $insstrtdship .= "<td>".$data[$colid]."</td>";
        } 

        $updsqlfieldsship["UserId"] = $this->currentUser->user_id;            
       
        $insstrship .= "<tr>".$insstrtdship."</tr>";
        
        $this->FilesShiptoCountyData->saveShippingData($updsqlfieldsship); 
        // inseert public data shipping
        $this->addPublicNotes($RecId, $TransactionType, '<b>Shipping Added</b> (CarrierName: ERECORD, CarrierTrackingNo: ERECORD)', 'Fsd');
         
        return $insstrship;
    }

   
    public function checkMultiDocType($checkInData, $data){
        $rowdone = 0; $multipleupdstrtd= $multipleupdstr =""; $docname = $multopt = "";
        $countCheckin = count($checkInData);
        foreach($checkInData as $checkin){ 
            if(!$rowdone){ 
                $updsql = array(); 

                foreach($this->cols as $colid => $coltext){
                    $updsql[] = $coltext."=".$data[$colid];
                    if(strtolower(str_replace(" ","", $coltext)) == "tagreferenceno"){
                        $multipleupdstrtd .= "<td>".$data[$colid]." (#dt#)</td>";
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
            } 
        }

        if($countCheckin > 1){
            $multipleupdstr = str_replace('#dt#', '<select name="dt[]" style="border:1px solid red" required><option value="">Select Document Type</option>'.$multopt.'</select>',$multipleupdstr);
        } 
        return $multipleupdstr;
 
    }
  
    public function addPublicNotes($recId, $docType, $regardingtext, $section){
        $regarding = (empty($regardingtext)) ? 'Record Added': $regardingtext;
        $this->PublicNotes->insertNewPublicNotes($recId, $docType, $this->currentUser->user_id, $regarding, $section, false,'Upload eSub Sheet');
    }
   
}
