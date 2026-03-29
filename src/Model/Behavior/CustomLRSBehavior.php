<?php

namespace App\Model\Behavior; 
use Cake\ORM\Behavior;
use Cake\ORM\TableRegistry;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Datasource\ConnectionManager;

class CustomLRSBehavior extends Behavior
{
	public $tableName;public $aliasName;
	public $is_group = false;
	
	public function initialize(array $config): void
	{
		parent::initialize($config);
		// model(table) which call from
		$this->tableName = $this->getTable()->getTable();
		$this->aliasName = $this->getTable()->getAlias();
		// Some initialization code here
	}
	public function debugsql(Query $query){
		return debug($query->sql());
	}
	public function setHeaderQueryFld(array $partnerMapFields, $setReturn2P=false)
	{

		$fieldsFcd = ['TransactionType'=>'TransactionType','DocumentReceived'=>'DocumentReceived','CheckInProcessingDate'=>'CheckInProcessingDate'];

		$fieldsQc = ['OnHold_RejectionStatus','Status','CarrierName4RR','TrackingNo4RR','CRNStatus','CRNCarrierName4RR','CRNTrackingNo4RR']; //'OnHold_RejectionStatus' == 'Status'
		$fieldsAcc = ['CountyRecordingFee','Taxes','AdditionalFees','Total','CheckNumber1','CheckNumber2','CheckNumber3','EPortalActual','jrf_final_fees', 'it_final_fees', 'of_final_fees', 'total_final_fees'];
		$fieldsRec = ['File','RecordingDate','RecordingTime','InstrumentNumber','Book','Page'];
		
		$fieldsShip = [];$fieldsReturn = [];
		if($setReturn2P){
			$fieldsReturn = ['CarrierName','CarrierTrackingNo','RTPProcessingDate'];
		}else{
			$fieldsShip = ['CarrierName','CarrierTrackingNo'];
		}
		
		$fieldsPblNote = ['PublicNotes'];
		$fieldsCntMst = ['CountyCode'];

		$querymapfields = [];
		$tableFldCount = ['fvaFieldsCount'=>0,'chkFieldsCount'=>0,'qcFieldsCount'=>0,'accFieldsCount'=>0,'recFieldsCount'=>0,'shipFieldsCount'=>0,'returnFieldsCount'=>0,'CntMstCount'=>0];//'publicNoteCount'=>0,

		$headerParams = [];
		foreach($partnerMapFields as $tblName=>$mapName){
			// ERROR MAYBE
			if($tblName == 'TransactionType') { $mapName = 'TransactionType';}
			
			if(in_array($tblName,$fieldsQc)){
				$tblName = ($tblName == 'OnHold_RejectionStatus') ? 'Status':$tblName;
				$querymapfields[] = "fqcd.".$tblName;
				$tableFldCount['qcFieldsCount']++;
				//$querymapfields[] ='';  //??
				
				if (empty(trim($mapName))) $headerParams[$tblName]=$tblName;
				else $headerParams[$mapName]=$tblName;
				
			}
			elseif(in_array($tblName,$fieldsFcd)){
				$querymapfields[] = "fcd.".$tblName;
				$tableFldCount['chkFieldsCount']++;
				
				if (empty(trim($mapName))) $headerParams[$tblName]=$tblName;
				else $headerParams[$mapName]=$tblName;
			}
			elseif(in_array($tblName,$fieldsFcd)){
				$querymapfields[] = "fva.".$tblName;
				$tableFldCount['fvaFieldsCount']++;
				
				if (empty(trim($mapName))) $headerParams[$tblName]=$tblName;
				else $headerParams[$mapName]=$tblName;
			}
			elseif(in_array($tblName,$fieldsAcc)){
				$querymapfields[] = "fad.".$tblName;
				$tableFldCount['accFieldsCount']++;
				
				if (empty(trim($mapName))) $headerParams[$tblName]=$tblName;
				else $headerParams[$mapName]=$tblName;
				
			}
			elseif(in_array($tblName,$fieldsRec)){
				$querymapfields[] = "frd.".$tblName;
				$tableFldCount['recFieldsCount']++;
				
				if (empty(trim($mapName))) $headerParams[$tblName]=$tblName;
				else $headerParams[$mapName]=$tblName;
				
			}
			elseif(in_array($tblName,$fieldsShip)){
				$querymapfields[] = "fsad.".$tblName;
				$tableFldCount['shipFieldsCount']++;
				
				if (empty(trim($mapName))) $headerParams[$tblName]=$tblName;
				else $headerParams[$mapName]=$tblName;
				
			} 
			 elseif(in_array($tblName,$fieldsReturn)){
				$querymapfields[] = "frtp.".$tblName;
				$tableFldCount['returnFieldsCount']++;
				
				if (empty(trim($mapName))) $headerParams[$tblName]=$tblName;
				else $headerParams[$mapName]=$tblName;

			}
			/* elseif(in_array($tblName,$fieldsPblNote)){
				//$querymapfields[] = "pblnt.".$tblName;
				$querymapfields[] = "pblnt.Regarding";
				$tableFldCount['publicNoteCount']++;
				
				if (empty(trim($mapName))) $headerParams[$tblName]=$tblName;
				else $headerParams[$mapName]=$tblName;
			
			} */
			elseif(in_array($tblName,$fieldsCntMst)){ 
				$querymapfields[] = "cnt.cm_code";
				$tableFldCount['CntMstCount']++;
				
				if (empty(trim($mapName))) $headerParams[$tblName]=$tblName;
				else $headerParams[$mapName]=$tblName; 
			}
			else{
				$querymapfields[] = "fmd.".$tblName;
				
				if (empty(trim($mapName))) $headerParams[$tblName]=$tblName;
				else $headerParams[$mapName]=$tblName;
			}

		}
		
		//if($this->tableName == 'files_checkin_data'.ARCHIVE_PREFIX){
		if($this->tableName == 'files_vendor_assignment'.ARCHIVE_PREFIX){
			$headerParams = array_filter(array_merge($headerParams,$fieldsFcd));
		}
		// change dynamic key name of company_mst_id as partnerId for csv header.
		/* if(isset($headerParams['company_mst_id'])){
			$headerParams['PartnerId'] = $headerParams['company_mst_id'];
			unset( $headerParams['company_mst_id'] );
		} */
	
		return ['headerParams'=>$headerParams,'querymapfields'=>$querymapfields,'tableFldCount'=>$tableFldCount];
		
	}
	
