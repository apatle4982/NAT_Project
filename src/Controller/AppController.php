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
use Dompdf\Dompdf;
use Dompdf\Options;
use LRS_PDF_ACCURATE;
use	LRS_PDF_COMMON;
use App\Model\Entity\User;
use Cake\Core\Configure;
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
		
		$prefix = $this->getRequest()->getParam('prefix');
        if (empty($prefix) || strtolower($prefix) !== 'api') {
            // Web routes -- enable Authentication plugin
            $this->loadComponent('Authentication.Authentication');
        }
	 	//$this->loadComponent('Authentication.Authentication');
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

		/**
		 * @var mixed
		 */
		$prefix = $this->getRequest()->getParam('prefix');
		if (empty($prefix) || strtolower($prefix) !== 'api') {
			$this->Authentication->addUnauthenticatedActions(['login','forgotPassword','resetPassword']);

			$this->currentUser= $this->Authentication->getIdentity();
			$this->getUserGateway();
			
			if($this->user_Gateway){
				$this->viewBuilder()->setLayout('default_partner'); 
			}

			$result = $this->Authentication->getResult();
			$this->set('LoggedInUsers', $result->getData());

			/**
			 * Start User Access Level Code Added By Abhishek
			 */
			$action = $this->request->getParam('action');
			$currentUser = $this->currentUser;
			
			if ($currentUser) {
				$this->loadModel('UsersGroups');
				$user_id = $this->currentUser['user_id'];
				$user_group_id = $this->UsersGroups->findUserGroup($user_id); 

				// Set a global variable
    			Configure::write('UserGroup.Id', $user_group_id);

				switch ($user_group_id) {
					case User::LEVEL_SUPER_ADMIN:
						// Full access
						break;

					case User::LEVEL_LIMITED:
						if ($action === 'delete') {
							$this->Flash->error(__('You are not allowed to delete records.'));
							return $this->redirect($this->referer());
						}
						break;

					case User::LEVEL_READ_ONLY:
						if (in_array($action, ['add', 'edit', 'delete'])) {
							$this->Flash->error(__('Read-only access.'));
							return $this->redirect($this->referer());
						}
						break;
				}
			}
			/**
			 * End User Access Level Code Added By Abhishek
			 */
		}	
		
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
		//print_r($errorArr);
		//print_r($errorArr['isNotMatch']);exit;
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
			
			if(isset($errorArr['isTransactionTypeMatch']) && $errorArr['isTransactionTypeMatch'] != ""){
				$getText = true;
				$txt .= '<li>Error: Transaction type is invalid only allowed between 1 to 4: <br><p>'.implode(', ',$errorArr['isTransactionTypeMatch']).'</p></li>';
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

			if(!empty($partnerImportFields) && !empty($errorArr['isTransactionTypeMatch'])){
				$getText = true;
				$txt .= "<li>Please check below things in the spreadsheet (CSV) file</li>
							 <ul class='checkin-error-nobullets'>
								 <li>* Use CSV file only</li>
								 <li>* Allowed transaction type between 1 to 4</p> </li>
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
			$action = ['indexPartner','ajaxListIndex','view','ajaxListRejection', 'masterSearchPartner', 'estimatedFeeSheetPartner', 'sampleExport', 'completeOrderPartner', 'viewpdf', 'checkinToSubmission', 'checkinToRecording', 'openRejectedStatus','fileAnalysisReport','aolindexPartner','ajaxListAolindexPartner','generatePdf','masterView','masterSearch','masterData','index'];
			
			if(!in_Array($this->request->getParam('action'), $action )){
				$this->redirect(['controller' => 'Users','action' => 'logout']);
				//$this->Authentication->logout();
				//return $this->redirect(['controller' => 'Users','action' => 'login']);exit; 
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

	public function generatePdfNew($id, $flag = "", $signedAOL=false)
	{
	    $this->autoRender = false;

	    require_once(FPDF_VENDER . "lrs_pdf.php");
	    $pdf = new LRS_PDF_ACCURATE();

	    $this->loadModel('FilesExamReceipt');
	    $this->loadModel("FilesMainData");

	    $fmd_data = $this->FilesMainData->find()->where(['Id' => $id])->first();
	    $data = $this->FilesExamReceipt->find()->where(['RecId' => $id])->first();
	    $vest = array();
	    $mortgage = array();
	    $judgments = array();

	    if($data['vesting_attributes'])
	    $vest = json_decode($data['vesting_attributes']);

	    if($data['open_mortgage_attributes'])
	    $mortgage = json_decode($data['open_mortgage_attributes']);

	    if($data['open_judgments_attributes'])
	    $judgments = json_decode($data['open_judgments_attributes']);

	    // Define colors (Green theme)
	    $headerColor = [34, 139, 34]; // Dark Green

	    // Initialize PDF
	    $pdf->AddPage();
	    $pdf->SetFont('Arial', 'B', 14);

	    // Title
	    $pdf->SetTextColor($headerColor[0], $headerColor[1], $headerColor[2]);
	    $pdf->Cell(0, 10, 'Insured Attorney Opinion Letter', 0, 1, 'C');
	    $pdf->Ln(5);

	    // Reset text color for body
	    $pdf->SetTextColor(0, 0, 0);
	    $pdf->SetFont('Arial', '', 10);

	    // Property Information
	    $this->addSectionHeader($pdf, 'Property Information', $headerColor);
	    $this->addDataTable($pdf, [
	        'NAT File Number' => $fmd_data['NATFileNumber'],
	        'Loan Number' => $fmd_data['LoanNumber'],
	        'Subject Names' => $data['VestedAsGrantee'],
	        'Property Address' => $data['OfficialPropertyAddress'],
	        'Creation Date' => $data['created'],
	        'Effective Date' => $data['OpenJudgmentsDateRecorded']
	    ]);

	    // Vesting Information
	    $pdf->Ln(5);
	    $this->addSectionHeader($pdf, 'Vesting Information', $headerColor);
	    if(count($vest) > 0){
	        $cnt = 1;
	        foreach($vest as $v){
	          //echo "<pre>";print_r($v);echo "</pre>";exit;
	            $this->addDataTable($pdf, [
	                "Deed Type" => $v->VestingDeedType,
	                "Title Vested In" => $v->VestingDeedType,
	                "Grantor" => $v->VestingGrantor,
	                "Dated" => $v->VestingDated,
	                "Recorded" => $v->VestingRecordedDate,
	                "Book & Page" => $v->VestingBookPage,
	                "Comments" => $v->VestingComments
	            ], true);
	            $cnt++;
	            $pdf->Ln(5);
	        }
	    }


	    // Open Mortgages
	    $pdf->Ln(5);
	    $this->addSectionHeader($pdf, 'Open Mortgages', $headerColor);

	    if(count($mortgage) > 0){
	        $cnt = 1;
	        foreach($mortgage as $v){
	            $this->addDataTable($pdf, [
	                "Amount" => $v->OpenMortgageAmount,
	                "Dated" => $v->OpenMortgageDated,
	                "Recorded" => $v->OpenMortgageRecordedDate,
	                "Lender" => $v->OpenMortgageLenderMortgagee,
	                "Borrower" => $v->OpenMortgageBorrowerMortgagor,
	                "Instrument" => $v->OpenMortgageInstrument,
	                "Comments" => $v->OpenMortgageComments
	            ], true);
	            $cnt++;
	            $pdf->Ln(5);
	        }
	    }

	    $pdf->Ln(5);
	    $this->addSectionHeader($pdf, 'Judgments & Other Encumbrances', $headerColor);
	    if(count($judgments) > 0){
	        $cnt = 1;
	        foreach($judgments as $v){
	            //echo "<pre>";print_r($v);echo "</pre>";exit;
	            $this->addDataTable($pdf, [
	                "Litigation" => $v->OpenJudgmentsLienHolderPlaintiff,
	                "Comments" => $v->OpenJudgmentsComments
	            ], true);
	            $cnt++;
	            $pdf->Ln(5);
	        }
	    }

	    // Tax Status
	    $pdf->Ln(5);
	    $this->addSectionHeader($pdf, 'Tax Status', $headerColor);
	    $this->addDataTable($pdf, [
	        'Parcel #' => $data['apn_parcel_number'],
	        'Tax Year' => $data['TaxYear'],
	        'Delinquent No' => $data['TaxDeliquentDate'],
	        'Tax Value' => $data['TaxAmount'],
	        'Exemption' => $data['exemption'],
	        'Annual Tax' => $data['annual_tax'],
	        'Comments' => $data['TaxComments']
	    ], true);

	    // Legal Description
	    $pdf->Ln(5);
	    $this->addSectionHeader($pdf, 'Legal Description & Comments', $headerColor);
	    $this->addDataTable($pdf, [
	        'Legal Description' => $data['LegalDescription'],
	        'Additional Comments' => 'None'
	    ], true);

	    /*$pdf->AddPage();
	    $pdf->SetFont('Arial', 'B', 14);
	    $pdf->SetTextColor($headerColor[0], $headerColor[1], $headerColor[2]);
	    $pdf->Cell(0, 10, 'AOL Insurance & Wrap Language', 0, 1, 'C');
	    $pdf->Ln(5);*/

	    // Final Output
	    //$pdf->Output('D', "AssignmentDetails-$id.pdf");
		// Define the file path in webroot directory

	    $pdf_folder = "pre";
	    if($flag=="final") {

	    	$pdf_folder = "final";

	    } else if($flag=="signature") {

	    	$pdf_folder = "aol_signed";

	    } else {

	    	$pdf_folder = "pre";
	    }

		$filePath = WWW_ROOT . 'files' . DS . 'export' . DS . 'aol_assignment' . DS . 'pdf' . DS  . $pdf_folder . DS . "AssignmentDetails-$id.pdf";
		// Ensure the directory exists
		if (!is_dir(dirname($filePath))) {
			mkdir(dirname($filePath), 0777, true);
		}

	    $this->static_page1($pdf, $id);
	    if($signedAOL == true) {
	    	$this->aolSignaturedRow($pdf, $id);
	    }
	    $this->static_page2($pdf, $id);
		// Save the PDF to the server
		$pdf->Output('F', $filePath);
	    if($flag==""){
		    $pdf->Output('D', "AssignmentDetails-$id.pdf");
	    }
	}

	private function addSectionHeader(&$pdf, $title, $headerColor)
	{
	    $pdf->SetFont('Arial', 'B', 12);
	    $pdf->SetFillColor($headerColor[0], $headerColor[1], $headerColor[2]);
	    $pdf->SetTextColor(255, 255, 255);
	    $pdf->Cell(0, 8, $title, 1, 1, 'L', true);
	    //$pdf->Ln(2);
	    $pdf->SetTextColor(0, 0, 0);
	}

	private function addDataTable(&$pdf, $data, $wrapText = false)
	{
	    $pdf->SetFont('Arial', '', 10);
	    foreach ($data as $key => $value) {
	        if (empty($value)) {
	            $value = 'N/A';
	        }

	        // Calculate height dynamically
	        $colWidth = 140;
	        $lineHeight = 6;
	        $maxWidth = $pdf->GetStringWidth($value);
	        $numLines = ceil($maxWidth / $colWidth);
	        $cellHeight = max(6, $numLines * $lineHeight);

	        // Align the label and content to have the same height
	        $pdf->Cell(50, $cellHeight, "$key:", 1, 0, 'L');
	        $pdf->MultiCell($colWidth, $lineHeight, $value, 1, 'L');

	        // Add spacing after each row
	        //$pdf->Ln(2);
	    }
	}

    public function aolSignaturedRow(&$pdf, $id) {

        $this->autoRender = false;
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 10, 'Attorney Signature', 0, 1, 'C');
        $pdf->Ln(5);

        // Table Header
        $pdf->SetFont('Arial', 'B', 10);

        $signaturePath = WWW_ROOT.'files'.DS.'signature'.DS.'aol'.DS.'signature_'.$id.'.png';
        // Table Data
        $this->addRow($pdf, "Item 1", "Attorney Name & Address", "");
        $this->addRowSignature($pdf, "Item 2", "Attorney Digital Sign", $signaturePath);
    }

    public function static_page1(&$pdf, $id){
        $this->autoRender = false;
        // Generate PDF content
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 10, 'Policy Details', 0, 1, 'C');
        $pdf->Ln(5);

        // Table Header
        $pdf->SetFont('Arial', 'B', 10);
        /*$pdf->Cell(30, 6, 'Item', 1);
        $pdf->Cell(60, 6, 'Title', 1);
        $pdf->Cell(0, 6, 'Content', 1, 1);*/

        // Table Data
        $this->addRow($pdf, "Item 1", "Insured Name & Address", "");
        $this->addRow($pdf, "Item 2", "Policy Period", "From 05/01/20xx to 05/01/20xx (12:01 a.m. Standard Time)");
        $this->addRow($pdf, "Item 3", "Limit of Liability", "As set forth in Section II Limits of Liability");
        $this->addRow($pdf, "Item 4", "Coverage Parts", "Applicable to this Policy. See Item 7");
        $this->addRow($pdf, "Item 5", "Premium", "Additional premium due shall be applicable to each Coverage Part Report for which coverage is provided under the terms of Section I Insuring Agreement.");
        $this->addRow($pdf, "Item 6", "Taxes and Fees", "Surplus Lines Premium Tax: 4.85%; or $0.0485 per $1.00 of premium\nStamping Fee: 0.075%; or $0.00075 per $1.00 of premium");
        $this->addRow($pdf, "Item 7", "Forms and Endorsements", "IFC EO P 0001 0520 Blanket Policy; IFC EO P 0002 0524 Service of Process; IFC EO P 0003 0524 Arbitration Provision; IFC EO P 0004 0524 Certified Acts of Terrorism Coverage and Cap on Certified Acts Losses; IFC EO P 0011 1223 Refinance Attorney Title Opinion Service Agreement Form; IFC EO E 0015 0524 General Change Endorsement; IFC EO E 0016 0524 Addition of Service Agreement with A Lender or Client Endorsement; IFC EO E 0017 0524 Service Agreement Manuscript Endorsement; IFC EO P 0018 0524 Privacy Notice.");
    }

    public function static_page2(&$pdf, $id){
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'SERVICE AGREEMENT LIABILITY POLICY', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'BLANKET POLICY', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 10, 'Table of Contents', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);

        $contents = [
            'Section I - Insuring Agreement' => 1,
            'Section II - Limit of Liability' => 2,
            'Section III - Definitions' => 2,
            'Section IV - Exclusions' => 2,
            'Section V - General Conditions' => 3,
            'Notice of Loss and Cooperation' => 3,
            'Action Against Insurer' => 3,
            'Cancellation and Nonrenewal' => 3,
            'Subrogation' => 3,
            'Other Insurance' => 4,
            'Authorization and Sole Agent' => 4,
            'Heading and Titles' => 4,
            'Assignment of Interest' => 4,
            'Changes' => 4,
            'Territory' => 4
        ];

        foreach ($contents as $title => $page) {
            $pdf->Cell(130, 6, $title, 0, 0);
            $pdf->Cell(10, 6, $page, 0, 1, 'R');
        }
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'INSURING AGREEMENT', 0, 1);
        $pdf->SetFont('Arial', '', 10);

        $text = "Subject to the Limit of Liability stated in Item 3 of the Declarations Page, and the conditions set forth in items A through C below, the insurer agrees to pay on behalf of the insured those sums the insured becomes legally liable to pay to a client for a loss arising out of the insured's breach of an obligation assumed by the insured under the terms of a service agreement. The service agreements eligible for coverage under this policy shall be in the form or as shown in the applicable Coverage Part(s) in Item 4 of the Declarations Page. All applicable endorsements are attached hereto and incorporated as part of this policy.";
        $pdf->MultiCell(0, 6, $text);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, 'A.', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $textA = "The service agreement(s) must be in effect during the policy period or used in the underwriting of a loan which closes on a date within the policy period while also meeting all terms and conditions of the service agreement(s).";
        $pdf->MultiCell(0, 6, $textA);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, 'B.', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $textB = "None of the terms and conditions of the service agreement(s) may be more favorable to the client than those set forth in the applicable Coverage Part(s). If any such terms are more favorable, coverage shall not be invalidated, but the insurer shall only be liable for providing coverage consistent with the applicable Coverage Part(s).";
        $pdf->MultiCell(0, 6, $textB);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, 'C.', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $textC = "Coverage applies to reports that: 1. Bear a date within the policy period; or 2. Are used in the underwriting of a loan that closes within the policy period and meet all service agreement conditions. The report must be submitted within forty-five (45) calendar days after the month-end of the loan funding.";
        $pdf->MultiCell(0, 6, $textC);
    }

    public function addRow($pdf, $item, $title, $content){
        $cellWidthItem = 13;
        $cellWidthTitle = 47;
        $cellWidthContent = 130; // Remaining width
        $lineHeight = 6;

        // Calculate number of lines required for content
        $maxLines = max(
            $pdf->NbLines($cellWidthItem, $item),
            $pdf->NbLines($cellWidthTitle, $title),
            $pdf->NbLines($cellWidthContent, $content)
        );

        $rowHeight = $lineHeight * $maxLines; // Make all columns have the same height

        // Draw cells with consistent height
        $pdf->Cell($cellWidthItem, $rowHeight, $item, 1, 0);
        $pdf->Cell($cellWidthTitle, $rowHeight, $title, 1, 0);
        $pdf->MultiCell($cellWidthContent, $lineHeight, $content, 1);
    }
    public function addRowSignature($pdf, $column1, $column2, $column3)
	{
	    $pdf->Cell(13, 50, $column1, 1);
	    $pdf->Cell(47, 50, $column2, 1);

	    if (file_exists($column3) && is_file($column3)) {
	        // Add image inside the row (adjust width, height, and position as needed)
	        $x = $pdf->GetX(); // Current X position
	        $y = $pdf->GetY(); // Current Y position
	        $pdf->Cell(130, 50, '', 1); // Empty cell for border
	        $pdf->Image($column3, $x + 10, $y + 2, 120, 40); // Adjust position & size
	    } else {
	        $pdf->Cell(60, 10, $column3, 1);
	    }

	    $pdf->Ln();
	}
	public function beforeRender(\Cake\Event\EventInterface $event)
	{
		parent::beforeRender($event);

		$authUser = null;
		if ($this->components()->has('Authentication')) {
			$identity = $this->Authentication->getIdentity();
			$authUser = $identity ? $identity->getOriginalData() : null;
		}

		$this->set('authUser', $authUser); // now it's the User entity
	}
}
