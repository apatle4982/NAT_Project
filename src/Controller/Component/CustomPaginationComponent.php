<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

use Cake\View\View;
use Cake\View\ViewBuilder;
use Cake\Routing\Router;
use Cake\Filesystem\File;
use Cake\ORM\TableRegistry;
use App\Model\Entity\User;
/**

 * Custompagination component
 */
class CustomPaginationComponent extends Component
{

	protected $_defaultConfig = [];
    private $paginationData=[];
    private $columns=[];
	private $columns_alise=[];
	private $modelName;
	private $conditionMain=[];
	private $is_search= false;
	private $user_groupId;
    /**
     * Default configuration.
     *
     * @var array
     */
   
	
	// set random number sting 
	public function randomDigit($digits=3)
	{  
      static  $startseed  =  0;  
      if  (!$startseed)  {
            $startseed  =  (double)microtime()*getrandmax();  
            srand($startseed);
      }

      $range  =  8;
      $start  =  1;
      $i  =  1;

      while  ($i<$digits)  {
            $range  =  $range  .  9;
            $start  =  $start  .  0;
            $i++;
      }
      return  (rand()%$range+$start);  
	}
	 
	public function mapfields($colarr, $company_id) {
		foreach($colarr as $col) {
			$retcolarr[] = mapfield($col, $company_id);
		}
		return $retcolarr;
	}
	
	public function has_dupes($array) {
		$dupe_array = array();
		foreach($array as $val) {
			if(++$dupe_array[$val] > 1) {
				return $val;
			}
		}
		return false;
	}

	public function f_addslashes(& $x, $y) {
		$x = addslashes($x);
	}
	
	public function recordExport(array $data,array $columnHeaders,$prifix,$folderpath=null) 
	{ 
		$_serialize = 'data';
		$_header = $columnHeaders;
 
		$builder = new ViewBuilder;
		$builder->layout = false;
		$builder->setClassName('CsvView.Csv');

		// Then the view
		$view = $builder->build($data); 
		$view->set(compact('data', '_serialize', '_header'));
		$csvFile = WWW_ROOT.'files'.DS.$folderpath.DS.$prifix.'.csv';
 
		// And Save the file
		$file = new File($csvFile, true, 0644);
		$file->write($view->render());
		$sdsd = $file->read();
		$file->close();
		//echo "<pre>";print_r($sdsd);exit;
		return $prifix.'.csv';
	}

	public function setPaginationData(array $pdata) {
		if(array_key_exists('request',$pdata)) $this->paginationData = $pdata['request'];
		
		if(array_key_exists('columns',$pdata)) $this->columns = $pdata['columns'];
		if(array_key_exists('columnAlise',$pdata)) $this->columns_alise =$pdata['columnAlise'];
		if(array_key_exists('modelName',$pdata)) $this->modelName = $pdata['modelName'];
		 
		// set user group id details from controller to component
		$this->user_groupId = $this->getController()->currentUser->user_groupId;
    }

	public function setDataJson($columns_alise, array $nonOrder=[]){
        $jdata= $this->_getDataJson($columns_alise, $nonOrder);
        return $jdata;
    }

	public function getQueryData(){
        $pdata['draw'] = $this->_getDraw();
		$pdata['condition'] = $this->_getConditionMain();
		$pdata['is_search'] = $this->is_search;
        return $pdata;
    }
	
	private function _getConditionMain(){
		 $this->conditionMain = [ 
								'search' => [],
								'fields'=>$this->columns_alise ,
								'conditions'=>[],
								'order'=> $this->_getOrderByMultiColumn(),
								//[$this->_getOrderByColumnIndex() => $this->_getOrderType()], 
								'offset' => $this->_getStart(),
								'limit' => $this->_getLength()
							  ];
    	$conditionVar = [];
		//datatable globel search
		if(!empty($this->_getSearchValue())){
			foreach($this->columns_alise as $key=>$field){
				if (strpos($field, '.') !== false) {
					$fld = $field;
				}else{
					$fld = $this->modelName.'.'.$field;
				}
				$conditionVar[] = [$fld.' LIKE' => '%'. $this->_getSearchValue() .'%'];
			}

			$conditions_or  = ['OR'=>$conditionVar];
			$this->conditionMain['conditions']= $conditions_or;
			$this->is_search= true;
		}
    
       // custom search fields post
		if(!empty($this->_getformdataValue())){
			$this->conditionMain['search']=$this->_getformdataValue();
			$this->is_search = true;
		}
		
		//pr($this->conditionMain);
		return $this->conditionMain;
		
    }