	// for single date fields from same table
	public function dateBetween(Query $query, $dateFrom, $dateTo, $dateField, $orAnd='where'){
		
		if(!empty($dateFrom) && !empty($dateTo)){
			$query = $query->$orAnd(function ($exp, $q) use($dateFrom,$dateTo,$dateField) {
				return $exp->between('date('.$dateField.')', date('Y-m-d',strtotime($dateFrom)), date('Y-m-d',strtotime($dateTo)));
			}); 
		}elseif(!empty($dateFrom) && empty($dateTo)){
			$query =  $query->$orAnd(function ($exp, $q) use($dateFrom,$dateField) {
				return $exp->gte('date('.$dateField.')', date('Y-m-d',strtotime($dateFrom)));
			}); 
		}elseif(empty($dateFrom) && !empty($dateTo)){
			$query =  $query->$orAnd(function ($exp, $q) use($dateTo,$dateField) {
				return $exp->lte('date('.$dateField.')', date('Y-m-d',strtotime($dateTo)));
			});
		}

		return $query;
	}
	 
	// only date processing
	public function dateBetweenWhere($dateFrom, $dateTo, $dateField){
		$whereDate= '';
		if(!empty($dateFrom) && !empty($dateTo)){
			
			$whereDate = function ($exp, $q) use($dateFrom,$dateTo,$dateField) {
							return $exp->between('date('.$dateField.')', date('Y-m-d',strtotime($dateFrom)), date('Y-m-d',strtotime($dateTo)));
						 };
		}elseif(!empty($dateFrom) && empty($dateTo)){
			$whereDate = function ($exp, $q) use($dateFrom,$dateField) {
							return $exp->gte('date('.$dateField.')', date('Y-m-d',strtotime($dateFrom)));
						}; 
		}elseif(empty($dateFrom) && !empty($dateTo)){
			$whereDate = function ($exp, $q) use($dateTo,$dateField) {
							return $exp->lte('date('.$dateField.')', date('Y-m-d',strtotime($dateTo)));
						}; 
		}

		return $whereDate;
	}
	
