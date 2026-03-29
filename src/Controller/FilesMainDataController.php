<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * FilesMainData Controller
 *
 * @property \App\Model\Table\FilesMainDataTable $FilesMainData
 * @method \App\Model\Entity\FilesMainData[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilesMainDataController extends AppController
{
    public  $pageLimit = ['limit' => 999999999999, 'maxLimit' => 10];

    public function importRecords(){
 
		// set page title
		$pageTitle = 'Upload CSV File';
		$this->set(compact('pageTitle'));

        $FilesMainData = $this->FilesMainData->newEmptyEntity();
        
        $errorArr = [];
		$successArr = [];
		$insertedId = [];
		$errorFlgCounty = 0;
		$errorViewData = [];
		$ErrorCountyArr = [];
		$duplicate_validColomns = [];
		$mapCSVFieldsTitle = [];
		$partnerImportFields = [];
		
		$errcompid = [];
		$updaterecordid = 0;
		$addrecordid = 0;
		$updaterecordidArray = [];
		$countCounty = 0;
		$addCountyWhere = 1;
		$updateCSVMainData = [];
		$insertCSVMainData = [];
		$insertedCount = $updateCount = 0;
		$isFileUpload = false;
        
        if($this->request->is(['patch', 'post', 'put'])){
 
          // update records on Continue btn 
          if(($this->request->getData('btnCountyError') =='Continue'))
          {
              $errorCountydata = $this->request->getData('errorCountydata');
              
              $postState  = $this->request->getData('State');
              $postCounty = $this->request->getData('County');
              
              $companyid 		= $this->request->getData('companyid');
              $errorFlgCounty = $this->request->getData('errorFlgCounty');
              $filesCsvLastId = $this->request->getData('csvmstid');
              $insertedCount 	= $this->request->getData('insertedCount');
              $updateCount 	= $this->request->getData('updateCount');
              
              $dbColumnName 	= $this->request->getData('dbColumnName');
              $filename 		= $this->request->getData('csvFilename');
              
              $columnData = explode('{#}',$dbColumnName);

              // set all mapping fields from database and CSV header
              $mappingsFields 	 = $this->setCompanyMappingsFields($companyid,$columnData);
              $partnerImportFields = $mappingsFields['partnerImportFields'];
              $mapCSVFieldsTitle	 = $mappingsFields['mapCSVFieldsTitle'];
              $duplicate_validColomns	 = $mappingsFields['duplicate_validColomns'];
              
              foreach($errorCountydata as $Countydata)
                  $postRowData[] = explode('{#}',$Countydata);

              foreach($postState as $key=>$State){
                  if(!empty($State))$postRowData[$key][$duplicate_validColomns['State']] = $State;
                  if(!empty($postCounty[$key])) $postRowData[$key][$duplicate_validColomns['County']] = $postCounty[$key];
              }
              
              foreach($postRowData as $rowData){

                  //ignore empty Line from CSV(string) $rowData[0] != '0' and empty($rowData[0])
                  if (empty(array_filter($rowData)))
                  {
                      continue;
                  }
              
                  if(!empty(array_filter($rowData)))
                  {
                      // insert / update data after State-County check
                      $processCSVRowData = $this->processCSVRowData($rowData, $mapCSVFieldsTitle, $duplicate_validColomns, $countCounty, $addrecordid, $updaterecordid,$companyid, $filesCsvLastId, $errorFlgCounty, $updateCSVMainData, $insertCSVMainData);

                      //***************************UPDATE****************************************//
                      if(isset($processCSVRowData['updateCSVMainData']['updaterecordid'])) 
                      $updaterecordid = $processCSVRowData['updateCSVMainData']['updaterecordid'];
                      
                      if(isset($processCSVRowData['updateCSVMainData']['updaterecordidArray'])) 
                      $updaterecordidArray[]= $processCSVRowData['updateCSVMainData']['updaterecordidArray'];
                  
                      if(isset($processCSVRowData['updateCSVMainData']['companyid'])) 
                      $companyid= $processCSVRowData['updateCSVMainData']['companyid'];
                      
                      if(isset($processCSVRowData['updateCSVMainData']['successMsg'])) 
                      $successArr['successMsg'] = $processCSVRowData['updateCSVMainData']['successMsg'];
                      //****************************************//
                      //****************INSERT************************//
                      if(isset($processCSVRowData['insertCSVMainData']['errcompid']))
                      $errcompid[] = $processCSVRowData['insertCSVMainData']['errcompid'];
                      
                      if(isset($processCSVRowData['insertCSVMainData']['insertedId']))
                      $insertedId[]= $processCSVRowData['insertCSVMainData']['insertedId'];
                      
                      if(isset($processCSVRowData['insertCSVMainData']['companyid'])) 
                      $companyid = $processCSVRowData['insertCSVMainData']['companyid'];
                  
                      if(isset($processCSVRowData['insertCSVMainData']['addrecordid']))
                      $addrecordid = $processCSVRowData['insertCSVMainData']['addrecordid'];

                      if(isset($processCSVRowData['insertCSVMainData']['successMsg']))
                      $successArr['successMsg'] = $processCSVRowData['insertCSVMainData']['successMsg'];
                      //****************************************************************************//
                      
                      //$errrows[] = $processCSVRowData['errrows'];
                      $errorFlgCounty = $processCSVRowData['errorFlgCounty'];
                      if(!empty($processCSVRowData['ErrorCountyArr'])) 
                      $ErrorCountyArr[] = $processCSVRowData['ErrorCountyArr'];
                      $countCounty = $processCSVRowData['countCounty'];

                      if($processCSVRowData['continueFlag']) continue;
                      
                  }// not empty row data from CSV

              } // foreach
              
              $serializeData = unserialize($this->request->getData('serializeData'));
              $serializeData['insertData'] = array_merge($serializeData['insertData'], array_filter($insertedId));
              $serializeData['updateData'] = array_merge($serializeData['updateData'], array_filter($updaterecordidArray));
              
              
              // unset variable common use in global search
              unset($postState);
              unset($postCounty);  
              //exit;
              
          }

          // insert update records on upload csv
          if(($this->request->getData('saveBtn') !== null)) {

            $isFileUpload   = true;
            $companyid 		= $this->request->getData('companyid');
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
 

                $destination =  WWW_ROOT.'files/import/';

                $csvRecordsFilename =  preg_replace('/[^A-Z0-9._]/i', '_', $csvRecordsFilename);

                $filename = $csvRecordsFilename;

                //check if file exist

                if(file_exists($destination.$filename)&& !(empty($filename)))
                {
                    $ExplodeFileName = explode(".",$filename);
                    $ExplodeFileName[sizeof($ExplodeFileName)-2] .= "_".$this->CustomPagination->randomDigit();
                    $filename = implode(".", $ExplodeFileName);
                }

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
                        // insert csv file in file_csv_master table
                        $this->loadModel('FilesCsvMaster'); 
                        $filesCsvLastId = $this->FilesCsvMaster->insertCSVFiles($companyid, $filename);

                        // read csv file data for first row and upload
                        $columnData = fgetcsv($myFile);
                        
                        // set all mapping fields from database and CSV header 
                        $mappingsFields 	 = $this->setCompanyMappingsFields($companyid, $columnData);
						//echo '<pre>';
						//print_r($mappingsFields); exit;
                        $partnerImportFields = $mappingsFields['partnerImportFields'];
                        $mapCSVFieldsTitle	 = $mappingsFields['mapCSVFieldsTitle'];
                        $duplicate_validColomns	 = $mappingsFields['duplicate_validColomns'];

                        // check errors from CSV headers
                        if(isset($duplicate_validColomns['duplicate']) && sizeof($duplicate_validColomns['duplicate']) > 0){
                            $errorArr['isDuplicate'] = $duplicate_validColomns['duplicate']; //"Dumplicate values";
                        }
                        if(isset($duplicate_validColomns['errcols']) && sizeof($duplicate_validColomns['errcols']) > 0){
                            $errorArr['isNotMatch'] = $duplicate_validColomns['errcols']; //"Not Match columns";
                        }
                        if($duplicate_validColomns['isEmptyColumn']){
                            $errorArr['isEmpty'] = $duplicate_validColomns['isEmptyColumn']; //true //"Empty columns";
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

							if($rowData[$duplicate_validColomns['transtypecolno']] > 4 || $rowData[$duplicate_validColomns['transtypecolno']] == 0){
								/* $errorArr['isNotMatch'] = $duplicate_validColomns['errcols']; //"Not Match columns";
								$this->flashErrorMsg($errorArr, $partnerImportFields);
								continue; */

								$errorArr['isTransactionTypeMatch'] = array('Transaction type <b>'.$rowData[$duplicate_validColomns['transtypecolno']].'</b> is invalid'); //"Not Match columns";
								$partnerImportFields[] = 'Transaction Type Error';
								//$this->flashErrorMsg($errorArr,$partnerImportFields);
								//print_r($partnerImportFields);
								goto errordisplay;
								//continue;
							}
						
							if(!empty(array_filter($rowData)))
							{ 
								// insert / update data
								$processCSVRowData = $this->processCSVRowData($rowData, $mapCSVFieldsTitle, $duplicate_validColomns, $countCounty, $addrecordid, $updaterecordid,$companyid, $filesCsvLastId, $errorFlgCounty, $updateCSVMainData, $insertCSVMainData);
			 	
						//echo '<pre>';
						//print_r($processCSVRowData); exit;
								//*****************UPDATE***********************//
								if(isset($processCSVRowData['updateCSVMainData']['updaterecordid'])) 
								$updaterecordid = $processCSVRowData['updateCSVMainData']['updaterecordid'];
								
								if(isset($processCSVRowData['updateCSVMainData']['updaterecordidArray']))
								$updaterecordidArray[] = (($processCSVRowData['updateCSVMainData']['updaterecordidArray'] != '') ? $processCSVRowData['updateCSVMainData']['updaterecordidArray']: '');

								if(isset($processCSVRowData['updateCSVMainData']['companyid'])) 
								$companyid = $processCSVRowData['updateCSVMainData']['companyid'];
								
								if(isset($processCSVRowData['updateCSVMainData']['successMsg'])) 
								$successArr['successMsg'] = $processCSVRowData['updateCSVMainData']['successMsg'];
								//**********************************************//
								
								//*****************INSERT***********************//
								if(isset($processCSVRowData['insertCSVMainData']['errcompid'])) 
								$errcompid[] = $processCSVRowData['insertCSVMainData']['errcompid'];
								
								if(isset($processCSVRowData['insertCSVMainData']['insertedId'])) 
								$insertedId[]= $processCSVRowData['insertCSVMainData']['insertedId'];
								
								if(isset($processCSVRowData['insertCSVMainData']['companyid'])) 
								$companyid = $processCSVRowData['insertCSVMainData']['companyid'];
							
								if(isset($processCSVRowData['insertCSVMainData']['addrecordid'])) 
								$addrecordid = $processCSVRowData['insertCSVMainData']['addrecordid'];
								
								if(isset($processCSVRowData['insertCSVMainData']['successMsg'])) 
								$successArr['successMsg'] = $processCSVRowData['insertCSVMainData']['successMsg'];
								//****************************************//
								
								//$errrows[] = $processCSVRowData['errrows'];
								$errorFlgCounty = $processCSVRowData['errorFlgCounty'];
								if(!empty($processCSVRowData['ErrorCountyArr'])) 
								$ErrorCountyArr[] = $processCSVRowData['ErrorCountyArr'];
							
								$countCounty = $processCSVRowData['countCounty'];

								if($processCSVRowData['continueFlag']) continue;

							}// not empty row data from CSV
							$countKK++;
						} // while
							
						$serializeData = ['insertData'=>array_filter($insertedId), 'updateData'=>array_filter($updaterecordidArray)];
							
                    }
                    fclose($myFile); 
                } else {
					$errorArr['errorArr'][] = "Some error occur while uploading file. Please try again !!";
					goto errordisplay; 
                }
            }                 

          } // end if post uload csv file 

			// New Records Added
			if(isset($addrecordid)&& $addrecordid >0){
				$insertedCount = $insertedCount+$addrecordid;
				$successArr['addedcompid'] = $insertedCount.' New Records Added.';
			}
			
			//Records Overwritten
			if(isset($updaterecordid)&& $updaterecordid >0) {
				$updateCount = $updateCount+$updaterecordid;
				$successArr['updatecompid'] = $updateCount.' Records Overwritten.';
			}
			
			// total count of insert upload records

			// errors
			if(isset($errrows) &&  sizeof($errrows)>0){
				$errorFlgCounty =0;
				$successArr['errrows'] = implode(",",$errrows);
			}

			// company State-County not match
            $errcompid_arr = [];
			if(isset($errcompid) && sizeof($errcompid) > 0){
				//$errorFlgCounty =0;  // new remove ### 
				foreach($errcompid as $errcompids){
					if(is_array($errcompids) && (sizeof($errcompids) > 0)) // change new
					$errcompid_arr[] = $errcompids[0];
				}

                // partner id error validation if company not found 
               
                if(isset($processCSVRowData['errcompid']) && (!empty($processCSVRowData['errcompid']))){	 
                    if(isset($duplicate_validColomns['partneridcolname']) && !empty($duplicate_validColomns['partneridcolname'])){	
                    
                        $successArr['compErrRows'] = "Below ".$duplicate_validColomns['partneridcolname']."s do not match any ".$duplicate_validColomns['partneridcolname']." in system. \n ".implode(", ",array_unique($errcompid_arr))." \n The records with above ".$duplicate_validColomns['partneridcolname']."s are not uploaded!!";
                    }
                }
              //  pr($successArr);exit;
			}

			
			// County error table
			if(isset($errorFlgCounty) && $errorFlgCounty){
				
				$errorViewData['serializeData'] = serialize($serializeData);
				
				$errorViewData['errorCountyTable'] = $this->showCountyErrorTable($mapCSVFieldsTitle, $ErrorCountyArr, $companyid, $filesCsvLastId, $filename, $errorFlgCounty,$insertedCount, $updateCount);
			}
			
			// show only for csv upload section
		
			// inster data table  //if $isFileUpload then show table
			if(isset($serializeData) && !empty($serializeData['insertData'])){
				$errorViewData['insertTable'] = $this->showProcessDatatable($serializeData['insertData'], $filename, 'insert',$isFileUpload);
			}
			// End of CSV For added records
			// update datatable
			if(isset($serializeData) && !empty($serializeData['updateData'])){
				$errorViewData['uploadTable'] = $this->showProcessDatatable($serializeData['updateData'], $filename,'upload', $isFileUpload);
			}

			if(!empty(array_filter($successArr))){
				$this->flashSuccessMsg($successArr);
			}

        } // if post submit
  
			// come from GOTO function 
			errordisplay:{
				//print_r($errorArr);exit;
				if(!empty(array_filter($errorArr))){ 
					$this->flashErrorMsg($errorArr, $partnerImportFields);
				}
			}
        // company list
		$this->loadModel('CompanyMst');
		$companies = $this->CompanyMst->companyListArray();

        $this->set(compact('FilesMainData', 'companies','errorViewData')); //,'successArr','errorArr'
        $this->set('_serialize', ['FilesMainData']);

    }

    
	public function searchCountyAjax()
	{
		$this->autoRender = false;
		$this->loadModel('CountyMst');
		$id = 'AL';//$this->request->getData('id');
		$CountyTitle = $this->CountyMst->getCountysByStateName($id);
		//$this->set('CountyTitle', $CountyTitle);

		$towstxtErrorCounty = '<select name="County" class="form-control" required="required"><option value="">Select County</option>';
		foreach($CountyTitle as $key=>$CountyText){
			if($CountyText['cm_title'] != null){   
				$towstxtErrorCounty .= '<option value="'.$CountyText['cm_title'].'"'; 
				$towstxtErrorCounty .= '>'.$CountyText['cm_title'].'</option>';
			}
		}
		$towstxtErrorCounty .= '</select>';
		echo $towstxtErrorCounty; 
		exit;
	}
	
    // call function for generate excel sheet and table for uploaded records
    public function showProcessDatatable($insertedId,$filename,$prifix, $is_table=true)
    {
        $insertLists = $showViewData = [];
        $insertedId = array_filter($insertedId);
        if(!empty($insertedId)) {
            $insertLists = $this->FilesMainData->getInsertedMainData($insertedId);
        }
        if(!empty($insertLists)){
            
            $processRowtxt = "";

            foreach($insertLists as $list){
                if($is_table){	
                    $processRowtxt .='<tr>
                                        <td><br>'.(($list['NATFileNumber']) ? substr($list['NATFileNumber'],0,65) : '').'</td>
                                        <td><br><span >'.(($list['comp_mst']['cm_comp_name']) ? substr($list['comp_mst']['cm_comp_name'],0,65) : '').'</span></td>
                                        <td><br><span >'.(($list['PartnerFileNumber']) ? substr($list['PartnerFileNumber'],0,65) : '').'</span></td>
                                        <td><br><span >'.(($list['Grantors']) ? substr($list['Grantors'],0,65) : '').'</td>
                                        <td><br>'.(($list['StreetNumber']) ? substr($list['StreetNumber'],0,65) : ''). (($list['StreetName']) ? ' '.substr($list['StreetName'],0,65) : '' ).'</span></td>
                                        <td><br>'.(($list['TransactionType']) ? substr($list['TransactionType'],0,65) : '').'</td>																	
                                    </tr>';
                }	
                
                $listExport[]= [$list['PartnerFileNumber'],$list['NATFileNumber'],date('Y-m-d His'),$list['Grantors'],$list['Grantees'],$list['State'],$list['County']];
            }
            
            $showViewData['listExport'] = $listExport; //??
            
            if($is_table){
                if(!empty($processRowtxt)) 
                    $showViewData[$prifix.'Rowtxt'] = $processRowtxt;
                
                if($prifix == 'insert')
                    $showViewData[$prifix.'flnmHeader'] = 'Below new records are added from the CSV file: '.$filename;
                else 
                    $showViewData[$prifix.'flnmHeader'] = 'Below records are overwritten from the CSV file: '.$filename;
                
                
                $showViewData['headerRowtxt'] = "<th>".__('NATFileNumber')."</th>
                                                <th>".__('PartnerName (PartnerID)')."</th>
                                                <th>".__('PartnerFileNumber')."</th>
                                                <th>".__('MortgagorGrantor')."</th>
                                                <th>".__('PropertyAddress')."</th>
                                                <th>".__('TransactionTypes')."</th>";
        
            }

            // CSV for Added records  08022023
             $showViewData['csvFilename'] = $this->_uploadRecordExport($showViewData['listExport'], $prifix);
        
        }

        return $showViewData;
    }


    private function _uploadRecordExport($listExport, $prifix){
        
        $columnHeaders = ['PartnerFileNumber','NATFileNumber', 'Current date','Grantors', 'Grantees', 'State','County']; //.. take csv file column headings
        $csvFilename = $this->CustomPagination->recordExport($listExport,$columnHeaders,$prifix.'export','export');
        
        return $csvFilename;
            
    }
    public function showCountyErrorTable(array $mapCSVFieldsTitle,array $ErrorCountyArr,$companyid,$filesCsvLastId,$csvFilename,$errorFlgCounty,$insertedCount, $updateCount)
	{
		$headerCountyerrorcols = "<th>SN</th>";
		$myColumnDefs = [];
		$columncntr = 0;
		$Statepos = "";
		$Countypos = "";
		
		$headerCountyerrorcolsarr = [];
		foreach($mapCSVFieldsTitle as $key=>$column){
			$headerCountyerrorcolsarr[] = $column;
			if($column == "State"){
				$Statepos = $columncntr;
			}
			if($column == "County"){
				$Countypos = $columncntr;
			}
			$headerCountyerrorcols .= "<th>".$column."</th>";
			$columncntr++;
		}
		$towstxtErrorCounty = "";
		$rowcntr = 0;
		
		$this->loadModel('CountyMst');
		$Statelist = $this->CountyMst->StateListArray();
		//echo '<pre>';
		//print_r($Statelist);
		foreach($ErrorCountyArr as $errorCountyrows)
		{
			if(!empty(array_filter($errorCountyrows)))
			{
				$rowcntr++;
				$towstxtErrorCounty .= '<tr><td><input type="hidden" name="errorCountydata[]" value="'.implode("{#}",$errorCountyrows).'">'.$rowcntr.'</td>';
				//echo '<pre>';
				//print_r($errorCountyrows); exit;
				foreach($errorCountyrows as $rowid=>$rowval)
				{
					if($rowid == $Statepos)
					{
						$NewState = $rowval;
						//$State = '';
						$towstxtErrorCounty .= '<td>'.$rowval.'<br>
											<select name="State[]" class="form-control" onchange="getCounty(this.value,'.$rowcntr.')">
												<option value="">State</option>';
												foreach($Statelist as $State){
													//print_r($State);
													if($State != '' && $rowval != ''){ 
														$towstxtErrorCounty .= '<option value="'.$State.'"';
														if(strtolower($State) == strtolower($rowval)) $towstxtErrorCounty .='selected'; 
														$towstxtErrorCounty .= '>'.$State.'</option>';
													} //exit;
												}
						$towstxtErrorCounty .= '</select></td>';
						
					}elseif($rowid == $Countypos){
						
						$towstxtErrorCounty .= '<td >'.$rowval.'<br><div id="company_div_'.$rowcntr.'">';
						$CountyTitle = $this->CountyMst->getCountyTitleByState($errorCountyrows[$Statepos]);
						$towstxtErrorCounty .= '<select name="County[]" class="form-control"><option value="">Select County</option>';
												foreach($CountyTitle as $County){
													if($County != 'null'){   
														$towstxtErrorCounty .= '<option value="'.$County.'"';
														if(strtolower($County) == strtolower($rowval)) $towstxtErrorCounty .='selected'; 
														$towstxtErrorCounty .= '>'.$County.'</option>';
													}
												}
						$towstxtErrorCounty .= '</select></div></td>';
					}else{
						
						$towstxtErrorCounty .= '<td>'.$rowval.'</td>';
					}
				}
				
				$towstxtErrorCounty .= "</tr>";
			
			}
		}
		
		$errorViewData['headerCountyerrorcols'] = $headerCountyerrorcols;	 //
		$errorViewData['headerCountyerrorcolsarr'] = implode("{#}",$headerCountyerrorcolsarr);	 //
		//$errorViewData['myColumnDefs'] = implode(",",$myColumnDefs);	
		//$errorViewData['fieldsCountyerr'] = implode(",",$fieldsCountyerr);	
		$errorViewData['towstxtErrorCounty'] = $towstxtErrorCounty; //
		$errorViewData['errorFlgCounty'] =$errorFlgCounty; //
		$errorViewData['Statepos'] =$Statepos;
		$errorViewData['Countypos'] =$Countypos;
		$errorViewData['companyid'] =$companyid; //
		$errorViewData['csvmstid'] =$filesCsvLastId; //
		$errorViewData['csvFilename'] =$csvFilename; //
		$errorViewData['insertedCount'] = $insertedCount;
		$errorViewData['updateCount'] = $updateCount;
		
		$errorViewData['headerTitleErrorCounty'] = 'Below records have error in County/State name. Please correct County/State name and click on "Continue" button.';
			
		return $errorViewData;
	}


    public function processCSVRowData($rowData, $mapCSVFieldsTitle, $duplicate_validColomns, $countCounty, $addrecordid, $updaterecordid, $companyid, $filesCsvLastId, $errorFlgCounty, $updateCSVMainData, $insertCSVMainData)
	{
		
		$continueFlag = false;
		$dtype = "";
		$doctypearr = [];
		$errrows = [];
		$ErrorCountyArr=[];
		if(sizeof($mapCSVFieldsTitle)!=sizeof($rowData)){
			$errrows = $rowData;
			
			$continueFlag = true;
			return ['continueFlag'=>$continueFlag,'errrows'=>$errrows,'updateCSVMainData'=>$updateCSVMainData,'insertCSVMainData'=>$insertCSVMainData,'errorFlgCounty'=>$errorFlgCounty,'ErrorCountyArr'=>$ErrorCountyArr,'countCounty'=>$countCounty];
		}
		
		// get County details for dropdown
		$CountyTitle = $this->getCountyDetail($duplicate_validColomns, $rowData);
		
		if( !empty($duplicate_validColomns['County']) && isset($CountyTitle['cm_title']) && strtolower(trim($CountyTitle['cm_title'])) == strtolower(trim($rowData[$duplicate_validColomns['County']])))
		{ 
			 $updateCSVMainData = $this->updateCSVFilesMainData($duplicate_validColomns,$rowData,$updaterecordid,$companyid,$mapCSVFieldsTitle,$CountyTitle,$filesCsvLastId);
			
			if($updateCSVMainData['continueFlag']) {
				$continueFlag = true;
				return ['continueFlag'=>$continueFlag,'errrows'=>$errrows,'updateCSVMainData'=>$updateCSVMainData,'insertCSVMainData'=>$insertCSVMainData,'errorFlgCounty'=>$errorFlgCounty,'ErrorCountyArr'=>$ErrorCountyArr,'countCounty'=>$countCounty];
			}
				
			/*********************/
			//array_walk($data,"f_addslashes");
			if(sizeof($mapCSVFieldsTitle)!=sizeof($rowData)){ // same as above code ?? 
				//4
				$errrows = $rowData;
			}
			else
			{ 
				$insertCSVMainData = $this->insertCSVFilesMainData($duplicate_validColomns,$rowData,$addrecordid,$companyid,$mapCSVFieldsTitle,$CountyTitle,$filesCsvLastId);
				
				if($insertCSVMainData['continueFlag']){
					$continueFlag = true;
					return ['continueFlag'=>$continueFlag,'errrows'=>$errrows,'updateCSVMainData'=>$updateCSVMainData,'insertCSVMainData'=>$insertCSVMainData,'errorFlgCounty'=>$errorFlgCounty,'ErrorCountyArr'=>$ErrorCountyArr,'countCounty'=>$countCounty, "errcompid"=> $insertCSVMainData['errcompid']];
				} 
			} 
			/********************/
			
		} // if County condition 
		else
		{ // if for checking County 
			// for County are not correct
			//7
			$errorFlgCounty =1;
			$ErrorCountyArr = $rowData;	
			$countCounty ++;
		}

        $errcompid1 = [];
        if(isset($insertCSVMainData['errcompid'])) { $errcompid1 = $insertCSVMainData['errcompid'];}
		return ['continueFlag'=>false,'errrows'=>$errrows,'updateCSVMainData'=>$updateCSVMainData,'insertCSVMainData'=>$insertCSVMainData,'errorFlgCounty'=>$errorFlgCounty,'ErrorCountyArr'=>$ErrorCountyArr,'countCounty'=>$countCounty,"errcompid"=> $errcompid1];
	}
    
    public function insertCSVFilesMainData($duplicate_validColomns,$rowData,$addrecordid,$companyid,$mapCSVFieldsTitle,$CountyTitle,$filesCsvLastId)
	{

		$successMsg = '';
		$insertedId=[];
		$errcompid=[];
		if(!empty($duplicate_validColomns['partnerIDcolno']) && $rowData[$duplicate_validColomns['partnerIDcolno']] != "")
		{ 
			$companyid = $rowData[$duplicate_validColomns['partnerIDcolno']];
			$this->loadModel('CompanyMst');
			$compcountlist = $this->CompanyMst->findByCmId($companyid)->select(['cm_id'])->first();
			
			if($compcountlist['cm_id'] == "")
			{
				//5
				if(!empty($companyid)) 
				$errcompid[] = $companyid; // change new

				return ['continueFlag'=>true,'errcompid'=>$errcompid,'companyid'=>$companyid,'addrecordid'=>$addrecordid,'insertedId'=>$insertedId,'successMsg'=>$successMsg];
			}
		}

		if($companyid == ""){
			$companyid = 1;   // need to ask why this constant?
		}
		
		// execution slow 
		// new change : email February 20, 2023 7:04 AM  
		// record upload overwrite : if reject or non reject 
		//1. if reject from QC then we need to clear rejection and update existing record ( with checkingDATA date time, change Y) and add Notes
		//2. if non reject : add new entry with same LRS number with current data
		if($duplicate_validColomns['NATFlNo']){ //file lrsnumber
			$sqlmainInt=$this->FilesMainData->sqlDataInsert($mapCSVFieldsTitle,$rowData,$this->currentUser->user_id,$filesCsvLastId,$CountyTitle['cm_file_enabled'],$companyid);
		}else{ 
			$NATFileNumber = '';
			$sqlmainInt = $this->FilesMainData->sqlDataInsert($mapCSVFieldsTitle,$rowData,$this->currentUser->user_id,$filesCsvLastId,$CountyTitle['cm_file_enabled'],$companyid,$NATFileNumber);
		}
		 //echo '<pre>'; 
		 //print_r($sqlmainInt);
		 //exit;
		// insert FMD data
		$insertFMD = $this->FilesMainData->insertFMDData($sqlmainInt);
		 
		if($insertFMD['success'] === true)
		{	
 
			$addrecordid++;
		
			$insertedId =  $insertFMD['fmdId'];  //last inster Id of main data
			
			$duplicate_validColomns_transtypecolno = $duplicate_validColomns['transtypecolno'];

			$rowData_duplicate_validColomns_transtypecolno = isset($rowData[$duplicate_validColomns['transtypecolno']]) ?  $rowData[$duplicate_validColomns['transtypecolno']]: '';

			// insert CSV data
			$successMsg = $this->insertCSVCheckinPublicData($duplicate_validColomns_transtypecolno,$rowData_duplicate_validColomns_transtypecolno,$insertedId,$insertFMD['LRS_extension'],$insertFMD['LRS_PartnerFileNumber']);

		} // if data save in main data table and get last Id --> insertedId
		
		return ['continueFlag'=>false,'errcompid'=>$errcompid,'companyid'=>$companyid,'addrecordid'=>$addrecordid,'insertedId'=>$insertedId,'successMsg'=>$successMsg];
		
	}

    public function insertCSVCheckinPublicData($duplicate_validColomns_transtypecolno,$rowData_duplicate_validColomns_transtypecolno,$insId, $extension, $extension_client='')
	{   
		//$this->loadModel('FilesCheckinData'); 
		$this->loadModel('FilesVendorAssignment'); 
		$this->loadModel('FilesQcData');
		$currentUserId = $this->currentUser->user_id;
		// documnet type are not blank.
		$successMsg ='';
		if(isset($duplicate_validColomns_transtypecolno) && !empty($duplicate_validColomns_transtypecolno)){
			
			if(isset($rowData_duplicate_validColomns_transtypecolno) && !empty($rowData_duplicate_validColomns_transtypecolno)){ // && strpos($rowData_duplicate_validColomns_transtypecolno, ',')
				 
				$doctypearr = explode(",",$rowData_duplicate_validColomns_transtypecolno); //
			 
				foreach($doctypearr as $doctype){
 
				 	$doctype = $this->setDocType($doctype);

					$extensionDT  = $this->FilesVendorAssignment->getMainDataByMultiDocType($extension_client, $doctype);

					//Insert in CheckIn with TransactionType 
					if($extensionDT['setFlag'] == 1){
						$checkInData =  [ 
							'DocumentReceived' => '',
							'CheckInProcessingDate' => date("Y-m-d"),
							'CheckInProcessingTime' => date("H:i:s")
						];  
						
						$this->FilesCheckinData->updateFCDByFmdDoc($extensionDT['RecId'], $doctype, $checkInData); 
						$this->FilesQcData->updateQCData($extensionDT['qcid'], ['Status'=>'OK', 'QCProcessingDate'=>date('Y-m-d'), 'QCProcessingTime'=>date('H:i:s')]);
						$regarding = 'CSV Upload : Update Status OK. Ext check';
					}else{
						//$this->FilesCheckinData->insertNewCheckinData($insId,$doctype,$currentUserId, null, $extensionDT['ext']);
						$this->FilesVendorAssignment->insertNewVendorData($insId,$doctype,$currentUserId, null, $extensionDT['ext']);
						$regarding = 'CSV Upload : Insert Vendor Assignment Records. Ext check';
					}
					// ###### Coding for adding/updating -public_notes
					// need to ask
					 $this->loadModel('PublicNotes');
					 $this->PublicNotes->insertNewPublicNotes($insId, $doctype, $currentUserId, $regarding, 'Fva',true);
					
					//##### End of Coding for adding/updating -public_notes 
				} //  for doc type
			 
 				return $successMsg = "Data imported Successfully !!";
			}else{
				
				// parameter insertNewCheckinData(fmdLastID, documnetID, currentUserid, docRecived, ext);
				// DOCTYPE  define in costant as defalt 99 in path.php file
				//$this->FilesCheckinData->insertNewCheckinData($insId,DOCTYPE,$currentUserId, null, $extension);
				
				$this->FilesVendorAssignment->insertNewVendorData($insId,$DOCTYPE,$currentUserId, null, $extension);
				
				
				$this->loadModel('PublicNotes');
				$this->PublicNotes->insertNewPublicNotes($insId, DOCTYPE, $currentUserId, 'Record Inserted ext '.$extension, 'Fva', true);
			}
		}else{
			
			//$this->FilesCheckinData->insertNewCheckinData($insId,DOCTYPE,$currentUserId);
			
			$this->FilesVendorAssignment->insertNewVendorData($insId,DOCTYPE,$currentUserId);
			
			$this->loadModel('PublicNotes');
			$this->PublicNotes->insertNewPublicNotes($insId, DOCTYPE, $currentUserId, 'CSV Upload : Record Inserted', 'Fva', true);
		}
		
		return $successMsg;
	}
	
    private function setDocType($docType=''){
		if(($docType==0) || (empty($docType))){ 
			$docType=DOCTYPE; 
		}
		return $docType;
	}
 
    public function updateCSVFilesMainData($duplicate_validColomns,$rowData,$updaterecordid,$companyid,$mapCSVFieldsTitle,$CountyTitle,$filesCsvLastId)
	{ 
 
		$updaterecordidArray=[];$successMsg ='';
		if(!empty($duplicate_validColomns['ClientFlNocolno']) && $rowData[$duplicate_validColomns['ClientFlNocolno']]!="")
		{ 
 
			if(!empty($duplicate_validColomns['partnerIDcolno']) && $rowData[$duplicate_validColomns['partnerIDcolno']] != "")
			{
				// 1
				$companyid = $rowData[$duplicate_validColomns['partnerIDcolno']];
			}
			
		 // print_r($rowData);
		 // print_r($duplicate_validColomns);
			// need to ask
			$reccountlist = $this->FilesMainData->getFMDid($rowData[$duplicate_validColomns['ClientFlNocolno']],$companyid);
		  //print_r($reccountlist); exit;
			if(!empty($reccountlist) && $reccountlist['Id'] != "")
			{ 
				//array_walk($rowData,"f_addslashes");
				$reccountlistId = $reccountlist['Id'];

				//check for record rejection ===>  if non reject : add new entry with same LRS number with current data
				$this->loadModel('FilesQcData');

				if(!empty($duplicate_validColomns['transtypecolno'])) {
					$docType = $rowData[$duplicate_validColomns['transtypecolno']];
				} else {
					$docType = DOCTYPE;
				} 
				// check qc for record status
				 $QCdata = $this->FilesQcData->checkQCreject($rowData[$duplicate_validColomns['ClientFlNocolno']], $docType, $companyid);
				 if(isset($QCdata[0]) && (!in_array($QCdata[0]['Status'],['','OK']))){ 
					//Update existing record in main table
					$sqlmainupd = $this->FilesMainData->sqlDataInsert($mapCSVFieldsTitle,$rowData,$this->currentUser->user_id,$filesCsvLastId,$CountyTitle['cm_file_enabled'], $companyid);
					$sqlmainupd['InserId'] = $reccountlistId;  
					// update FMD data 
					$this->FilesMainData->insertFMDData($sqlmainupd); 
				 }else{  
					return ['continueFlag'=>false,'updaterecordidArray'=>$updaterecordidArray,'updaterecordid'=>$updaterecordid,'companyid'=>$companyid,'successMsg'=>$successMsg]; 
				 } 

				// end update  
				$updaterecordidArray = $reccountlistId; 
				$updaterecordid ++;
				
				// documnet type are blank.
				if(isset($duplicate_validColomns['transtypecolno']) && empty($duplicate_validColomns['transtypecolno']))
				{ 
					//$dtype = "99";
					// if blank then will add or not ??
					return ['continueFlag'=>true,'updaterecordidArray'=>$updaterecordidArray,'updaterecordid'=>$updaterecordid,'companyid'=>$companyid,'successMsg'=>$successMsg];
				}else{  
					$rowData_duplicate_validColomns_transtypecolno = $rowData[$duplicate_validColomns['transtypecolno']];
					$rowData_duplicate_validColomns_ClientFlNocolno = $rowData[$duplicate_validColomns['ClientFlNocolno']];
					// insert CSV data using documnet type
					$successMsg = $this->insertCSVdataDocType($rowData_duplicate_validColomns_transtypecolno,$rowData_duplicate_validColomns_ClientFlNocolno,$reccountlistId);

				} // else doc column 
				 
				return ['continueFlag'=>true,'updaterecordidArray'=>$updaterecordidArray,'updaterecordid'=>$updaterecordid,'companyid'=>$companyid,'successMsg'=>$successMsg];
			} // if main record Id 

		} // if ClientFlNocolno
		 
		return ['continueFlag'=>false,'updaterecordidArray'=>$updaterecordidArray,'updaterecordid'=>$updaterecordid,'companyid'=>$companyid,'successMsg'=>$successMsg];
	}

    public function insertCSVdataDocType($rowData_duplicate_validColomns_transtypecolno,$rowData_duplicate_validColomns_ClientFlNocolno,$reccountlistId)
	{   
        $this->loadModel('FilesCheckinData');
        $this->loadModel('FilesVendorAssignment');
		$successMsg = '';
		if(!empty($rowData_duplicate_validColomns_transtypecolno)){
		
			$doctypearr = explode(",",$rowData_duplicate_validColomns_transtypecolno);
				
			foreach($doctypearr as $doctype){
				
				//$recordDocList = $this->FilesCheckinData->getMainDataByDocType($rowData_duplicate_validColomns_ClientFlNocolno,$doctype);
				$recordDocList = $this->FilesVendorAssignment->getMainDataByDocType($rowData_duplicate_validColomns_ClientFlNocolno,$doctype);
				
				if(isset($recordDocList['RecId']) && $recordDocList['RecId'] == ""){
					
					//Insert in CheckIn with TransactionType		
					//$this->FilesCheckinData->insertNewCheckinData($reccountlistId,$doctype,$this->currentUser->user_id);
					$this->FilesVendorAssignment->insertNewVendorData($reccountlistId,$doctype,$this->currentUser->user_id);
					
					// ###### Coding for adding/updating -public_notes
					// need to ask
					$this->loadModel('PublicNotes'); 
					$this->PublicNotes->insertNewPublicNotes($reccountlistId, $doctype, $this->currentUser->user_id, 'CSV Upload : Record Inserted for Transaction type', 'Fva', true);
					
					$successMsg = "Data imported Successfully!!";
					//##### End of Coding for adding/updating -public_notes
				} // file main Data
			} //  for doc type
		
		} //	not empty transtypecolno 
		return $successMsg;
	}

    public function getCountyDetail($duplicate_validColomns,$rowData)
	{
		$CountyWhere = [];
		$wherefld =[];
		$CountyTitle=[];
		//echo 'kooooo----';
		//print_r($rowData); 
		if(!empty($duplicate_validColomns['State']) && $rowData[$duplicate_validColomns['State']] != ""){
			
			$wherefld['UPPER(cm_State)']=strtoupper(trim($rowData[$duplicate_validColomns['State']]));
			//$rowData[$duplicate_validColomns['State']] = trim($rowData[$duplicate_validColomns['State']]);
		}
		if(!empty($duplicate_validColomns['County']) && $rowData[$duplicate_validColomns['County']] != ""){
			
			$wherefld['UPPER(cm_title)']=strtoupper(trim($rowData[$duplicate_validColomns['County']]));
			//$rowData[$duplicate_validColomns['County']] = trim($rowData[$duplicate_validColomns['County']]);
		}
		//print_r($wherefld); exit;
		$this->loadModel('CountyMst');
		if(!empty($wherefld)){
			$CountyTitle = $this->CountyMst->getCountyTitle($wherefld);	
		}
		
		return $CountyTitle;
	}
    
	public function setCompanyMappingsFields($companyid,$columnData)
	{
		 
		// all fiels from import sheet table for company Id
		$this->loadModel('CompanyImportFields');
		$partnerImportFields = $this->CompanyImportFields->companyMapImportFields($companyid);
       
		$this->loadModel('CompanyFieldsMap');
		// original mapping fields
		$partnerFieldsError = $this->CompanyFieldsMap->mapFieldsByCompanyId($companyid, $columnData);
        
       
		if(empty(array_filter($partnerImportFields))){
			// if company id blank then add default fields name ****** IMP
            $this->loadModel('FilesMainData');
			$partnerImportFields = $this->FilesMainData->getTableFileds();
		}
     
		// need to sent one by one column name to search
		$mapCSVFieldsTitle = [];
		 
		foreach($columnData as $col){
			//if(is_int($col))
			$mapCSVFieldsTitle[] = $this->CompanyFieldsMap->checkMapFieldsTitle($companyid, $col);
		}
		
		//echo '<pre>';
		//print_r($mapCSVFieldsTitle);
		//print_r($columnData);
		//print_r($partnerImportFields); //exit;
 
        // get duplicate values and is_empty flag and other valid column check
		$duplicate_validColomns = $this->checkDuplicateAndValidColumn($mapCSVFieldsTitle, $columnData, $partnerImportFields);
       // print_r($duplicate_validColomns); 
        //print_r($partnerFieldsError); 
		
		//exit;
		return ['partnerImportFields'=>$partnerFieldsError,'mapCSVFieldsTitle'=>$mapCSVFieldsTitle,'duplicate_validColomns'=>$duplicate_validColomns];
 
    }


	private function checkDuplicateAndValidColumn(array $mapArray, array $columnData, array $importFields)
	{
      
		$duplicateError =['transtypecolno'=>'','ClientFlNocolno'=>'','partnerIDcolno'=>'','NATFlNo'=>0,'County'=>'','State'=>'','isEmptyColumn'=>false];
 
		$arrValCount = array_count_values($mapArray);
 
		$id ='';
//echo '<pre>';
		  //print_r($arrValCount); exit;
		foreach($arrValCount as $value => $count)
		{
		    $id = array_search($value, $mapArray);

			// check duplicate values in column
			if($count > 1 && !empty($value))
				$duplicateError['duplicate'][]  = $columnData[$id]; // search key of value
			
			// check empty values in column
			if(empty($value)){
				$duplicateError['isEmptyColumn']  = true;
			}
			//check not match values in column
           
			if(!empty($value) && !in_array($value, $importFields)){
                $duplicateError['errcols'][] = $columnData[$id];  // column which are not match 
			}

			if($value == "TransactionType"){ //TransactionType
				$duplicateError['transtypecolno'] = $id;
			}
			if($value == "PartnerFileNumber"){ // PartnerFileNumber
				$duplicateError['ClientFlNocolno'] = $id;
			}
			if($value == "NATFileNumber"){ // NATFileNumber
				$duplicateError['NATFlNo'] = 1;
			}

			if($value == "State"){
				$duplicateError['State'] = $id;
			}

			if($value == "County"){
				$duplicateError['County'] = $id;
			}
			 
			if($value == "PartnerID"){ //PartnerID
				$duplicateError['partnerIDcolno'] = $id;
				$duplicateError['partneridcolname'] = $value;
			}

			/* if($value == "PartnerID"){ //PartnerID
				$duplicateError['partnerIDcolno'] = $id;
				$duplicateError['partneridcolname'] = 'company_mst_id';
			} */

		}
		
		return $duplicateError ;

	}

	public function getCSVFormatAjax()
	{
		$this->autoRender = false;		
		$companyid = $this->request->getData('companyid');
		
		$this->loadModel('CompanyImportFields');
		$partnerImportFields = $this->CompanyImportFields->companyMapImportCVSData($companyid);
		
	
		$getCSVRow = '';
		foreach($partnerImportFields as $key=>$partnerImportField){
			foreach($partnerImportField as $key1=>$partnerImport){		
				$getCSVRow .= '<td><b>'.$partnerImport.'</b></td>'; 	
			}
		}
		
		/*$getCSVRow .= '<td><b>NAT File Number</b></td>'; 
		$getCSVRow .= '<td><b>Partner File Number</b></td>'; 
		$getCSVRow .= '<td><b>Partner Name (ID #)</b></td>'; 
		$getCSVRow .= '<td><b>FileStartDate</b></td>'; 
		$getCSVRow .= '<td><b>Transaction Type</b></td>'; 
		$getCSVRow .= '<td><b>Loan Amount</b></td>'; 
		$getCSVRow .= '<td><b>Loan Number</b></td>'; 
		$getCSVRow .= '<td><b>Street Number</b></td>'; 
		$getCSVRow .= '<td><b>Street Name</b></td>'; 
		$getCSVRow .= '<td><b>City</b></td>'; 
		$getCSVRow .= '<td><b>County</b></td>'; 
		$getCSVRow .= '<td><b>State</b></td>'; 
		$getCSVRow .= '<td><b>Zip</b></td>'; */
		
		echo $getCSVRow; 
		exit;
	}
 
}