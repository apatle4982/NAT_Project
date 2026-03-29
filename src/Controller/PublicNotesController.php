<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
// use Cake\Mailer\MailerAwareTrait;	
/**
 * PublicNotes Controller
 *
 * @property \App\Model\Table\PublicNotesTable $PublicNotes
 *
 * @method \App\Model\Entity\PublicNote[] paginate($object = null, array $settings = [])
 */
class PublicNotesController extends AppController
{
//	use MailerAwareTrait;
	// step for datatable config : 1
	public $columns_alise = [
								'Date'=> 'PublicNotes.AddingDate',
								'Time'=> 'PublicNotes.AddingTime',
								'Type'=> 'PublicNotes.Type',
								'Regarding' => 'PublicNotes.Regarding',
								'SectionModule' => 'PublicNotes.Section',
							
								'RecordManager' => 'PublicNotes.UserId'
							 ];
//	'RejectionMail' => 'PublicNotes.subject',
	public  $columnsorder = [0=>'PublicNotes.AddingDate', 1=>'PublicNotes.AddingTime', 2=>'PublicNotes.Type', 3=>'PublicNotes.Regarding',4=>'PublicNotes.Section',6=>'PublicNotes.UserId'];
//5=>'PublicNotes.subject',
	public function initialize(): void
    {
		parent::initialize();
		$this->loadModel('FilesCheckinData');
		$this->loadModel('FilesMainData');
		$this->loadModel('CountyMst');
		$this->loadModel('CompanyFieldsMap');
		$this->loadModel('FilesQcData');
		$this->loadModel('FilesAccountingData');
		$this->loadModel('FilesRecordingData');
		$this->loadModel('FilesReturned2partner');
		$this->loadModel('FilesShiptocountyData');
		$this->loadModel('RejectionStatusHistory');
		
		$this->loadComponent('GeneratePDF');
	}
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($allSection=false)
    {

		$pageTitle = 'Notes';
		$this->set(compact('pageTitle'));
		$publicNotes = $this->PublicNotes->newEmptyEntity();
		//getQuery
		$recordMainId = $this->request->getParam('fmd');
	    $doctype = $this->request->getParam('doctype');
		$section = $this->request->getParam('section');

		if(!isset($recordMainId) || !isset($doctype)){
			$this->Flash->error(__('Record could not be found. Please, try again.'));
			return $this->redirect($this->referer());exit;
		}
		  
		$formpostdata = ['recordMainId'=>'','doctype'=>''];
		
		$filesMainData = $this->FilesMainData->fileMainDataPublic($recordMainId, $doctype);
  
		// only use for email section use
		$layoutShowQuery = $this->request->getQuery('layoutShow');
		$layoutShow = (isset($layoutShowQuery) ? false: true);
		$this->set('layoutShow', $layoutShow);
		
		if(!empty($filesMainData)){	
			//----------------- for view complete page -------------------------
			if($allSection){

				/***********CountyMst***************/
				if(!empty($filesMainData['State']) && !empty($filesMainData['County'])) {
					
					//$CountyDetails = $this->CountyMst->getCountyDetails($filesMainData['State'], $filesMainData['County']);
					//$this->set('CountyDetails', $CountyDetails);
				}
				
				/***********FilesCheckinData***************/
				
				if ($this->request->is(['patch', 'post', 'put'])) 
				{
					// file main data id set as hidden
					$documentSave = $this->request->getData('documentSave');
					if(isset($documentSave)){
						$documentReceived = $this->request->getData('DocumentReceived');
						$checkinId = $this->request->getData('checkinId');
						$this->FilesCheckinData->updateDocumentStatus($checkinId, $documentReceived);	
					}

					// generate Coveresheet PDF call from Component
					$coversheetsSave = $this->request->getData('coversheetsSave');
					if(isset($coversheetsSave)){
						// send array of fmdId_docId (GeneratePDF component)
						$pdfname = $this->GeneratePDF->generateCoversheetPDF([$recordMainId.'_'.$doctype]); //
					}

					$recordSendEmail = $this->request->getData('recordSendEmail');
					if(isset($recordSendEmail)){
						// send email to client
						$this->recordSendEmail([$recordMainId,$doctype]); //
						$this->Flash->success(__('Recording status email sent.'));
					}
				}

				$fileCKData = $this->FilesCheckinData->getCheckInData($recordMainId, $doctype);
				$this->set('fileCKData', $fileCKData);

				/***********FilesQcData***************/
				$fileQcData = $this->FilesQcData->getQCData($recordMainId, $doctype);
				$this->set('fileQcData', $fileQcData);

				/***********FilesAccountingData***************/
				$fileACData = $this->FilesAccountingData->getfilesACData($recordMainId, $doctype);
				//pr($fileACData); exit;
				$this->set('fileACData', $fileACData);

				/***********FilesRecordingData***************/
				$filesRCData = $this->FilesRecordingData->getRecordingData($recordMainId, $doctype);
				$this->set('filesRCData', $filesRCData);
				
				/***********FilesShiptocountyData***************/
				//$filesS2CData = $this->FilesShiptocountyData->getS2CData($recordMainId, $doctype);
				//$this->set('filesS2CData', $filesS2CData);

				/***********FilesReturned2partner***************/
				$filesR2PData = $this->FilesReturned2partner->getR2PData($recordMainId, $doctype);
				$this->set('filesR2PData', $filesR2PData);

				/***********RejectionStatusHistory***************/
				$rejectionSHData = $this->RejectionStatusHistory->rejectionHistoryData($recordMainId, $doctype);
				$this->set('rejectionSHData', $rejectionSHData);
			}
			//----------------- END for view complete page -------------------------

			$companyMstId = $filesMainData['company_id']; 

			$partnerMapFields = $this->CompanyFieldsMap->partnerMapFields($companyMstId);

			// step for datatable config : 3
			$this->set('dataJson',$this->CustomPagination->setDataJson($this->columns_alise));

			// step for datatable config : 4
			$formpostdata['recordMainId'] = $recordMainId;
			$formpostdata['doctype'] = $doctype;

		}else{			
			$this->Flash->error(__('Record could not be found. Please, try again.'));
			return $this->referer(); exit;
		}

		$this->set('formpostdata', $formpostdata);
		//end step
		//$this->set('isSearch', $this->DocumentTypeMst->isSearch());

		$this->set('recordMainId', $recordMainId);
		$this->set('doctype', $doctype);
		$this->set('section', $section);

        $this->set(compact('publicNotes','partnerMapFields','filesMainData'));
        $this->set('_serialize', ['publicNotes']);
    }