	/**********************************************************************
	// for more date fields will post to search from different table
	// DocumentStartDate ==> records document received DocumentReceived = 'Y'	
	// RecordsStartDate ==> record add checkin only DocumentReceived = null
	***********************************************************************/
	
	public function dateFieldsAddtoQuery($query, $requestFormdata, $skipJoin=[]){
	
		$dateFldArray = ['fmd.DateAdded'=>['FileStartDate', 'FileEndDate'], 
						'fcd.CheckInProcessingDate'=>[['RecordsStartDate', 'RecordsEndDate'],['DocumentStartDate', 'DocumentEndDate']], 
						'fqcd.QCProcessingDate' => ['QCStartDate', 'QCEndDate'],
						'fqcd.CountyRejectionProcessingDate'=>['holdfromdate', 'holdtodate'], 
						'fad.AccountingProcessingDate'=> ['AccountingStartDate', 'AccountingEndDate'], 
						'fsad.ShippingProcessingDate'=> ['ShipStartDate', 'ShipEndDate'], 
						'fsad.FedexMappingDate'=> ['fedexStartDate', 'fedexEndDate'], // not use ?
						'fsad.DeliveryDate'=> ['fedexDeliveryStartDate', 'fedexDeliveryEndDate'],  
						// not use ? 
						'frd.RecordingProcessingDate'=> ['RecordingStartDate', 'RecordingEndDate'],
						'frtp.RTPProcessingDate'=> ['returnStartDate', 'returnEndDate']
						];
		$tableFldCount = ['chkFieldsCount'=>0,'qcFieldsCount'=>0,'accFieldsCount'=>0,'recFieldsCount'=>0,'shipFieldsCount'=>0,'returnFieldsCount'=>0]; //,'publicNoteCount'=>0
		
		$cnt = 0;
		$orAnd = 'where';
		//$test= [];
		$wheresss=[];
		foreach($dateFldArray as $key=>$value){
			
			 if($cnt >=1){
				$orAnd = 'orWhere';
			} 
			if(is_array($value[0])){
				// for more value for same fields and use in master search and complete search
				foreach($value as $datefld){
					$fromdate ='';$todate = '';
					  if($cnt >=1){
						$orAnd = 'orWhere';
					} 
					if(isset($requestFormdata[$datefld[0]])){  // && !empty($requestFormdata[$datefld[0]])
						$fromdate = $requestFormdata[$datefld[0]];
					}
					
					if(isset($requestFormdata[$datefld[1]])){ // && !empty($requestFormdata[$datefld[1]])
						$todate = $requestFormdata[$datefld[1]];
					}
					
					if(!empty($fromdate) || !empty($todate)){
						
						$tableFldCount = $this->tblFldCount($tableFldCount, $key);
						
						// date 
						if($key == 'fcd.CheckInProcessingDate'){
							//Add DocumentReceived field for master pages
							$is_DocumentReceived = ($datefld[0] == 'DocumentStartDate') ? 'Y': '';
						
							/* $query =  $query->$orAnd(['AND'=>[function ($exp, $q)  use($fromdate,$todate,$key) {
								return $exp->between($key, date('Y-m-d',strtotime($fromdate)), date('Y-m-d',strtotime($todate)));
							},'fcd.DocumentReceived'=>$is_DocumentReceived]]);  */
							
							$wheresss['OR'][] = [$this->dateBetweenWhere($fromdate,$todate,$key), 
												'fcd.DocumentReceived'=>$is_DocumentReceived];
						}
						$cnt++;
					}
				}

			}else{

				$fromdate ='';$todate = '';
				if(isset($requestFormdata[$value[0]])){ // && !empty($requestFormdata[$value[0]])
					$fromdate = $requestFormdata[$value[0]]; 
				}
				if(isset($requestFormdata[$value[1]])){  //&& !empty($requestFormdata[$value[1]])
					$todate = $requestFormdata[$value[1]];
				}

				if(!empty($fromdate) || !empty($todate)){

					$tableFldCount = $this->tblFldCount($tableFldCount, $key);
					//$query = $this->dateBetween($query, $fromdate, $todate, $key, $orAnd); 
					$wheresss['OR'][] = [
											$this->dateBetweenWhere($fromdate,$todate,$key)
										];
					$cnt++;
				}
			}
		}
	
		$query = $query->where($wheresss);
		// if search only 
		$query = $this->getOtherTableJoin($query, $tableFldCount, null, null, null, $skipJoin); 
		return $query;
		
	}
 

