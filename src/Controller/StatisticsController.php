<?php
//declare(strict_types=1);
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\I18n\FrozenTime;
/**
 * Statistics Controller
 *
 * @property \App\Model\Table\StatisticsTable $Statistics
 *
 * @method \App\Model\Entity\Statistics[] paginate($object = null, array $settings = [])
 */
 
class StatisticsController extends AppController
{

	private $columns_alise = [   
                                "FileNo" => "fmd.NATFileNumber",
                                "PartnerFileNumber" => "fmd.PartnerFileNumber",
								"State" => "fmd.State",
                                "County" => "fmd.County",   
                            ];

	private $columnsorder = []; 
	
	private $pageType = '';
	public $skipJoin = []; 
	public $prifix;
	public function initialize(): void
	{
	   parent::initialize();
	   $this->loadModel('FilesMainData');
	   $this->loadModel('DocumentTypeMst');
	   $this->loadModel('CompanyFieldsMap');
	   $this->loadModel('CompanyMst');
	   $this->loadModel('CountyMst');
	   $this->loadModel('States');
	}
	
	public function beforeFilter(\Cake\Event\EventInterface $event)
    {
		parent::beforeFilter($event);
		$this->loginAccess();
	}
	
	public function openRejectedStatus(){
		$this->prifix = 'fqcd';
			$this->set('pageTitle', 'Pending Files to Open Rejected Status');
		$this->checkinToSubmission('chkRejected');
	} 
	 
	public function checkinToRecording(){ 
		$this->prifix = 'frd';
		$this->set('pageTitle', 'Pending Files To Recording');
		$this->checkinToSubmission('chkRecording');
		
	} 
	
	public function checkinToSubmission($pageType='chkSubmission'){
		if($pageType=='chkSubmission'){
			$this->prifix = 'fsad';
			$this->set('pageTitle', 'Pending Files To Submission');
	 	} 
		// set company Id in app controller 
		$requestData = $this->request->getData();
		
		$datatblHerader = [   
			"No Of Days" => "",
			"No Of Records" => "",
			"Actions" => "" 
		];

		// End add Account details
		$this->set('dataJson', $this->CustomPagination->setDataJson($datatblHerader));
 
		//end step
		$formpostdata = '';
		if ($this->request->is(['patch', 'post', 'put'])) {
			$formpostdata = $this->request->getData(); 
		} 

		$company_mst_id = $this->setCompanyId($requestData);
		$DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();		

		$partnerMapField =  $this->CompanyFieldsMap->partnerMapFields($company_mst_id,1); 
		$companyMsts = $this->CompanyMst->companyListArray()->toArray(); 
 
		$CountyData = $this->CountyMst->getCountyTitleByState(); 
		$StateData = $this->States->StateListArray();

		$Statistics = null;//$this->MasterData;
		$this->pendingFileAnalysis($pageType);
		$this->set(compact('Statistics','formpostdata','companyMsts','DocumentTypeData','partnerMapField','CountyData', 'StateData'));
		  
		$this->set('datatblHerader', $datatblHerader);
		$this->set('_serialize', ['Statistics']); 
		$this->render('checkin_to_submission');
	}
	 

   /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function pendingFileAnalysis($pageType)
    {  
	 	$this->setPageType($pageType);
		$whereCondition =$this->setWhereCondition();
		
		//set condtion for partner view 
		if(isset($this->user_Gateway) && ($this->user_Gateway)){
			$whereCondition = $this->addCompanyToQuery($whereCondition);
		}

		if($this->pageType == 'chkRejected'){
			$searchFld = ['fqcd.Id','fqcd.QCProcessingDate', 'fqcd.QCProcessingTime'];
			if(!$this->user_Gateway){ // admin section 
				$searchFld = array_merge($searchFld, ['dateDiff' => 'DATEDIFF(\''.date('Y-m-d').'\',fqcd.QCProcessingDate)']);
			}
		}else{
			$searchFld = ['fcd.Id','fcd.CheckInProcessingDate', 'fcd.CheckInProcessingTime'];
			if(!$this->user_Gateway){ // admin section 
				$searchFld = array_merge($searchFld, ['dateDiff' => 'DATEDIFF(\''.date('Y-m-d').'\',fcd.CheckInProcessingDate)']);
			}
		} 
		 
		$pendingData = $this->FilesMainData->pendingFileAnalysisQuery($whereCondition,$searchFld, $this->prifix);
 
		$maxMinDate = $this->getMaxMinDate($pendingData, $whereCondition);
	 
		$this->set('rowData',$maxMinDate['pendingArr']);
 
    }
	
