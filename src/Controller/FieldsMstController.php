<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * FieldsMst Controller
 *
 * @property \App\Model\Table\FieldsMstTable $FieldsMst
 * @method \App\Model\Entity\FieldsMst[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FieldsMstController extends AppController 
{
    public $pageLimit = ['limit' => 999999999999, 'maxLimit' => 999999999999];
    public $dateFldTable = ['fmd'=>"fmd.DateAdded", 'fcd'=>"fcd.CheckInProcessingDate", 'fqcd'=>"fqcd.QCProcessingDate", 'fsad'=>"fsad.ShippingProcessingDate", 'fad'=>"fad.AccountingProcessingDate", 'frd'=>"frd.RecordingProcessingDate", 'frtp'=>"frtp.RTPProcessingDate"];
    public  $columnFields; 
    public function initialize(): void 
   { 
	   parent::initialize();  
   }
 
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // set page title
        $pageTitle = 'FIELDS LISTING';
        $this->set(compact('pageTitle'));

        //$fieldsMst = $this->paginate($this->FieldsMst, $this->pageLimit);
 
        $fieldSections = $this->FieldsMst->getFieldSectionData();
    
        $this->set(compact('fieldSections'));
    }
    
    //CHK
    public function mapCompanyField($id = null)
    {
        // set page title
        $pageTitle = 'Map Company Fields';
        $this->set(compact('pageTitle'));

        $this->loadModel('CompanyFieldsMap');
          
        if(($this->request->getData('cfm_companyid') !== null) && !empty($this->request->getData('cfm_companyid')))
	    $id = $this->request->getData('cfm_companyid');
	 
		$companyFieldsMap = $this->CompanyFieldsMap->newEmptyEntity();

        // save default export setting
       
           /*if ($this->request->is(['patch', 'post', 'put'])  && ($this->request->getData('defaultExportBtn') !== null)) {
                
                // add 
                $this->loadModel('CompanyExportFields'); 
                $this->CompanyExportFields->deleteall(['CompanyExportFields.cef_companyid'=>$id]);
                $this->CompanyExportFields->insertExportFieldsData($id);

                $this->Flash->success(__('Default export fields setup successfully!!'));  
    
            }*/

            // add new field map from inputs
            if($this->request->is(['patch', 'post', 'put']) && ($this->request->getData('saveBtn') !== null)) {
 
                try{
                    foreach($this->request->getData('cfm_fieldid') as $key => $value){
                        $cfm_id = $this->request->getData('cfm_id')[$key];
                        $companyFieldsMap = '';
                        $cfm_group = (!empty($this->request->getData('cfm_group')[$value]) ? trim($this->request->getData('cfm_group')[$value]): '');
                        if($cfm_id == ''){
                            // add new entry
                            $companyFieldsMap = $this->CompanyFieldsMap->newEmptyEntity();
                            $companyFieldsMap = $this->CompanyFieldsMap->patchEntity($companyFieldsMap, [
                                                    'cfm_companyid' => $this->request->getData('cfm_companyid'),
                                                    'cfm_fieldid'   => $value,
                                                    'cfm_maptitle' 	=> trim($this->request->getData('cfm_maptitle')[$key]),
                                                    'cfm_group'  => $cfm_group
                                                    ] //,['validate'=>false]
                                                );
    
                        }else{
    
                             $companyFieldsMap = $this->CompanyFieldsMap->get($cfm_id);
                             $companyFieldsMap = $this->CompanyFieldsMap->patchEntity($companyFieldsMap, [
                                                    'cfm_companyid' => $this->request->getData('cfm_companyid'),
                                                    'cfm_fieldid'   => $value,
                                                    'cfm_maptitle'  => trim($this->request->getData('cfm_maptitle')[$key]),
                                                    'cfm_group'  => $cfm_group
                                                    ] //,['validate'=>false]
                                                );
    
                        } // else
   
                        $this->CompanyFieldsMap->save($companyFieldsMap);
                      
                    } // foreach
                    
                    $this->Flash->success(__('Partner fields map has been saved.'));
                }catch (Exception $e) {
                    $this->Flash->error(__('Partner fields map could not be saved. Please, try again.'));
                }
            }
    



        if($id != null)
        $companyFieldsMap = $this->CompanyFieldsMap->find()->where(['cfm_companyid'=>$id])->limit(1000);
      
        $companyFieldArray = array();
        if($companyFieldsMap){
            foreach($companyFieldsMap as $companyField){
                $companyFieldArray[$companyField['cfm_fieldid']][] = $companyField['cfm_id'];
                $companyFieldArray[$companyField['cfm_fieldid']][] = $companyField['cfm_maptitle'];
                $companyFieldArray[$companyField['cfm_fieldid']][] = $companyField['cfm_group'];
            }
        }
       
        $companyMsts = $this->CompanyFieldsMap->CompanyMst->companyListArray();
        //$fieldsMsts = $this->CompanyFieldsMap->FieldsMst->listFields();
        $fieldsSectionData = $this->FieldsMst->getFieldSectionData();
        $fieldsMsts = $this->CompanyFieldsMap->newEmptyEntity();
        $this->set(compact('companyFieldsMap', 'companyFieldArray', 'companyMsts', 'fieldsMsts', 'fieldsSectionData')); //, 'fieldsMsts'
        $this->set('_serialize', ['companyFieldsMap']);
  
    }

    //CHK
    public function importCompanyField($id=null)
    {
         // set page title
         $pageTitle = 'Import Company Fields';
         $this->set(compact('pageTitle'));
    
        $this->loadModel('CompanyFieldsMap');
        $this->loadModel('CompanyImportFields');
        if(($this->request->getData('cfm_companyid') !== null) && !empty($this->request->getData('cfm_companyid')))
	    $id = $this->request->getData('cfm_companyid');
	  
        $companyImportFields = $companyFieldsMap = array();
        if($this->request->is(['patch', 'post', 'put']) && ($this->request->getData('saveBtn') !== null)) {
             
            try{    
                $companyImportId = $this->request->getData('companyImportId');
                $company_mst_id = $this->request->getData('cfm_companyid');
                $cif_fieldid = array_filter($this->request->getData('cif_fieldid'));
              
                $cif_fieldid = implode(',', $cif_fieldid);

                if($companyImportId != ''){
                // update
                    $companyImportFields = $this->CompanyImportFields->get($companyImportId);
                    $companyImportFields = $this->CompanyImportFields->patchEntity($companyImportFields, [
                                                'cif_fieldid' => $cif_fieldid 
                                                ] //,['validate'=>false]
                                            );
                }else{
                // add
                    $companyImportFields = $this->CompanyImportFields->newEmptyEntity();
                    $companyImportFields = $this->CompanyImportFields->patchEntity($companyImportFields, [
                                                'cif_companyid' => $company_mst_id,
                                                'cif_fieldid' => $cif_fieldid 
                                                ] //,['validate'=>false]
                                            );
                }

                $this->CompanyImportFields->save($companyImportFields);
         
                $this->Flash->success(__('The Partner Import Sheet Setting has been saved.'));

            }catch (Exception $e) {
                $this->Flash->error(__('Partner Import Sheet Setting could not be saved. Please, try again.'));
            }
        }
  
        if($id != null){
            $companyFieldsMap = $this->CompanyFieldsMap->find()->where(['cfm_companyid'=>$id])->limit(100);
            $companyImportFields = $this->CompanyImportFields->importFieldsData($id);
        }
       
        $companyFieldArray = array();
        if($companyFieldsMap){
            foreach($companyFieldsMap as $companyField){
                  
                $companyFieldArray[$companyField['cfm_fieldid']][] = $companyField['cfm_id'];
                $companyFieldArray[$companyField['cfm_fieldid']][] = $companyField['cfm_maptitle'];
            }
        }
       
        $companyMsts = $this->CompanyFieldsMap->CompanyMst->companyListArray();
       //$fieldsMsts = $this->CompanyFieldsMap->FieldsMst->listFields();
        $fieldsSectionData = $this->FieldsMst->getFieldSectionData();
        $fieldsMsts = $this->CompanyImportFields->newEmptyEntity();
        $this->set(compact('companyFieldsMap', 'companyFieldArray', 'companyImportFields', 'companyMsts', 'fieldsMsts', 'fieldsSectionData')); //, 'fieldsMsts'
        $this->set('_serialize', ['companyFieldsMap']);
 
    }

    //CHK
    public function exportCompanyField()
    {
        // set page title
        $pageTitle = 'Export Company Fields';
        $this->set(compact('pageTitle'));
        // check for admin permission to access
        $this->groupUserAccess();

        $this->loadModel('CompanyExportmapSettings');
        $this->loadModel('CompanyFieldsMap'); 
        $this->loadModel('CompanyMst'); 
        
        $postData = $partnerMapFields = $reportData = [];
        if($this->request->is(['patch', 'post', 'put'])) {
            $postData = $this->request->getData();
        //    pr($postData);
            if(!empty($postData['export_fields'])){ 
                if($this->request->getData('runReportBtn') !== null){
                    //data export functionality
                   // $reportData = $this->CompanyExportmapSettings->fetchReports($record_id);  
                    
                    if($this->_generateRecordExport($postData)){
                       // $this->Flash->success(__('Export sheet setting download successfully!'), ['escape'=>false]);
                    }else{
                        $this->Flash->error(__('Records not found for selected filters!'), ['escape'=>false]);
                    }
                }

                if($this->request->getData('saveReportBtn') !== null){
                  
                    $postData['export_fields'] = @serialize($postData['export_fields']);
                   
                    $record_id = $this->CompanyExportmapSettings->addExportSetting($postData);
                    // for disply after post
                    $postData['export_fields'] = @unserialize($postData['export_fields']);
                    $postData['report_id'] = $record_id;
                    $this->Flash->success(__('Export sheet setting added successfully!'), ['escape'=>false]);
                }
                
            }else{
                $this->Flash->error(__('Please select fields for export sheet!'), ['escape'=>false]);
            }

           
        }
        if(isset($_GET['record_id'])) {
            $record_id = $_GET['record_id'];
            $reportData = $this->CompanyExportmapSettings->fetchReports($_GET['record_id']);  
        }

        /* if(isset($postData['company_id'])) {
            $partnerMapFields =  $this->CompanyFieldsMap->partnerMapFields($postData['company_id'],1, false);
        }  */

        $fieldsSectionData = $this->FieldsMst->getFieldSectionData();
         
        // pr($fieldsSectionData);
     
        $fieldsMsts = $this->CompanyExportmapSettings->newEmptyEntity();
      
        $listReports = $this->CompanyExportmapSettings->listReports();
       
        $partnerlist = $this->CompanyMst->companyListArray(); 

        $this->set(compact('fieldsSectionData','partnerlist', 'fieldsMsts', 'postData', 'listReports','reportData', 'partnerMapFields'));
    }
  
    
    private function _setCondition($reportData){
        $condition = []; 
        if(!empty($reportData['company_id'])) 
            $condition = @array_merge($condition,['fmd.company_id'=>$reportData['company_id']]); 

        /*if(!empty($reportData['document_status'])){
            if($reportData['document_status'] == 'Y'){ 
                $condition = ['fcd.DocumentReceived'=>'Y'];  
            }elseif($reportData['document_status'] == 'N'){ 
                $condition = ['fcd.DocumentReceived in' => ['', 'N']];  
            }elseif($reportData['document_status'] == 'P'){ 
                $condition = ['fcd.DocumentReceived'=>''];  
            }else{
                $this->columnFields = array_merge($this->columnFields,['fqcd.Status']); //,
                $condition = ['fqcd.Status != '=>'OK'];   
            }
        }*/
		
		if(!empty($reportData['document_status'])){
            if($reportData['document_status'] == '1'){ 
                $condition = @array_merge($condition,['fva.TransactionType'=>'1']);  
            }elseif($reportData['document_status'] == '2'){ 
                $condition = @array_merge($condition,['fva.TransactionType'=>'2']);  
            }elseif($reportData['document_status'] == '3'){ 
                $condition = @array_merge($condition,['fva.TransactionType'=>'3']);  
            }elseif($reportData['document_status'] == '4'){ 
                $condition = @array_merge($condition,['fva.TransactionType'=>'4']);  
            }			
        }
		
        //if(!empty($reportData['date_from']) && (!empty($reportData['date_section']))){
		if(!empty($reportData['date_from']) ){
            if(empty($reportData['date_to'])){$reportData['date_to'] = $reportData['date_from'];}
            //$condition = @array_merge($condition,[$this->FilesMainData->dateBetweenWhere($reportData['date_from'],$reportData['date_to'], $this->dateFldTable[$reportData['date_section']])]);
			$condition = @array_merge($condition,[$this->FilesMainData->dateBetweenWhere($reportData['date_from'],$reportData['date_to'], $this->dateFldTable['fmd'])]);
            // add column to search in query as per selected section
            //$this->columnFields = array_merge($this->columnFields, [$this->dateFldTable[$reportData['date_section']]]);   
            $this->columnFields = array_merge($this->columnFields, [$this->dateFldTable['fmd']]);   
           
        } 

        return $condition;
    }



    private function _generateRecordExport($reportData){
        //Imp Here we are not using company mapping.
        $columnHeaders = $this->FieldsMst->checkMapFieldsExportNew($reportData['company_id'], $reportData['export_fields']);
 //echo '<pre>';
 
// print_r($columnHeaders);
        $this->columnFields = array_keys($columnHeaders); 
       
        // get data from fields with table alies
        $this->loadModel('FilesMainData');
        $condition = $this->_setCondition($reportData);
    //print_r($condition);
        $listExportData = $this->FilesMainData->dataExportNew($this->columnFields, $condition);
//print_r($listExportData); exit;
        // create and download file
        if(!empty($listExportData)){ 
            //$columnFields = array_merge($columnFields); //['cpm.company_id'], 
            @array_pop($this->columnFields);
            $listRecord = $this->FilesMainData->setListRecords($listExportData, $this->columnFields);
           // pr($listRecord); exit;
            $csvFilename = $this->CustomPagination->recordExport($listRecord, $columnHeaders,$reportData['sheet_name'].'export','export');
            $this->set('csvFilename', $csvFilename);
            //$this->sampleExport($csvFilename, 'export');
            return true;
        }
        return false;
       // return $csvFilename;
        
    }


    // delete report
    public function deleteReport($id = null)
    {
        $this->loadModel('CompanyExportmapSettings');
        //$this->request->allowMethod(['post', 'delete']);
		$companyExport = $this->CompanyExportmapSettings->get($id);

        if ($this->CompanyExportmapSettings->delete($companyExport)) { 
            $this->Flash->success(__('Memorized Report has been deleted.'));
        } else {
            $this->Flash->error(__('Memorized Report could not be deleted. Please, try again.'));
        } 
		
        return $this->redirect(['action' => 'exportCompanyField']);
    }

}