	private function tblFldCount($tableFldCount, $key){

		$keySplite = explode('.',$key);
		if(isset($keySplite[0])){
			switch($keySplite[0]){
			    case 'fva': $tableFldCount['fvaFieldsCount']++; break;
				case 'fcd': $tableFldCount['chkFieldsCount']++; break;
				case 'fqcd': $tableFldCount['qcFieldsCount']++; break;
				case 'fad': $tableFldCount['accFieldsCount']++; break;
				case 'frd': $tableFldCount['recFieldsCount']++; break;
				case 'fsad': $tableFldCount['shipFieldsCount']++; break;
				case 'frtp': $tableFldCount['returnFieldsCount']++; break;
				//case 'pblnt': $tableFldCount['publicNoteCount']++; break;
			}
		}
		return $tableFldCount;

	}
	
	public function tblFldCountExport($fldKey){
		 
		//chkFiel;dsCount add as default
		$tableFldCount = ['fvaFieldsCount'=>0,'chkFieldsCount'=>0,'qcFieldsCount'=>0,'accFieldsCount'=>0,'recFieldsCount'=>0,'shipFieldsCount'=>0,'returnFieldsCount'=>0]; //,'publicNoteCount'=>0
		$keySplite =[];
		foreach($fldKey as $key){
			$keySplite = explode('.',$key);
			if(isset($keySplite[0])){
				switch($keySplite[0]){
				    case 'fva':  $tableFldCount['fvaFieldsCount']++; break;
					case 'fcd':  $tableFldCount['chkFieldsCount']++; break;
					case 'fqcd': $tableFldCount['qcFieldsCount']++; break;
					case 'fad':  $tableFldCount['accFieldsCount']++; break;
					case 'frd':  $tableFldCount['recFieldsCount']++; break;
					case 'fsad': $tableFldCount['shipFieldsCount']++; break;
					case 'frtp':  $tableFldCount['returnFieldsCount']++; break;
				//	case 'pblnt': $tableFldCount['publicNoteCount']++; break;
				}
			}
		}
		return $tableFldCount;

	}
	