	private function setWhereCondition(){
		$formpostdata = $this->request->getData(); 
		// pr($formpostdata);exit;
		$whereCondition = $this->pageTypeWhereCondition();
		 
		if(!empty($formpostdata)){
			if(!empty($formpostdata['company_id']))
				$whereCondition = array_merge($whereCondition, ['fmd.company_id'=>$formpostdata['company_id']]);
			if(!empty($formpostdata['TransactionType']))
				$whereCondition = array_merge($whereCondition, ['fcd.TransactionType'=>$formpostdata['TransactionType']]);
			if(!empty($formpostdata['State']))
				$whereCondition = array_merge($whereCondition, ['fmd.State'=>$formpostdata['State']]);
			if(!empty($formpostdata['County']))
				$whereCondition = array_merge($whereCondition, ['fmd.County'=>$formpostdata['County']]);
			
			// date will add in setProcessCondition function 
		} 
 
		$agingDay=null;
		if(!empty($formpostdata['startDate']) || (!empty($formpostdata['endDate']))){
			$agingDay = $formpostdata['startDate'].'dt'.$formpostdata['endDate'];
		}
 
		$processingCondition = $this->setProcessCondition($agingDay);
		$whereCondition = array_merge($whereCondition, $processingCondition);
		
		return $whereCondition;
	}

	 
	private function get_strtotime($dt){  
		if(@is_object($dt)){
		 	$time = (array) $dt;
			return strtotime($time['date']); 
		}else{
			return strtotime($dt);
		} 
	}
	