	// step for datatable config : 5 main step
	public function ajaxListIndex()
    {
		$modelname = $this->name;
        $this->autoRender = false;

        $columns = array(0=>$modelname.'.AddingDate',1=>$modelname.'.AddingTime',2=>$modelname.'.Type', 3 => $modelname.'.Regarding', 4 =>$modelname.'.Section', 5 => $modelname.'.subject', 6 => $modelname.'.UserId'); 
		
		// deside table type to fetch data
		$tabletype =  $this->request->getQuery('tabletype');

		//remove/pop extra fields UserFirstname, UserLastname
		//array_pop($this->columns_alise);
		//array_pop($this->columns_alise);
		//pr($this->request->getData());
		$formdata = $this->request->getData('formdata');
		$recordMainId = $formdata['recordMainId'];
		$doctype =  $formdata['doctype'];
		unset($formdata['recordMainId']);
		unset($formdata['doctype']);

		$this->CustomPagination->setPaginationData(['request'=>$this->request->getData(),
													 'columns'=>$columns, 
													 'columnAlise'=>$this->columns_alise,
													 'modelName'=>$modelname
													]);
	 /*  $pdata = $this->postDataCondition($this->request->getData(), true);
  
	    $pdata['condition']['conditions']['AND'] = [$modelname.'.RecId'=>$recordMainId, $modelname.'.TransactionType'=>$doctype]; //, $modelname.'.Public_Internal'=>$tabletype

		 $pdata['condition']['fields']['userfirstname'] = 'Users.user_name';
 
	 	$pdata['condition']['fields']['userlastname']  = 'Users.user_lastname';   
	
 	$query = $this->$modelname->find('search', $pdata['condition'])->contain(['Users']);	
	 
	$recordsTotal = $this->FilesMainData->getQueryCountResult($query, 'count');

	$data = $this->FilesMainData->getQueryCountResult($query);
 */

$pdata = $this->CustomPagination->getQueryData();
 
$order = $pdata['condition']['order'];
$data = $this->$modelname->publicNotesDataUnion($recordMainId, $doctype, 'R'); 
	//  pr($data);exit;
		$recordsTotal = count($data);
		// customise as per condition for differant datatable use.
		$data = $this->getCustomParshingData($data);
	 	$data = $this->sortMultiArray($data, $order);
		// pr($data);
        $response = array(
            "draw" => intval($pdata['draw']),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsTotal),
            "data" => $data
        );
		