	private function _getformdataValue(){
    	return $this->paginationData["formdata"];
    }
	
    private function _getDraw(){
    	return $this->paginationData["draw"];
    }

	private function _getOrderByColumnIndex(){
		
    	$colIndex =  $this->paginationData['order'][0]['column'];
		
    	if(isset($this->paginationData['order'][0]['column'])){ 
    		return $this->columns[$colIndex]; 
    	}else{ 
    		return $this->columns[0]; 
    	}
    }

	private function _getOrderType(){
    	if(isset($this->paginationData['order'][0]['dir'])){ 
    		return $this->paginationData['order'][0]['dir']; 
    	}else{ 
    		return "ASC"; 
    	}
    }

	private function _getOrderByMultiColumn(){
		//pr($this->paginationData['order']);
		if(isset($this->paginationData['order']) && is_array($this->paginationData['order'])){
			$columns = [];
			foreach($this->paginationData['order'] as $orderCols){
				
				if(isset($orderCols['column'])){ 
					$columns = array_merge($columns, [$this->columns[$orderCols['column']] =>(isset($orderCols['dir']) ?  $orderCols['dir'] : 'ASC')]); 
				}	
			}
			return $columns;
		}else{ 
			return [$this->columns[0]=>'ASC']; 
		}

	}

	private function _getStart(){
    	if(isset($this->paginationData["start"])){ 
    		return $this->paginationData["start"]; 
    	}else{ 
    		return 0; 
    	}
    }

	private function _getLength(){
    	if(isset($this->paginationData["length"])){ 
    		return $this->paginationData['length']; 
    	}else{
    		return "10"; 
    	}
    }

	private function _getSearchValue(){
    	if(!empty($this->paginationData['search']['value'])){
        	return $this->paginationData['search']['value'];
	    }else{
	       return "";
	    }
    }

	private function _getDataJson($columns_alise,array $nonOrderable){
		$dataJson = [];
		foreach($columns_alise as $key=>$field){
			
			$orderable = true;
			if(in_array($key,$nonOrderable))$orderable = false;
			$dataJson[] = ['data'=>$key,'orderable'=>$orderable];
			
		}
		return json_encode($dataJson);
	}