	private function getMaxMinDate($pendingData, $whereCondition){
		$todaydate = date("Y-m-d h:i:s");
		$mindate = [];
		$maxdate = [];
		$filecnt = [];
		$fileUrl = [];
		 
		if(!empty($pendingData)){
			// find out checking min-max dates and file count 
			$numberArray = [10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100];
			$setFirst = 5;
			$setLast  = 101;  
		 
			foreach($pendingData as $value){
 
				$id= '';
				if($this->pageType == "chkRejected"){
					$processingDateTime = $value['fqcd']['QCProcessingDate'].' '.$value['fqcd']['QCProcessingTime'];
					$processingDate = $value['fqcd']['QCProcessingDate'];
					$id=$value['fqcd']['Id'];
				}else{
					$processingDateTime = $value['fcd']['CheckInProcessingDate'].' '.$value['fcd']['CheckInProcessingTime'];
					$processingDate = $value['fcd']['CheckInProcessingDate'];
					$id=$value['fcd']['Id'];
				} 

				$fullDays = $this->getWorkingDays($processingDateTime,$todaydate);
				 
				if($fullDays <= $setFirst){	  
				
					// create dynamic variable 
					$filecnt[$setFirst] = (isset(${"fileNumber" . $setFirst})) ? ++${"fileNumber" . $setFirst} : ${"fileNumber" . $setFirst}=1;
					if(isset($mindate[$setFirst]) == "" || ($this->get_strtotime($mindate[$setFirst]) >= $this->get_strtotime($processingDateTime))){
						$mindate[$setFirst] = $processingDate;
					}
					if(isset($maxdate[$setFirst]) == "" || ($this->get_strtotime($maxdate[$setFirst]) <= $this->get_strtotime($processingDateTime))){
						$maxdate[$setFirst] = $processingDate;
					}
				}else{	$filecnt[$setFirst] = 0; }

				foreach($numberArray as $number){
					
					if($fullDays > ($number-5) && $fullDays <= $number){	
						 
						$filecnt[$number] = (isset(${"fileNumber" . $number})) ? ++${"fileNumber" . $number} : ${"fileNumber" . $number}=1;
						if(isset($mindate[$number]) == "" || ($this->get_strtotime($mindate[$number]) >= $this->get_strtotime($processingDateTime))){
							$mindate[$number] = $processingDate;
						}
						if(isset($maxdate[$number]) == "" || ($this->get_strtotime($maxdate[$number]) <= $this->get_strtotime($processingDateTime))){
							$maxdate[$number] = $processingDate;
						} 
					}else{ 
						 
						$filecnt[$number] = (isset(${"fileNumber" . $number})) ? ${"fileNumber" . $number} : ${"fileNumber" . $number}=0;
					}
				} 
				
				if($fullDays > 100 ){
					
					if($processingDate != ""){
						 
						$filecnt[$setLast] = (isset(${"fileNumber" . $setLast})) ? ++${"fileNumber" . $setLast} : ${"fileNumber" . $setLast} = 1;
						 
						if(isset($mindate[$setLast]) == "" || ($this->get_strtotime($mindate[$setLast]) >= $this->get_strtotime($processingDateTime))){
							$mindate[$setLast] = $processingDate;
						}
						if(isset($maxdate[$setLast]) == "" || ($this->get_strtotime($maxdate[$setLast]) <= $this->get_strtotime($processingDateTime))){
							$maxdate[$setLast] = $processingDate;
						}
					}else{$filecnt[$setLast] = 0;}
				}
			}
		}
 
 		$pendingArr =[];
		// create URL for tooltip 
		foreach($filecnt as $key => $value){ 
			 
			if(isset($mindate[$key]) && isset($maxdate[$key])){ 
				// dont sent post filter start/end date.  it will search from aging
				foreach($whereCondition as $key1=> $con){
					if(($key1 == 'fcd.CheckInProcessingDate >=') || ($key1 == 'fcd.CheckInProcessingDate <=')){
						unset($whereCondition[$key1]);
					}
				}

				
				$whereCondition = array_merge($whereCondition, ['agingDay'=>$mindate[$key].'dt'.$maxdate[$key], 'prifix'=>$this->prifix]);
			  
				$filecnt[$key] =  '<a href="'.Router::url(['controller' => $this->name,'action' => 'fileAnalysisReport','?'=>$whereCondition]).'" target="_blank" title="View Details" >'.$filecnt[$key].'</a>';
				$fileUrl[$key] =  '<a href="'.Router::url(['controller' => $this->name,'action' => 'fileAnalysisDown','?'=>$whereCondition]).'" target="_blank" class="link-success fs-15"><i class="ri-download-2-fill" aria-hidden="true"></i></a>';
			
			}else{
				$fileUrl[$key] = '';
				$filecnt[$key] = 0;
			}  

			$pendingArr[$key] = [$filecnt[$key], $fileUrl[$key]]; 
		} 
  
		$filecntString = implode(',',$filecnt);
		$fileUrlString = implode('","',$fileUrl);
	 
		return ['pendingArr'=>$pendingArr,'fileUrlString'=>$fileUrlString, 'filecntString'=>$filecntString];
		
	}
		
	private function getWorkingDays($startDate,$endDate,$holidays=[]){
		// do $this->get_strtotime calculations just once 
	 
		 $endDate   = $this->get_strtotime($endDate);
	 	 $startDate = $this->get_strtotime($startDate);
		//The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
		//We add one to inlude both dates in the interval.
		// echo"<br/>days = ".  
	 	$days = ($endDate - $startDate) / 86400 + 1;
		$no_full_weeks = floor($days / 7);
		$no_remaining_days = fmod($days, 7);
		//It will return 1 if it's Monday,.. ,7 for Sunday
		//echo"<br/>the_first_day_of_week = ".    
		$the_first_day_of_week = date("N", $startDate);
		$the_last_day_of_week = date("N", $endDate);
		//---->The two can be equal in leap years when february has 29 days, the equal sign is added here
		//In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
		if ($the_first_day_of_week <= $the_last_day_of_week) {
			if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
			if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
		}
		else {
		// (edit by Tokes to fix an edge case where the start day was a Sunday
		// and the end day was NOT a Saturday)
		// the day of the week for start is later than the day of the week for end
			if ($the_first_day_of_week == 7) {
				// if the start date is a Sunday, then we definitely subtract 1 day
				$no_remaining_days--;
				if ($the_last_day_of_week == 6) {
					// if the end date is a Saturday, then we subtract another day
					$no_remaining_days--;
				}
			}
			else {
				// the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
				// so we skip an entire weekend and subtract 2 days
				$no_remaining_days -= 2;
			}
		}
		//The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
		//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
		$workingDays = $no_full_weeks * 5;
		if ($no_remaining_days > 0 )
		{
			$workingDays += $no_remaining_days;
		}
		//We subtract the holidays
		foreach($holidays as $holiday){
			$time_stamp=$this->get_strtotime($holiday);
			//If the holiday doesn't fall in weekend
			if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
				$workingDays--;
		}

		return $workingDays; 
	}
  