	/*********************************************
	// call two time in same page request
	// 1) for date fields add to table dateFieldsAddtoQuery() "Search only With Export call"
    // 2) for csv headers fields add. searchExportByDateRange() "Export CSV header With search"
	********************************************/
	public function getOtherTableJoin(Query $query, array $tableFldCount, $dateFrom=null, $dateTo=null, $dateField=null, $skipJoin=[]){
//pr($query); exit;
		$tableJoin = [ 
		                'fvaFieldsCount'=>['fva','files_vendor_assignment'.ARCHIVE_PREFIX],
						'chkFieldsCount'=>['fcd','files_checkin_data'.ARCHIVE_PREFIX],
						'qcFieldsCount'=>['fqcd','files_qc_data'.ARCHIVE_PREFIX],
						'accFieldsCount'=>['fad','files_accounting_data'.ARCHIVE_PREFIX],
						'recFieldsCount'=>['frd','files_recording_data'.ARCHIVE_PREFIX],
						'shipFieldsCount'=>['fsad','files_shiptoCounty_data'.ARCHIVE_PREFIX],
						'returnFieldsCount'=> ['frtp','files_returned2partner'.ARCHIVE_PREFIX]/* ,
						'publicNoteCount'=>['pblnt','public_notes'.ARCHIVE_PREFIX] */
					 ];
			
		$tableArray = ['files_vendor_assignment'.ARCHIVE_PREFIX=>'fva', 'files_checkin_data'.ARCHIVE_PREFIX=>'fcd', 'files_qc_data'.ARCHIVE_PREFIX=>'fqcd', 'files_accounting_data'.ARCHIVE_PREFIX=>'fad', 'files_recording_data'.ARCHIVE_PREFIX=>'frd', 'files_shiptoCounty_data'.ARCHIVE_PREFIX=>'fsad', 'files_returned2partner'.ARCHIVE_PREFIX=>'frtp'/* , 'public_notes'.ARCHIVE_PREFIX=>'pblnt' */];
		
		if($this->tableName == 'files_vendor_assignment'.ARCHIVE_PREFIX) $this->aliasName ='fva';
		if($this->tableName == 'files_checkin_data'.ARCHIVE_PREFIX) $this->aliasName ='fcd';
		if($this->tableName == 'files_qc_data'.ARCHIVE_PREFIX) $this->aliasName ='fqcd';
		if($this->tableName == 'files_accounting_data'.ARCHIVE_PREFIX) $this->aliasName ='fad';
		if($this->tableName == 'files_recording_data'.ARCHIVE_PREFIX) $this->aliasName ='frd';
		if($this->tableName == 'files_shiptoCounty_data'.ARCHIVE_PREFIX) $this->aliasName ='fsad';
		if($this->tableName == 'files_returned2partner'.ARCHIVE_PREFIX) $this->aliasName ='frtp';
		// for return2Partner table ???
		//if($this->tableName == 'public_notes'.ARCHIVE_PREFIX) $this->aliasName ='pblnt'; //??
		
		// for AF pending  (check of QC and Accounting other pages skipJoin[] )  

		if(!empty($skipJoin)){ $this->aliasName = $tableArray[$skipJoin[0]]; }

		 foreach($tableJoin as $key=>$value){
			 // check table count for add
			 if(!empty($tableFldCount) && $tableFldCount[$key] > 0){ 
				// skip table for join if allready add in parent query.
				if(!in_array($value[1], $skipJoin)){ 
					$query = $query->join([
								'table' => $value[1],
								'alias' => $value[0],
								'type' => 'LEFT',
								'conditions' => [$value[0].'.RecId = '.$this->aliasName.'.RecId', $value[0].'.TransactionType = '.$this->aliasName.'.TransactionType']
							]);
				}
			}
		 }
		
		if(!empty($dateFrom) || !empty($dateTo)){
			// for FilesCheckinData table
			$query =  $this->dateBetween($query, $dateFrom, $dateTo, $dateField);
		}
		
		/* if(isset($tableFldCount['publicNoteCount']) && ($tableFldCount['publicNoteCount'] > 0)){
			$this->is_group = true;
			$query = $query->group([$this->aliasName.'.RecId', $this->aliasName.'.TransactionType']);
		} */
		
		return $query; 
	}
	
	
	public function setListRecords($rowData, $headerParams,$forCounty=false)
	{
 		  
		$listRecord = [];
		if(array_key_exists(0,$rowData)){
			
			foreach($rowData as $record){
 
				$listRecordset= [];				
				foreach($headerParams as $key=>$value){
			 
					// becouse of section alies added to headerflds
					if(strpos($value,".") !== false){
						$valueExpl = explode('.',$value);
						$value = $valueExpl[1];
					}
				
					if($value == 'TransactionType')
					{ 
						 if(isset($record['fva']['TransactionType']) && isset($record['dtm']['Title']))
						{  
							$listRecordset[] = $record['fva']['TransactionType'].' ('.$record['dtm']['Title'].')';
						}elseif(isset($record['fmd']['TransactionType']) && isset($record['dtm']['Title']))
						{ 
							$listRecordset[] = $record['fmd']['TransactionType'].' ('.$record['dtm']['Title'].')';
						}elseif(isset($record['TransactionType']) && isset($record['dtm']['Title']))
						{   $value;
							$listRecordset[] = $record['TransactionType'].' ('.$record['dtm']['Title'].')';
						}else{   $value;$listRecordset[] = (isset($record[$value]) ? $record[$value] : '');} 
					}
					elseif($value == 'DocumentReceived'){
						if(isset($record[$value]))
						{
							$listRecordset[] = (($record[$value]=='Y')? 'Recorded.':'Not Recorded.');
						}
					}
					elseif($value == 'CheckInProcessingDate'){
						 
						if(isset($record[$value])) 
						{ 
							$listRecordset[] = ($record[$value]== EMPTYDATE || empty($record[$value]) ? '' : $record[$value]);
						}
						if(isset($record[$value]) && isset($record['CheckInProcessingTime'])) 
						{ 
							$listRecordset[] = ($record[$value]== EMPTYDATE || empty($record[$value])) ? '' : date('m-d-Y', strtotime($record[$value])).', '.date('H:i', strtotime($record['CheckInProcessingTime']));
						}
						
						if(isset($record['fva'][$value])){ 
							$listRecordset[] = ($record['fva'][$value]== EMPTYDATE || empty($record['fva'][$value]))? '':date('m-d-Y', strtotime($record['fva'][$value]));
						}
					}
					
					elseif($value == 'PublicNotes'){
						if(isset($record['pblnt']['Regarding']))
						{
							$listRecordset[] = $record['pblnt']['Regarding'];
						}
					} 
					elseif($value == 'company_id'){
						if(isset($record['cpm']['cm_comp_name']))
						{
							$listRecordset[] = $record['cpm']['cm_comp_name'];
						}
					} 
					elseif($forCounty == true && ($value == 'CountyRecordingFee' || $value == 'Taxes' || $value == 'AdditionalFees' || $value == 'Total' || $value == 'jrf_final_fees' || $value == 'it_final_fees' || $value == 'of_final_fees' || $value == 'total_final_fees')){
						$listRecordset[] = (isset($record[$value]) ? $record[$value] : '');
					}
					elseif($value == 'CheckInDateTime' || $value == 'FileStartDate'){
	
						if(isset($record['fmd'][$value]))
						{ 
							$listRecordset[] = ($record['fmd'][$value]== EMPTYDATE || empty($record['fmd'][$value]))? '':date('m-d-Y', strtotime($record['fmd'][$value]));
						}else{
							$listRecordset[] = ($record[$value]== EMPTYDATE || empty($record[$value]))? '':date('m-d-Y', strtotime($record[$value]));
						}
					}
					else{
						if(isset($record['fmd'][$value]))
						{
							$listRecordset[] = $record['fmd'][$value];
						}
						elseif(isset($record['fva'][$value]))
						{
							$listRecordset[] = $record['fva'][$value];
						}
						elseif(isset($record['fqcd'][$value]))
						{
							$listRecordset[] = $record['fqcd'][$value];
						}
						elseif(isset($record['fad'][$value]))
						{
							 
							$listRecordset[] = $record['fad'][$value];
						}
						elseif(isset($record['frd'][$value]))
						{
							$listRecordset[] = $record['frd'][$value];
						}
						elseif(isset($record['fsd'][$value]))
						{
							$listRecordset[] = $record['fsd'][$value];
						}
						elseif(isset($record['fsad'][$value]))
						{
							$listRecordset[] = $record['fsad'][$value];
						}
						elseif(isset($record['frtp'][$value]))
						{
							$listRecordset[] = $record['frtp'][$value];
						}
						else{ 
							$listRecordset[] = (isset($record[$value]) ? $record[$value] : '');
						}
					}
					
				}
				
				$listRecord[] = $listRecordset;
			 
				 
			}
		}

		return $listRecord;
	}
	