        echo json_encode($response); 
        exit;
    }

	 private function sortMultiArray(array $my_array = null, $order) //, $sortFld='AddingDate'
	 {
		$key = array_key_first($order);
		$sortFld = explode('.',$key); 
		$names = array(); 

		/* if(array_key_first($order) == 'PublicNotes.AddingDate' || array_key_first($order) == 'PublicNotes.AddingTime'){
			//add date time on AddingTime for sorting
			foreach ($my_array as $key=>$my_object) { 
				$my_array[$key]->AddingDateTime = $my_object->AddingDate->format('Y-m-d').' '.$my_object->AddingTime; //any object field
			}
			$sortFldName  = 'AddingDateTime';
		}else{ }  */
		$sortFldName = $sortFld[1];
		// sort on AddingTime
		foreach ($my_array as $my_object) { 
			if($sortFldName == 'AddingDateTime')	$names[] = strtotime($my_object->$sortFldName); //any object field
			else $names[] = $my_object->$sortFldName;
		}
 
		//SORT_STRING SORT_NUMERIC
		if(isset($order[$key]) && ($order[$key] == 'desc'))
			array_multisort($names, SORT_DESC, $my_array); 
		else array_multisort($names, SORT_ASC, $my_array); 

 
 
		return $my_array;
	 }
	
	private function postDataCondition(array $postData, $fields=false){ 
		 
        $this->CustomPagination->setPaginationData(['request'=>$postData,
                                                     'columns'=>$this->columnsorder, 
                                                     'columnAlise'=>$this->columns_alise,
                                                     'modelName'=>$this->name
                                                    ]);

		$pdata = $this->CustomPagination->getQueryData();
 
		if($fields){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']);
			//$pdata['condition']['limit'] = MAXLIMIT;
		}

		return $pdata;

	}
	// step for datatable config : 6 custome data action
	private function getCustomParshingData(array $data)
	{
		 
		// manual user
        foreach ($data as $key => $value) {
			 
			$value['Date'] = date('Y-m-d', strtotime($value['AddingDate']));
			$value['Time'] = date('H:i:s', strtotime($value['AddingTime']));
			$value['SectionModule'] = $this->getSection($value['Section']);
			$value['RejectionMail'] = (!empty($value['subject'])) ? $value['subject'] : 'popup'; 
			$value['RecordManager'] = '';//$value['user']['user_name'].' '.$value['user_lastname'];
		}
		return $data;
	}
	
	private function getSection($section){
		 //echo ' ---- '. $section; exit; 
		if (str_contains($section, 'QC')) {
			$section = 'QC';
		}
		switch($section){
			case 'ARD':
				$sectionName= "Check In";
			break;
			case 'RD':
				$sectionName= "Recording";
			break;
			case 'QC':
				$sectionName= "QC";	
			break;
			case 'AC':
				$sectionName= "Accounting";
			break;
			case 'SH':
				$sectionName= "Shipping";	
			break;
			case 'RF2P':
				$sectionName= "Return File to Partner";	
			break;
			case 'COMP':
				$sectionName= "Complete Order";	
			break;
			default:
			$sectionName= $section;
			break;
		}
		return $sectionName;	
	}
	
	public function viewComplete()
    {
		// only use for email section use
		$layoutShowQuery = $this->request->getQuery('layoutShow');
		 
		$layoutShow = (isset($layoutShowQuery) ? false: true);
		$this->set('layoutShow', $layoutShow);
		$this->index(true);
		$this->set('pageTitle', 'Complete Details'); 
    }
	
	// send email to company partner user for recording status
	// set -->layoutShow<-- value in viewcomplete--index page and view pages for page layout
	private function recordSendEmail($recordData){
		$recordMainId = $recordData[0];
		$doctype = $recordData[1];

		 $email['body'] = $this->requestAction(['controller'=>'PublicNotes','action' => 'viewComplete', '?'=>['fmd'=>$recordMainId,'doctype'=>$doctype,'layoutShow'=>'email']]);
		
		$email['user_name'] = $this->currentUser['user_email'].' '.$this->currentUser['user_lastname'];
		$email['user_email'] = $this->currentUser['user_email'];
		
		$email['email_subject'] = 'Complete Record Status!';
		$email['email_template'] = 'recordingStatus';
		$email['emil_layout'] = 'send_email';
		//$this->getMailer('SendEmail')->send('SendEmail', [$email]);  
		return true;
	}
}