	//$agingDay value will change as per page call 
	//$callType for reject page only
	private function setProcessCondition($agingDay=null)
	{
		$processingCondition = [];
		 
		if(!is_null($agingDay) && strpos($agingDay, 'dt')){ 
			if($this->pageType == 'chkRejected'){ 
				$fldName = 'fqcd.QCProcessingDate'; 
			}else{
				$fldName = 'fcd.CheckInProcessingDate'; 
			} 
			$agingDay = explode('dt',$agingDay);
			// process date variable
			if(isset($agingDay[0]) && !empty($agingDay[0])){
				$processingCondition  = [$fldName.' >=' => date('Y-m-d',$this->get_strtotime($agingDay[0]))];
			}
			if(isset($agingDay[1]) && !empty($agingDay[1])){
				$processingCondition  = [$fldName.' <=' => date('Y-m-d',$this->get_strtotime($agingDay[1]))];
			}
			if(!empty($agingDay[0]) && !empty($agingDay[1])){
				$processingCondition  = [$fldName.' >=' => date('Y-m-d',$this->get_strtotime($agingDay[0])), $fldName.' <=' => date('Y-m-d',$this->get_strtotime($agingDay[1]))];
			}
		}

		return $processingCondition;
	} 
 
	private function setPageTypeFileAnalysis(){
 
		$prifix = (!empty($this->request->getQuery('prifix')) ? $this->request->getQuery('prifix') : '');
		if($prifix =='fsad') {  $pageType  = 'chkSubmission'; }
		if($prifix =='frd')  {  $pageType  = 'chkRecording';  }
		if($prifix =='fqcd') {  $pageType  = 'chkRejected';   }
		$this->setPageType($pageType);
	} 
	
	private function setPageType($pageType=null){
		// set default
		$this->pageType = (empty($pageType)) ? $this->pageType : $pageType;;
	}
 

//2
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
	
	//1
	// step for datatable config : 6 custome data action
    private function getCustomParshingData(array $data, $is_index=''){
        // manual
		$count = 1;  

        foreach ($data as $key => $value) {
  
		 	$value['PartnerFileNumber'] = $value['PartnerFileNumber'] . $value['CompanyName'];
 			if(isset($value['ElapsedTime'])){
				//$value['ElapsedTime'] = $this->getElapsedTime($value["ElapsedTime"]);  
				$value['Elapsed Time H:M:S (days)'] = $this->getElapsedTime($value["ElapsedTime"]);  
			} 
			 

			$value['Actions'] = $this->CustomPagination->getActionButtons($this->name,$value,['SrNo','TransactionType'],$prefix = $is_index, $hideViewButton = 9);
			 
			//Elapsed Time H:M:S (days)
			$count++;
        } 
        return $data;
    }

	//2
	private function pageTypeWhereCondition(){
		$whereCondition = [];
		if($this->pageType == 'chkSubmission'){
			$whereCondition = ['fcd.DocumentReceived'=>'Y', 'fsad.ShippingProcessingDate IS' => NULL]; 
		}
		if($this->pageType == 'chkRecording'){
			$whereCondition = ['fcd.DocumentReceived'=>'Y', 'frd.RecordingProcessingDate IS' => NULL]; 
		}
		if($this->pageType == 'chkRejected'){
			$whereCondition = ['fcd.DocumentReceived'=>'Y', 'fqcd.QCProcessingDate IS NOT ' => NULL, 'fqcd.QCProcessingDate !=' => '0000-00-00',  'fqcd.Status NOT IN' => ['OK','']];  //'OR'=>['fqcd.Status != ' => 'OK', 'fqcd.Status IS NOT' => NULL]
		}
		return $whereCondition;
	}