	/**
     * getActionButtons method
     *
     * @param string|array|array|null|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
	 
	 public function getUserActionButtons($modelName,$value,array $key,$page){
		$text = '';
		
		$controller = $this->getController();      
        $actionName = $controller->getRequest()->getParam('action');
				
		$files_exam_receipt_Table = TableRegistry::getTableLocator()->get('FilesExamReceipt');
		$data = $files_exam_receipt_Table->find()->where(['RecId' => $value[$key[1]]])->first();

		$FilesAolAssignment = TableRegistry::getTableLocator()->get('FilesAolAssignment');
		$aoldata = $FilesAolAssignment->find()->where(['RecId' => $value[$key[1]]])->first();

		$filePath = WWW_ROOT . 'files' . DS . 'export' . DS . 'aol_assignment' . DS . 'pdf' . DS  . "final" . DS . "AssignmentDetails-".$value[$key[0]].".pdf";
		$fileUrl = Router::url('/files/export/aol_assignment/pdf/aol_signed/' . "AssignmentDetails-" . $value[$key[0]] . ".pdf", true);
		
		switch($page){
			case 'County': 
				$text .= '<a href="'.Router::url(['controller' => $modelName,'action' => 'view/'.$value[$key[0]]]).'" title="View" class="link-success fs-15"><i class="ri-file-search-line" aria-hidden="true"></i></a>';
			break;
			case 'common': 
			    if($actionName == "ajaxListAolindexPartner"){
    				if($data['RecId']){
    					if($aoldata['pre_aol_status']=='Y'){
    						$text .= '<a href="'.Router::url(['controller' => 'pdf','action' => 'generatePdf/'.$data['RecId']]).'" title="Download Preliminary AOL PDF" class="link-success fs-15"><i class="ri-file-download-line" aria-hidden="true" style="color:#808080 !important;"></i></a> ';
    						
    					}
    					if($aoldata['final_aol_status']=='Y'){
    						$text .= '<a href="'.Router::url(['controller' => 'pdf','action' => 'generatePdf/'.$data['RecId'].'/finalpdf']).'" title="Download Final AOL PDF" class="link-success fs-15"><i class="ri-file-download-line" aria-hidden="true" style="color:#0000ff !important;"></i></a> ';
    						
    					}
    					if($aoldata['submit_aol_status']=='Y'){
    						$text .= '<a download href="'.$fileUrl.'" title="Download Signed AOL PDF" class="link-success fs-15"><i class="ri-file-download-line" aria-hidden="true" style="color:#f1702b !important;"></i></a> ';
    						
    					}
    				}
    			}
				$text .= '<a href="'.Router::url(['controller' => $modelName,'action' => 'view/'.$value[$key[1]].'/'.$value[$key[2]]]).'" title="View" class="link-success fs-15"><i class="ri-file-search-line" aria-hidden="true"></i></a> ';
				$text .= $this->urlPublicNote($value[$key[1]],$value[$key[2]]);
			break;
			case 'complete':
			
				if(($key[2] == 'File') && (!empty($value[$key[2]]))){  
					$text .= '<a href="'.Router::url(['controller' => 'MasterData','action' => 'viewpdf/'.$value[$key[0]].'/'.$value[$key[1]]]).'" title="View file" target="_blank" class="link-success fs-15"><i class="las la-file-pdf" aria-hidden="true"></i></a> '; 
				}

				//$text .= '<a href="'.Router::url(['controller' => 'PublicNotes','action' => 'viewComplete/'.$value[$key[0]].'/'.$value[$key[1]]]).'" title="View Details" class="link-success fs-15"><i class="ri-file-search-line" aria-hidden="true"></i></a> ';
				$text .= '<a href="'.Router::url(['controller' => 'MasterData','action' => 'master_view/'.$value[$key[0]]]).'" title="View Details" class="link-success fs-15"><i class="las la-search" aria-hidden="true"></i></a> ';
				$text .= $this->urlPublicNote($value[$key[0]],$value[$key[1]]); 
			break;
			
		}
		return $text;
	}
	
	public function getActionButtons($modelName,$value,array $key,$prifix=null,$hideViewBtn = 0,$other=null){
		$controller = $this->getController();
        $controllerName = $controller->getRequest()->getParam('controller');
        $actionName = $controller->getRequest()->getParam('action');

        $FilesVendorAssignment_Table = TableRegistry::getTableLocator()->get('FilesVendorAssignment');
        $fvadata = $FilesVendorAssignment_Table->find()->where(['RecId' => $value[$key[0]]])->first();

		$controller = $this->_registry->getController();

        $identity = $controller->Authentication->getIdentity();
        $authUser = $identity ? $identity->getOriginalData() : null;

		if($hideViewBtn == 1 )
		{	
			$text = '';
			// lock 
			 
			if($value[$key[4]] == 1){ // checkin page 
				//$text .= '<a href="javascript:void(null);" title="Un Lock" onclick="openLockModel('.$value[$key[2]].',0)" class="lock-a link-danger fs-15"><i class="las la-lock" aria-hidden="true"></i></a> ';
			}else{
				//$text .= '<a href="javascript:void(null);" title="Lock" onclick="openLockModel('.$value[$key[2]].',1)" class="lock-a link-success fs-15"><i class="las la-lock-open" aria-hidden="true"></i></a> ';
			}
			
			// edit, delete & public note
			if($modelName == "FilesExamReceipt") {

				if ($authUser->isSuperAdmin_Or_isLimited()) {
					$text .= '<a href="'.Router::url(['controller' => $modelName,'action' => 'exam_receipt'.$prifix.'/'.$value[$key[0]]]).'" title="Exam Receipt" class="link-success fs-15" data-value="'.$modelName.'"><i class="ri-edit-2-line" aria-hidden="true"></i></a> ';
				}	

			} elseif($modelName == "FilesRecordingData") {

				if ($authUser->isSuperAdmin_Or_isLimited()) {
					$text .= '<a href="'.Router::url(['controller' => $modelName,'action' => 'recording_data'.$prifix.'/'.$value[$key[0]]]).'" title="Exam Receipt" class="link-success fs-15" data-value="'.$modelName.'"><i class="ri-edit-2-line" aria-hidden="true"></i></a> ';
				}	
			} else {
			// edit, delete & public note
            if($controllerName == "FilesVendorAssignment" and $actionName == "ajaxListIndex"){
                if($fvadata['vendorid'] > 0){
                    $text .= '<a href="'.Router::url(['controller' => 'pdf','action' => 'exampdf'.$prifix.'/'.$fvadata['RecId']]).'" title="Download Search and Exam PDF template" class="link-success fs-15"><i class="ri-search-line" aria-hidden="true"></i></a> ';
                }
            }
			if ($authUser->isSuperAdmin_Or_isLimited()) {
				$text .= '<a href="'.Router::url(['controller' => $modelName,'action' => 'edit'.$prifix.'/'.$value[$key[2]]]).'" title="Edit" class="link-success fs-15"><i class="ri-edit-2-line" aria-hidden="true"></i></a> ';
			}	
			}
			
			$text .= $this->urlPublicNote($value[$key[0]],$value[$key[3]], 'fva');
			
			//if(in_array($this->user_groupId, eval(OWNERGRP))){
				//$text .='<a href="'.Router::url(['controller' => $modelName,'action' => 'delete/'.$value[$key[2]]]).'" title="Delete" class="link-danger fs-15" onclick="if (confirm(&quot;Are you sure you want to delete record # '.$value[$key[1]].'?&quot;)) { return true; } event.returnValue = false; return false;"><i class="ri-delete-bin-line" aria-hidden="true"></i></a>';
			
			if($modelName == "FilesExamReceipt" || $modelName == "FilesRecordingData") {
				/*
				** LOCK NOT REQUIRED
				*/
			} else {
				if ($authUser->isSuperAdmin()) {
					$text .= '<a href="javascript:void(null);" title="Delete" onclick="openPasswordModel('.$value[$key[2]].')" class="link-danger fs-15"><i class="ri-delete-bin-line" aria-hidden="true"></i></a> ';
				}	
			}
			//}
			
			return $text;
		}
		elseif($hideViewBtn == 2 ) // Ship to County
		{ 
			$text =''; 
			if ($authUser->isSuperAdmin_Or_isLimited()) {
				$text .= '<a href="'.Router::url(['controller' => $modelName,'action' => 'edit'.$prifix.'/'.$value[$key[0]].'/'.$value[$key[3]].'/fsad']).'" title="Edit" class="link-success fs-15"><i class="ri-edit-2-line" aria-hidden="true"></i>'.$this->pageType.'</a> ';
			}	
			
			$text .= $this->urlPublicNote($value[$key[0]],$value[$key[3]], 'fsad');
			return $text;
		} 
		elseif($hideViewBtn == 3 )
		{ 
			// View pdf & viewComplete & Public Note
			// call from  complete records and master pages
			// $prefix is change here for differant uses
			$text ='';
			if(($key[1] == 'File') && $prifix == 'CR'){ // CR is $is_index variable
				// only for complete order page
				$text .= '<a href="'.Router::url(['controller' => 'MasterData','action' => 'viewpdf/'.$value[$key[0]].'/'.$value[$key[3]]]).'" title="View file" target="_blank" class="link-success fs-15"><i class="las la-file-pdf" aria-hidden="true"></i></a> '; 
			}

			$text .= '<a href="'.Router::url(['controller' => 'MasterData','action' => 'master_view/'.$value[$key[0]]]).'" title="View Details" class="link-success fs-15"><i class="las la-search" aria-hidden="true"></i></a> ';
			
			//$text .= '<a href="'.Router::url(['controller' => 'PublicNotes','action' => 'viewComplete/'.$value[$key[0]].'/'.$value[$key[3]]]).'" title="View Details" class="link-success fs-15"><i class="ri-file-search-line" aria-hidden="true"></i></a> ';
			
			$text .= $this->urlPublicNote($value[$key[0]],$value[$key[3]]);
			return $text;

		}
		elseif($hideViewBtn == 4 ) // Recording
		{
			$text =''; 
			if(($key[1] == 'File') && (!empty($value[$key[1]]))){ 
				$text .= '<a href="'.Router::url(['controller' => 'MasterData','action' => 'viewpdf/'.$value[$key[0]].'/'.$value[$key[3]]]).'" title="View file" target="_blank" class="link-success fs-15"><i class="las la-file-pdf" aria-hidden="true"></i></a> '; 
			}
			if($prifix == 'keynoImage') {
				if ($authUser->isSuperAdmin_Or_isLimited()) {
					$text .= '<a href="'.Router::url(['controller' => $modelName,'action' => 'edit/'.$value[$key[0]].'/'.$value[$key[3]].'/'.$prifix.'/frd-noimg']).'" title="Edit"  class="link-success fs-15"><i class="ri-edit-2-line" aria-hidden="true"></i>'.$this->pageType.'</a> ';
				}	
			 
				$text .= $this->urlPublicNote($value[$key[0]],$value[$key[3]],'frd-noimg');
				return $text;
			}if($prifix == 'research') {
				if ($authUser->isSuperAdmin_Or_isLimited()) {
					$text .= '<a href="'.Router::url(['controller' => $modelName,'action' => 'edit/'.$value[$key[0]].'/'.$value[$key[3]].'/'.$prifix.'/frd-research']).'" title="Edit"  class="link-success fs-15"><i class="ri-edit-2-line" aria-hidden="true"></i>'.$this->pageType.'</a> ';
				}	
			 
				$text .= $this->urlPublicNote($value[$key[0]],$value[$key[3]],'frd-noimg');
				return $text;
			} else {
				if ($authUser->isSuperAdmin_Or_isLimited()) {
					$text .= '<a href="'.Router::url(['controller' => $modelName,'action' => 'edit/'.$value[$key[0]].'/'.$value[$key[3]].'/'.$prifix.'/frd']).'" title="Edit"  class="link-success fs-15"><i class="ri-edit-2-line" aria-hidden="true"></i>'.$this->pageType.'</a> ';
				}	
			 
				$text .= $this->urlPublicNote($value[$key[0]],$value[$key[3]],'frd');
				return $text;
			}
			
		}
		elseif($hideViewBtn == 5 )
		{
			// Only public note option
			$text =''; 
			$text .= $this->urlPublicNote($value[$key[0]],$value[$key[3]],'fsad');
			return $text;
		}
		elseif($hideViewBtn == 6 ) // Rejection Mgmt
		{
			$text =''; 
			if ($authUser->isSuperAdmin_Or_isLimited()) {
				$text .= '<a href="'.Router::url(['controller' => $modelName,'action' => 'edit'.$prifix.'/'.$value[$key[0]].'/'.$value[$key[3]].'/fqcd']).'" title="Edit" class="link-success fs-15"><i class="ri-edit-2-line" aria-hidden="true"></i>'.$this->pageType.'</a> ';
			}	
			
			$text .= $this->urlPublicNote($value[$key[0]],$value[$key[3]],'fqcd'); 
			return $text;
		}
		elseif($hideViewBtn == 7 ) // Accounting
		{
			$text =''; 
			if ($authUser->isSuperAdmin_Or_isLimited()) {
				$text .= '<a href="'.Router::url(['controller' => $modelName,'action' => 'edit'.$prifix.'/'.$value[$key[0]].'/'.$value[$key[3]].'/fad']).'" title="Edit" class="link-success fs-15"><i class="ri-edit-2-line" aria-hidden="true"></i>'.$this->pageType.'</a> ';
			}	
			
			$text .= $this->urlPublicNote($value[$key[0]],$value[$key[3]],'fad');
			return $text;
		}
		elseif($hideViewBtn == 8 ) // return to partner
		{
			$text =''; 
			if ($authUser->isSuperAdmin_Or_isLimited()) {
				$text .= '<a href="'.Router::url(['controller' => $modelName,'action' => 'edit'.$prifix.'/'.$value[$key[0]].'/'.$value[$key[3]].'/rf2p']).'" title="Edit aaa" class="link-success fs-15"><i class="ri-edit-2-line" aria-hidden="true"></i>'.$this->pageType.'</a> ';
			}	
 			$text .= $this->urlPublicNote($value[$key[0]],$value[$key[3]], 'rf2p');
			return $text;
		}
		elseif($hideViewBtn == 9 )
		{ 
			 
			// View pdf & viewComplete & Public Note
			// call from  complete records and master pages
			// $prefix is change here for differant uses
			$text ='';  
			if(!$this->user_Gateway){
				$text .= '<a href="'.Router::url(['controller' => 'PublicNotes','action' => 'viewComplete/'.$value[$key[0]].'/'.$value[$key[1]]]).'" title="View Details" class="link-success fs-15"><i class="ri-file-search-line" aria-hidden="true"></i></a> ';
			}
			$text .= $this->urlPublicNote($value[$key[0]],$value[$key[1]]);
			return $text;

		}else if($hideViewBtn == 10 ){
			$text = '';
            $files_exam_receipt_Table = TableRegistry::getTableLocator()->get('FilesExamReceipt');
            $data = $files_exam_receipt_Table->find()->where(['RecId' => $value[$key[0]]])->first();

            $FilesAolAssignment = TableRegistry::getTableLocator()->get('FilesAolAssignment');
            $aoldata = $FilesAolAssignment->find()->where(['RecId' => $value[$key[0]]])->first();

            $filePath = WWW_ROOT . 'files' . DS . 'export' . DS . 'aol_assignment' . DS . 'pdf' . DS  . "final" . DS . "AssignmentDetails-".$value[$key[0]].".pdf";
            $fileUrl = Router::url('/files/export/aol_assignment/pdf/aol_signed/' . "AssignmentDetails-" . $value[$key[0]] . ".pdf", true);
			//$text .= '<a href="'.Router::url(['controller' => $modelName,'action' => 'aoledit'.$prifix.'/'.$value[$key[0]]]).'" title="Edit" class="link-success fs-15"><i class="ri-edit-2-line" aria-hidden="true"></i></a> ';

                if($data['RecId']){
					
                if($aoldata['pre_aol_status']=='Y'){
                    $text .= '<a href="'.Router::url(['controller' => 'pdf','action' => 'generatePdf/'.$data['RecId']]).'" title="Download Preliminary AOL PDF" class="link-success fs-15"><i class="ri-file-download-line" aria-hidden="true" style="color:#808080 !important;"></i></a> ';
    				//$text .= '<a href="'.Router::url(['controller' => 'pdf','action' => 'emailPdf/'.$data['RecId']]).'" title="Preliminary AOL Email" class="link-success fs-15 email_pop_btn" data-bs-toggle="modal" data-bs-target="#emailModal"><i class="ri-mail-fill" style="color:#808080 !important;" aria-hidden="true" data-bs-id="'.$data['RecId'].'"></i> </a>';
					$text .= '<a href="javascript:void(0)" title="Preliminary AOL Email" class="link-success fs-15 email_pop_btn"><i class="ri-mail-fill" style="color:#808080 !important;" aria-hidden="true" data-bs-id="'.$data['RecId'].'"></i> </a>';
                }

				if($other === 'final_aol_status'){
					if($aoldata['final_aol_status']=='Y'){
						$text .= '<a href="'.Router::url(['controller' => 'pdf','action' => 'generatePdf/'.$data['RecId'].'/finalpdf']).'" title="Download Final AOL PDF" class="link-success fs-15"><i class="ri-file-download-line" aria-hidden="true" style="color:#0000ff !important;"></i></a> ';
						//$text .= '<a href="'.Router::url(['controller' => 'pdf','action' => 'emailPdf/'.$data['RecId']]).'" title="Final AOL Email" class="link-success fs-15 email_pop_btn_final" data-bs-toggle="modal" data-bs-target="#emailModal"><i class="ri-mail-fill" style="color:#0000ff !important;" aria-hidden="true" data-bs-id="'.$data['RecId'].'"></i> </a>';
						$text .= '<a href="javascript:void(0)" title="Final AOL Email" class="link-success fs-15 email_pop_btn_final"><i class="ri-mail-fill" style="color:#0000ff !important;" aria-hidden="true" data-bs-id="'.$data['RecId'].'"></i> </a>';
					}
					if($aoldata['submit_aol_status']=='Y'){
						$text .= '<a download href="'.$fileUrl.'" title="Download Signed AOL PDF" class="link-success fs-15"><i class="ri-file-download-line" aria-hidden="true" style="color:#f1702b !important;"></i></a> ';
						//$text .= '<a href="'.Router::url(['controller' => 'pdf','action' => 'emailPdf/'.$data['RecId']]).'" title="Submit Approved AOL to Client" class="link-success fs-15 email_pop_btn_submit" data-bs-toggle="modal" data-bs-target="#emailModal"><i class="ri-mail-fill" style="color:#f1702b !important;" data-bs-id="'.$data['RecId'].'"></i> </a>';
						$text .= '<a href="javascript:void(0)" title="Submit Approved AOL to Client" class="link-success fs-15 email_pop_btn_submit"><i class="ri-mail-fill" style="color:#f1702b !important;" data-bs-id="'.$data['RecId'].'"></i> </a>';
					}
				}
}
                if(isset($aoldata['RecId'])){
					if ($authUser->isSuperAdmin()) {
						$text .= '<a href="javascript:void(null);" title="Delete" onclick="openPasswordModel('.$data['RecId'].')" class="link-danger fs-15"><i class="ri-delete-bin-line" aria-hidden="true"></i></a> ';
					}	
                }
			return $text;
		}
		else
		{
			$text = '';

			if ($authUser->isSuperAdmin_Or_isLimited()) {
				$text .= '<a href="'.Router::url(['controller' => $modelName,'action' => 'edit'.$prifix.'/'.$value[$key[0]]]).'" title="Edit" class="link-success fs-15"><i class="ri-edit-2-line"></i></a> ';
			}	

			//if(in_array($this->user_groupId, eval(OWNERGRP))){			
			if ($authUser->isSuperAdmin()) {
				$text .='<a href="'.Router::url(['controller' => $modelName,'action' => 'delete'.$prifix.'/'.$value[$key[0]]]).'" title="Delete" class="link-danger fs-15" onclick="if (confirm(&quot;Are you sure you want to delete # '.$value[$key[1]].'?&quot;)) { return true; } event.returnValue = false; return false;"><i class="ri-delete-bin-line"></i></a>';
			}			
			//}
			return $text;
		}
	} 
 
	private function urlPublicNote($fmdId, $docType, $section=""){
	 	$routUrl = Router::url(['controller' => 'PublicNotes', 'action' => 'index/'.$fmdId.'/'.$docType.'/'.$section]);
		$url = '<a href="'.$routUrl.'" title="Notes" class="link-success fs-15"><i class="ri-file-edit-line" aria-hidden="true"></i></a>';
		return $url;
	}

	public function setOnlyRecordIds($selectedIds, $postData=null)
	{

		if(!empty($selectedIds)){
			$item = [];
			foreach($selectedIds as $selectedId){
				$postkeys = explode('_',$selectedId);
				if(!empty($postkeys[0]) || ($postkeys[0] == 0)){
					$item['fmd'][]= $postData['fmdId'][$postkeys[0]];
					$item['doc'][]= $postData['docTypeId'][$postkeys[0]];
				}
			}
		}
		return $item;
	}

	public function generateCsvLink($countRows, $pagelink){

		$pdfDownloadLinks = '';
		$pagelinkD = '';
		$pages = $countRows / ROWLIMIT;
		
		for($i = 0; $i < floor($pages); $i++){
			$pagelinkD = $pagelink.'&limit='.($i*ROWLIMIT).'-'.ROWLIMIT;
			$pdfDownloadLinks .= '<li class="col-sm-4 col-md-4 col-lg-3 list-group-item"> <a href="'.$pagelinkD.'" title="Download CSV sheet"> <i class="las la-file-download" aria-hidden="true"></i> Records '.($i*ROWLIMIT+1).' to '.(($i+1)*ROWLIMIT).'</a></li>';
		}

		if(($countRows % ROWLIMIT) > 0){
			$pagelinkD = $pagelink.'&limit='.($i*ROWLIMIT).'-'.($countRows % ROWLIMIT);
			$pdfDownloadLinks .= '<li class="col-sm-4 col-md-4 col-lg-3 list-group-item"> <a href="'.$pagelinkD.'" title="Download CSV sheet">  <i class="las la-file-download" aria-hidden="true"></i> Records '.($i*ROWLIMIT+1).' to '.(($i*ROWLIMIT)+($countRows % ROWLIMIT)).'</a></li>';
		}
		
		return $pdfDownloadLinks;
	}

 
	public function additionalFieldsTOSearch($additionalFields, $partnerMapFields){
		
		foreach($additionalFields as $value){
			if(!in_array($value, $partnerMapFields)){
				$partnerMapFields[$value] = $value;
			}
		}
		return $partnerMapFields;
	}

}
 