	// call from generate csv record sheet
	public function searchExportByDateRange(Query $query, array $partnerMapFields, $return=null, $skipJoin=[],$forCounty=false){
		 
		$param = ['partnerMapFields'=>$partnerMapFields, 'skipJoin'=>$skipJoin, 'onlyQuery'=>false];
		$getQuery = $this->generateQuery($query, $param,$forCounty);

		$rowData = $getQuery['query']->toArray();
		if($forCounty == true) {
			$getQuery['headerParams']['Count'] = 'Count';
		}
 		
		if(!empty($return) && $return == 'dataOnly'){
			return $rowData;
		}elseif(!empty($return) && $return == 'dataNheaderOnly'){ // af pending
			return ['records'=>$rowData, 'headerParams'=>$getQuery['headerParams']];
		}else{
			$listRecord = $this->setListRecords($rowData, $getQuery['headerParams'],$forCounty);
			return ['records'=>$listRecord, 'headerParams'=>$getQuery['headerParams']];
		}

	}
	
	private function initiateParam($param){
		
		$param['partnerMapFields']= isset($param['partnerMapFields']) ? $param['partnerMapFields'] : [];
		$param['skipJoin']= isset($param['skipJoin']) ? $param['skipJoin'] : [];
		$param['onlyQuery']= isset($param['onlyQuery']) ? $param['onlyQuery'] : true;
		
		return $param;
	}
	