	//2
	private function setFilterQuery($requestFormdata=[], $pdata=[], $selectedIds=null){
		//=====================filter conditions===============================================
		$selectedIdsCondition = [];
		$whereCondition = $this->pageTypeWhereCondition();
		//$whereCondition = $this->setWhereCondition();
		$skipJoin = ['files_shiptoCounty_data'.ARCHIVE_PREFIX, 'files_qc_data'.ARCHIVE_PREFIX, 'files_recording_data'.ARCHIVE_PREFIX,'files_checkin_data'.ARCHIVE_PREFIX,];

		// complte records
		$agingDay = (isset($requestFormdata['agingDay']) ? $requestFormdata['agingDay'] : null);  
		$processingCondition = $this->setProcessCondition($agingDay);  
	 
		$whereCondition = array_merge($whereCondition, $processingCondition);
		
		// set condtion for partner view
		if(isset($this->user_Gateway) && ($this->user_Gateway)){
			$whereCondition = $this->addCompanyToQuery($whereCondition);
		} 
		 
		$query = $this->FilesMainData->pendingFileReportQuery($whereCondition, $pdata['condition'], $this->prifix);
		 
		return ['query' =>$query, 'skipJoin'=>$skipJoin];
	}  
	
	//2
	private function setExtraFields(){ 
		if($this->pageType=="chkSubmission"){
			$this->columnsorder = [0=>'fmd.NATFileNumber', 1=>'fmd.PartnerFileNumber', 2=>'fmd.State', 3=>'fmd.County', 4=>'fcd.CheckInProcessingDate',5=>'fsad.ShippingProcessingDate',6=>'ElapsedTime'];
	
			$this->columns_alise["CheckInProcessingDate"] = "concat(fcd.CheckInProcessingDate, ' ', fcd.CheckInProcessingTime)";
			$this->columns_alise["ShippingProcessingDate"] = "concat(fsad.ShippingProcessingDate, ' ', fsad.ShippingProcessingTime)";
			$this->columns_alise["ElapsedTime"] = "concat(fcd.CheckInProcessingDate, ' ', fcd.CheckInProcessingTime)";
		}
		if($this->pageType=="chkRecording"){
			$this->columnsorder = [0=>'fmd.NATFileNumber', 1=>'fmd.PartnerFileNumber', 2=>'fmd.State', 3=>'fmd.County', 4=>'fcd.CheckInProcessingDate',5=>'frd.RecordingProcessingDate',6=>'ElapsedTime'];
			$this->columns_alise["CheckInProcessingDate"] = "concat(fcd.CheckInProcessingDate, ' ', fcd.CheckInProcessingTime)";
			$this->columns_alise["RecordingProcessingDate"] = "concat(frd.RecordingProcessingDate, ' ', frd.RecordingProcessingTime)"; 
			$this->columns_alise["ElapsedTime"] = "concat(fcd.CheckInProcessingDate, ' ', fcd.CheckInProcessingTime)";
		} 
		if($this->pageType=="chkRejected"){
			$this->columnsorder = [0=>'fmd.NATFileNumber', 1=>'fmd.PartnerFileNumber', 2=>'fmd.State', 3=>'fmd.County', 4=>'fcd.CheckInProcessingDate',5=>'fqcd.QCProcessingDate',6=>'ElapsedTime'];
			$this->columns_alise["CheckInProcessingDate"] = "concat(fcd.CheckInProcessingDate, ' ', fcd.CheckInProcessingTime)"; 
			$this->columns_alise["QCProcessingDate"] = "concat(fqcd.QCProcessingDate, ' ', fqcd.QCProcessingTime)"; 
			$this->columns_alise["ElapsedTime"] = "concat(fcd.CheckInProcessingDate, ' ', fcd.CheckInProcessingTime)";
		}
		$this->columns_alise["SrNo"] = "fmd.Id";
		$this->columns_alise["TransactionType"] = 'fcd.TransactionType';
	}
 
