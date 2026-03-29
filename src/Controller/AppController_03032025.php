<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use \DateTime;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
		
	 	$this->loadComponent('Authentication.Authentication');
		$this->loadComponent('CustomPagination');
        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
		$this->setSystemStatus();
    }

	public $currentUser;
	public $archivePrifix = "";
	public $user_Gateway;
	public function beforeFilter(\Cake\Event\EventInterface $event)
	{
		parent::beforeFilter($event);
		$this->Authentication->addUnauthenticatedActions(['login','forgotPassword','resetPassword']);

		$this->currentUser= $this->Authentication->getIdentity();
		$this->getUserGateway();
		
		if($this->user_Gateway){
			$this->viewBuilder()->setLayout('default_partner'); 
		}

		$result = $this->Authentication->getResult();
		$this->set('LoggedInUsers', $result->getData());
		
	} 
 
	private function setSystemStatus(){
		$session = $this->request->getSession();
		if(!$session->check('system_status')){
			$this->request->getSession()->write([
				'system_status' => ''
			]);
		}
 
		if(!empty($this->request->getData()) && $session->check('system_status')){
			// set session 
			$this->writeSession($session);
		}elseif(empty($this->request->getData()) && $session->check('system_status')){
			// set session
			$this->writeSession($session);
		}

	    if($session->check('system_status') && $session->readOrFail('system_status') == "Archive"){
            $this->archivePrifix = "_archieve";
        }else{
			$this->archivePrifix = "";
		}
		
		define("ARCHIVE_PREFIX", $this->archivePrifix);
	}
	
	private function writeSession($session){
		if(null !== $this->request->getData('archive')){   
			if($this->request->getData('archive') == "Archive"){
				$session->write([ 'system_status' => 'Archive' ]);
			}  else{
				$session->write([ 'system_status' => 'Current' ]);
			}  
		}elseif(null !== $this->request->getData('formdata')){ 
			$formdata = $this->request->getData('formdata');
		 	if(isset($formdata['archive']) && ($formdata['archive'] == "Archive")){
				$session->write([ 'system_status' => 'Archive' ]);
			} /*  else{
				$session->write([ 'system_status' => 'Current' ]);
			}   */
		} 
	}
	 
	public function getUserGateway(){
		$currentUser = $this->Authentication->getIdentity();
		$this->user_Gateway = false;
		$user_group_id = 0;
		if(!empty($currentUser)){ 
			if($currentUser->user_companyid == 0){ //admin
				$this->user_Gateway = false;
			}else{
				// not admin
				$this->user_Gateway = true;
			}  
			
			
			$this->loadModel('UsersGroups');
			$user_id = $this->currentUser['user_id'];
			$user_group_id = $this->UsersGroups->findUserGroup($user_id); 
			
		}
		$this->set('user_Gateway', $this->user_Gateway);	
		$this->set('user_group_id', $user_group_id);
	}

	public function flashSuccessMsg($successArr)
	{
		$successMSG = '';
		if(isset($successArr['successMsg']) && !empty($successArr['successMsg'])) 
			$successMSG = $successArr['successMsg'].' <br />';
				
		if(isset($successArr['addedcompid']) && !empty($successArr['addedcompid'])) 
			$this->Flash->success(__($successMSG.$successArr['addedcompid']), ['escape'=>false]);
		
		if(isset($successArr['updatecompid']) && !empty($successArr['updatecompid'])) 
			$this->Flash->success(__($successMSG.$successArr['updatecompid']), ['escape'=>false]);

		if(isset($successArr['compErrRows']) && !empty($successArr['compErrRows'])) 
			$this->Flash->error(__($successArr['compErrRows']), ['escape'=>false]);
		
		if(isset($successArr['errrows']) && !empty($successArr['errrows'])) 
			$this->Flash->error(__($successArr['errrows']), ['escape'=>false]);
	}
	
    
	public function flashErrorMsg(array $errorArr, $partnerImportFields=[])
	{  
		$getText = false;
		$txt = '<ul>';
		$txt .= "<li>Error: The spreadsheet (CSV) is not well formatted!!</li>";
 
			if(isset($errorArr['isEmpty']) && ($errorArr['isEmpty'])){
				$getText = true;
				$txt .= '<li>Error: Some columns have empty titles.</li>';
			}
			if(isset($errorArr['isNotMatch']) && $errorArr['isNotMatch'] != ""){
				$getText = true;
				$txt .= '<li>Error: The column titles not allowed are: <br><p>'.implode(', ',$errorArr['isNotMatch']).'</p></li>';
			}
			if(isset($errorArr['isDuplicate']) &&  $errorArr['isDuplicate'] != ""){
				$getText = true;
				$txt .= "<li>Error: The spreadsheet (CSV) contains duplicate columns: ".implode(', ',$errorArr['isDuplicate'])."</li>";
			}
			if(!empty($partnerImportFields) && !empty($errorArr['isNotMatch'])){
				$getText = true;
				$txt .= "<li>Please check below things in the spreadsheet (CSV) file</li>
							 <ul class='checkin-error-nobullets'>
								 <li>* Use CSV file only</li>
								 <li>* Allowed column titles are: <br> <p style='color:blue;'>".implode(', ',$partnerImportFields)."</p> </li>
								 <li>* Remove spaces between column titles</li>
								 <li>* Check spelling of column titles</li>
								 <li>* Remove empty columns</li>
							 </ul>";
						 $txt .= "</ul>";	

					$errorArr['errorArr'][] = $txt;
			}
		
		if(isset($errorArr['errorArr'][0])) {
			$errorArr['errorArr'][0] = (!$getText) ? '<ul><li>'.$errorArr['errorArr'][0].'</li></ul>':$errorArr['errorArr'][0] ;
			$this->Flash->error(__($errorArr['errorArr'][0]),['escape'=>false, 'params' =>['class'=>'error myerrorClass']]);
		}
		
	}	

	// modified for link and direct function call 
	// accept function argument or $_get
	public function sampleExport($filename='',$folder=''){
		$this->autoRender = false;
		if(isset($_GET['filename']) || !empty($filename)){
		    $filename = !empty($_GET['filename']) ? $_GET['filename'] : $filename;
			
			if(isset($_GET['folder']) || !empty($folder))
				$folder = !empty($_GET['folder']) ? $_GET['folder'] : $folder;
 
			$file_path = WWW_ROOT.'files'.DS.$folder.DS.$filename;
			
			if(file_exists($file_path)){ 
				/* $mime = 'text/plain'; //mime_content_type($file_path); exit;
				$this->response = $this->response->withHeader('Content-Type', $mime)->withFile($file_path, ['download' => true, 'name' =>$filename]);
				return $this->response; */

				$this->response = $this->response->withDownload($file_path)->withFile($file_path, array(
					'download' => true,
					'name' => $filename
				));  
 
				// Set Force Download 
				return $this->response ; 
			}
		}else{
			return $this->referer();
		}

	}
	 

	/**
	* setCompanyId callback.
	*
	* @param array $request
	* @return int company id 
	* return company id for current logged in user
	* company Id come from form post data for admin 
	* or logged in users company for Partner.
	*/
	
	public function setCompanyId(array $requestData){
		$company_mst_id = "";
		
		if(isset($this->user_Gateway) && ($this->user_Gateway)){
			$company_mst_id = $this->currentUser->user_companyid;  // patrner section 
		}elseif(isset($requestData['company_id']) && !empty($requestData['company_id'])){
			$company_mst_id = $requestData['company_id'];
		}
		return $company_mst_id;
	}

	/**
	* addCompanyToQuery callback.
	* // partner user section 
	* @param array $condition query array
	* @return array $condition query array
	* return whereCondition for query
	*/
	
	public function addCompanyToQuery(array $whereCondition){
	 
		if(isset($this->user_Gateway) && ($this->user_Gateway)){
		 //not admin
			$whereCondition = array_merge($whereCondition, ['fmd.company_id'=>$this->currentUser->user_companyid]);
		}
		
		return $whereCondition;
	}

	// count arrar fucntion (object gives error)
	public function countable($arrData){
		return ((is_array($arrData) || $arrData instanceof Countable) ? count($arrData) : 0);
	}

 	 /**
     * loginAccess
     *
     * @param $access The access call check.
     * @return redirect to page.
	 * check for access of pages with logged in and without login. add to every action.
     */ 
	public function loginAccess(){
		//user  
		
		if($this->user_Gateway){  //user  
			$action = ['indexPartner','ajaxListIndex','view','ajaxListRejection', 'masterSearchPartner', 'estimatedFeeSheetPartner', 'sampleExport', 'completeOrderPartner', 'viewpdf', 'checkinToSubmission', 'checkinToRecording', 'openRejectedStatus','fileAnalysisReport'];
			
			if(!in_Array($this->request->getParam('action'), $action )){
				$this->Authentication->logout();
				return $this->redirect(['controller' => 'Users','action' => 'login']);exit; 
			}
			// elseif((!in_Array($this->request->getParam('controller'), ['publicNotes']))){
				// echo $this->request->getParam('controller') ; exit;
				// $this->Authentication->logout();
				// return $this->redirect(['controller' => 'Users','action' => 'login']);exit; 
			// }
		}
	}

	 /**
     * groupUserAccess
     *
     * @param $access The access call check as per user group Authorization.
     * @return redirect to page.
	 * check for access of pages with logged in group member.
     */ 
	public function groupUserAccess($pagename='Export Sheet Setting'){
		$this->loadModel('UsersGroups');
		$user_id = $this->currentUser['user_id'];
		$group_id = $this->UsersGroups->findUserGroup($user_id);  
		// only admin can access this page.
		if($group_id != ADMIN_GROUP){  // ADMIN_GROUP == 1
			$this->Flash->error(__('Permission Denied to access '.$pagename.'.'));
			return $this->redirect(['controller' => 'Users', 'action' => 'dashboard']);
		}
	}

	// New Download CSV without saving on export folder - added on 05052023
	public function downloadCsv($listRecord, $headerParams, $csvNamePrifix) {
		// Set the response content type to CSV
		$this->response = $this->response->withType('csv'); 
		
		// Set the CSV file name
		$filename = $csvNamePrifix.'.csv';
	
		// Set the CSV data and file name in the response body
		$this->response = $this->response->withDownload($filename); 
		$this->response = $this->response->withStringBody($this->arrayToCsv($headerParams, $listRecord));
	
		// Return the response object
		return $this->response;
	}
 
	private function arrayToCsv($header,$data) {
		$output = ''; 
		$output .= implode(',', $header) . "\n"; 

		foreach ($data as $row) {
			//$output .= implode(',', $row) . "\n";
			for($cnt=0; $cnt<count($row);$cnt++) {
				$output .= "\"".$row[$cnt]."\"".",";
			}
			$output .=  "\n";
		}
		$output = rtrim($output, ',');
		return $output;
	}
	// New Download CSV without saving on export folder - added on 05052023
	
	public function validateDate($date, $format = 'Y-m-d'){
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) === $date;
	}
}