	// generate Query for all table join and all (Add extra fields)
	public function generateQuery(Query $query, $param=[], $forCounty=false){
		 
		$param = $this->initiateParam($param);
 
		$setReturn2P=false;
		// code only for return to partner and complete order for carrier-name of R2P
		if(!empty($skipJoin) && in_array('files_returned2partner'.ARCHIVE_PREFIX,$param['skipJoin'])){
			$setReturn2P = true;
		}

		$fieldsSearch = $this->setFieldsToSearch($param['skipJoin']);
	 
		// get only query
		if($param['onlyQuery']===true){
			 
			$query =  $query->select($fieldsSearch);
		}else{
			 
			if($forCounty == true) {
				unset($param['partnerMapFields']['Count']); 
			}
			$headerQueryFld = $this->setHeaderQueryFld($param['partnerMapFields'], $setReturn2P);
			$fieldsSearch = array_filter(array_merge($fieldsSearch, $headerQueryFld['querymapfields']));
			 
			// use model
			$query =  $query->select($fieldsSearch);
			// add conditional Join Query for search and sheet generate
			$query = $this->getOtherTableJoin($query, $headerQueryFld['tableFldCount'], null, null, null, $param['skipJoin']);
		}

		// generate count for csv data links and query for csv report
		$return = ($param['onlyQuery']) ? ['query'=>$query] : ['query'=>$query, 'headerParams'=>$headerQueryFld['headerParams']];
		
		return $return;
		
	}
	
	private function setFieldsToSearch(array $skipJoin=[]){
		$fieldsSearch = ['dtm.Title','cpm.cm_comp_name'];
		
		// call from only checkIn pages " adjustment :) " 
		
		if((!empty($skipJoin)) && (count($skipJoin) == 1) && $skipJoin[0] == 'files_checkin_data'.ARCHIVE_PREFIX){
			$fieldsSearch = ['dtm.Title','cpm.cm_comp_name','fcd.Id', 'fcd.TransactionType','fcd.DocumentReceived', 'fcd.CheckInProcessingDate', 'fcd.CheckInProcessingTime'];
		}
		
		return $fieldsSearch;
	}
	
	public function partnerExportFields($companyId='',$exportFld='', $csvNameFld=''){
		$partnerMapFields = ['NATFileNumber'=>'','PartnerFileNumber'=>'','Grantors'=>'','StreetName'=>'','County'=>'','State'=>''];
 
		$this->CompanyExportFields = TableRegistry::get('CompanyExportFields');
		$companyExportField = $this->CompanyExportFields->exportFieldsDataByField($companyId,$exportFld);
	
		$this->CompanyFieldsMap = TableRegistry::get('CompanyFieldsMap');
		//
		if((empty($companyExportField) || empty($companyExportField[0]))&& $exportFld == 'cef_fieldid4GP'){  
			$companyExportField = [1,33,3,4,5,7,12,13,32,64]; // added for EFS by MJ on 20/04/23
		}
 
		if(!empty($companyExportField)){
			$partnerMapFields = $this->CompanyFieldsMap->checkMapFieldsTitleById($companyId, $companyExportField);
			unset($partnerMapFields['InternalNotes']); // no use
		}
 
		$csvNamePrifix = $this->CompanyFieldsMap->CompanyMst->getExportCsvName($companyId,$csvNameFld);
		
		return ['partnerMapFields'=>$partnerMapFields, 'csvNamePrifix'=>$csvNamePrifix];
	}
	
	
	// function call two type for all datatable
	// 1) Get count -->> getQueryCountResult($query, 'count');
	// 2) Get Result -->> getQueryCountResult($query);
	
	public function getQueryCountResult(Query $query, $type='result'){
		
		if($type == 'count'){
			
			//cleanCopy : Creates a copy of this current query, triggers beforeFind and resets some State.
			$queryCount = $query->cleanCopy(); 
			
			// remove select fields[] and replace with other using cleanCopy()
			// use copy of original query
			if($this->is_group){
				// always run
				$queryCount = $queryCount->select(['recordCount' => $queryCount->func()->count('*')], true);
			}else{ 
				//run in check-in and statistics
				$queryCount = $queryCount->select(['recordCount' => 'fmd.Id'], true);	
			}
			
			/* 	
			$result = $queryCount->all()->toArray();
			return count($result); */
 
			$result = $queryCount->count();
			return $result;
		}

		if($type == 'result'){
			//original query used
			$result = $query->all()->toArray(); // dont use hydrate
			return $result;
			
		}
	}

}