	private function getElapsedTime($dateTime){

		$endDate   = $this->get_strtotime(date("Y-m-d h:i:s"));
		$startDate = $this->get_strtotime($dateTime);

		$days = ($endDate - $startDate) / 86400 + 1;

		$no_full_weeks = floor($days / 7);
		$no_remaining_days = fmod($days, 7);

		$the_first_day_of_week = date("N", $startDate);
		$the_last_day_of_week = date("N", $endDate);

		if ($the_first_day_of_week <= $the_last_day_of_week) {
			if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
			if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
		}
		else {
			// (edit by Tokes to fix an edge case where the start day was a Sunday
			// and the end day was NOT a Saturday)
			// the day of the week for start is later than the day of the week for end
			if ($the_first_day_of_week == 7) {
				// if the start date is a Sunday, then we definitely subtract 1 day
				$no_remaining_days--;

				if ($the_last_day_of_week == 6) {
					// if the end date is a Saturday, then we subtract another day
					$no_remaining_days--;
				}
			}
			else {
				// the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
				// so we skip an entire weekend and subtract 2 days
				$no_remaining_days -= 2;
			}
		}

		$workingDays = $no_full_weeks * 5;
		if ($no_remaining_days > 0 )
		{
		  $workingDays += $no_remaining_days;
		} 

		 $totaldelay = ($workingDays*86400); 
		return $this->strTime($totaldelay).' ('.floor($workingDays)	.')';

	}

	private function strTime($s) {
	 
	  $h = intval($s/3600);
	  $s -= $h*3600;

	  $m = intval($s/60);
	  $s -= $m*60;

	  $str = ($h)? $h.":":'00:';
	  $str .= ($m)? $m.":":'00:';
	  $str .= ($s)? round($s):'00';
	  
	  return $str;
	}
    

	// for generate report 
	public function fileAnalysisDown()
    { 
		$this->autoRender = false;
		//$agingDay = (!empty($this->request->getQuery('agingDay')) ? $this->request->getQuery('agingDay') : '');
		$this->setPageTypeFileAnalysis();
		$this->setExtraFields(); 
		// set company Id in app controller
		$requestData = $this->request->getQuery();
		//pr($requestData);
		 $this->prifix = (!empty($requestData['prifix']) ? $requestData['prifix'] : '');
		// generate sheet
		$this->recordAnalysisData($requestData);
	}
	// use for generetare excel sheets
	private function recordAnalysisData(array $postData ){
 	 
		// get unique comapnyid from post records
	 
		if(isset($postData['fmd_CompanyId'])){$postData['company_id'] =  $postData['fmd_CompanyId'] ;}
		if(isset($postData['fcd_DocumentType'])){$postData['TransactionType'] =  $postData['fcd_DocumentType'] ;}
		if(isset($postData['fmd_State'])){$postData['State'] =  $postData['fmd_State'] ;}
		if(isset($postData['fmd_County'])){$postData['County'] =  $postData['fmd_County'] ;}  
		//$companyId = $this->setCompanyId($postData);
	  //	unset($postData['fmd_CompanyId']);
		//===================== generete csv file data & name to export data====================//	
		 
		//$querymapfields for both condition map fields found or not
		$pdata = $this->postDataCondition(['formdata'=>$postData,'draw' => 1,'order'=>null], true);
		 
		$queryFilter = $this->setFilterQuery($postData, $pdata);
		// debug($queryFilter); exit;
		$this->skipJoin = $queryFilter['skipJoin'];
		$queryFilter['query']->select($this->columns_alise); 
	
		//$resultQuery['companyId'] = $companyId;
		$this->generateCsvSheet($queryFilter['query']); 
	}
	 
	public function generateCsvSheet($queryFilter=[]){
		$csvFileName =''; 
		$csvNamePrifix = $this->pageType;  
 		$resultRecord = $this->FilesMainData->getQueryCountResult($queryFilter);
	 
		$listRecord = $this->FilesMainData->setListRecords($resultRecord, array_keys($this->columns_alise));
		//pr($listRecord);exit;
		//updateAllSheetGenerate
		if(array_key_exists(0,$listRecord))
		{	
			//send only headers from headerParams
			$csvFileName = $this->CustomPagination->recordExport($listRecord, array_keys($this->columns_alise), $csvNamePrifix, 'export');
			$this->sampleExport($csvFileName,'export');
			//$this->set('csvFileName',$csvFileName);
			//$this->Flash->success(__('Statistics data sheet listed!!')); 
		}else{
			//$this->Flash->error(__('Statistics data not found!!'));
		}

	}
	
  
	public function fileAnalysisReport()
    { 
		$this->set('pageTitle', 'Analysis Report for Pending Files');
		//$agingDay = (!empty($this->request->getQuery('agingDay')) ? $this->request->getQuery('agingDay') : '');
		$Statistics = null; //$this->Statistics;
		$this->setPageTypeFileAnalysis();
	 
		$this->setExtraFields(); 
		// set company Id in app controller
		$requestData = $this->request->getQuery();
		$requestData['company_id'] = (isset($requestData['fmd_CompanyId']) ? $requestData['fmd_CompanyId'] : 0);
		$company_mst_id = $this->setCompanyId($requestData);
		unset($requestData['company_id']);
	 
		// End add Account details
		$this->columns_alise['Elapsed Time H:M:S (days)']='';
		$this->columns_alise["Actions"] = ''; 
		unset($this->columns_alise['ElapsedTime']);
		/* unset($this->columns_alise['ElapsedTime']);
		unset($this->columns_alise['ElapsedTime']); */
		$this->set('dataJson', $this->CustomPagination->setDataJson($this->columns_alise,['Actions']));

        // step for datatable config : 4 
		//end step
		$isSearch = 0;
        $formpostdata =$requestData;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $formpostdata = array_merge($this->request->getData());
			$isSearch = 1;
        } 

		$partnerMapField =  $this->CompanyFieldsMap->partnerMapFields($company_mst_id,1); 
	//	unset($formpostdata['company_id']);
		$this->set('_serialize', ['Statistics']);
		$this->set(compact('Statistics', 'partnerMapField','formpostdata','isSearch'));  
		$this->set('datatblHerader', $this->columns_alise); 
		$this->set('pageType', $this->pageType);
	 
	}
	
 
//1
	 // step for datatable config : 5 main step
	 public function ajaxListIndex(){
		
		$this->autoRender = false;
		 
		$is_index = $this->request->getData('is_index');
	 	$this->setPageType($is_index);
		$postData = $this->request->getData();
 
		$this->prifix = (!empty($postData['formdata']['prifix']) ? $postData['formdata']['prifix'] : '');
	 	$this->setExtraFields(); 
		
		  // get unique comapnyid from post records 
		if(isset($postData['formdata']['fmd_CompanyId'])){$postData['formdata']['company_id'] =  $postData['formdata']['fmd_CompanyId'] ;}
		if(isset($postData['formdata']['fcd_DocumentType'])){$postData['formdata']['TransactionType'] =  $postData['formdata']['fcd_DocumentType'] ;}
		if(isset($postData['formdata']['fmd_State'])){$postData['formdata']['State'] =  $postData['formdata']['fmd_State'] ;}
		if(isset($postData['formdata']['fmd_County'])){$postData['formdata']['County'] =  $postData['formdata']['fmd_County'] ;}  
		//$companyId = $this->setCompanyId($postData);
	  //	unset($postData['fmd_CompanyId']);
		//===================== generete csv file data & name to export data====================//	
	 
		//$querymapfields for both condition map fields found or not
		$pdata = $this->postDataCondition($postData);
		// Remove query limit for all records
		if($pdata['condition']['limit'] == -1){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']);
		} // END
	// pr($pdata);
		$queryFilter = $this->setFilterQuery($postData['formdata'], $pdata, $is_index);
		$query = $queryFilter['query'];
		//debug($query); exit; 
		//search records
		$recordsTotal = $this->FilesMainData->getQueryCountResult($query, 'count', false); 
        $data = $this->FilesMainData->getQueryCountResult($query);

        // customise as per condition for differant datatable use.
        $data = $this->getCustomParshingData($data,$is_index);
 
        $response = array(
						"draw" => intval($pdata['draw']),
						"recordsTotal" => intval($recordsTotal),
						"recordsFiltered" => intval($recordsTotal),
						"data" => $data
					);

        echo json_encode($response); 
        exit;
    }
   
}
