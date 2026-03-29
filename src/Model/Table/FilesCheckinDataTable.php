<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator; 
/**
 * FilesCheckinData Model
 *
 * @method \App\Model\Entity\FilesCheckinData newEmptyEntity()
 * @method \App\Model\Entity\FilesCheckinData newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FilesCheckinData[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FilesCheckinData get($primaryKey, $options = [])
 * @method \App\Model\Entity\FilesCheckinData findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FilesCheckinData patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FilesCheckinData[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FilesCheckinData|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesCheckinData saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesCheckinData[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesCheckinData[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesCheckinData[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesCheckinData[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FilesCheckinDataTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('files_checkin_data'.ARCHIVE_PREFIX);
        $this->setDisplayField('Id');
        $this->setPrimaryKey('Id');

		/* $this->belongsTo('FilesMainData', [
            'foreignKey' => 'Recid',
            'joinType' => 'INNER'
        ]);  */

        $this->addBehavior('CustomLRS');
        // add in plugin
        $this->addBehavior('Search.Search');

         // Setup search filter using search manager
         $this->searchManagerConfig();
        // ->value('company_id')->value('TransactionType');
		
    }


    public function searchManagerConfig()
    {
        $search = $this->searchManager();
       // $search = $this->behaviors()->Search->searchManager();
      
        $search->Value('TransactionType'); 
		$search->Value('company_id',['prifix'=>'fmd']);
		 $search->Like('NATFileNumber',['prifix'=>'fmd']);
	 	$search->Like('PartnerFileNumber',['prifix'=>'fmd']);
	//	$search->Like('LoanNumber',['prifix'=>'fmd']);
		
	//	$search->Like('StreetNumber',['prifix'=>'fmd']);
		$search->Like('StreetName',['prifix'=>'fmd']);
	//	$search->Like('City',['prifix'=>'fmd']);
		$search->Like('County',['prifix'=>'fmd']);
		$search->Like('State',['prifix'=>'fmd']);
	//	$search->Like('Zip',['prifix'=>'fmd']);

		$search->Like('Grantors',['prifix'=>'fmd']);
	//	$search->Like('Grantees',['prifix'=>'fmd']);
		
	//	$search->Like('GrantorFirstName1',['prifix'=>'fmd']);
	//	$search->Like('GranteeFirstName1',['prifix'=>'fmd']);
		
		$search->Value('cm_partner_cmp',['prifix'=>'cpm']);  
	
	//	$search->Like('Status',['prifix'=>'fqd']);
        return $search;
    }
 
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
      /*   $validator
            ->integer('RecId')
            ->requirePresence('RecId', 'create')
            ->notEmptyString('RecId');

        $validator
            ->integer('TransactionType')
            ->requirePresence('TransactionType', 'create')
            ->notEmptyString('TransactionType');

        $validator
            ->scalar('DocumentReceived')
            ->maxLength('DocumentReceived', 1)
            ->requirePresence('DocumentReceived', 'create')
            ->notEmptyString('DocumentReceived');

        $validator
            ->integer('UserId')
            ->requirePresence('UserId', 'create')
            ->notEmptyString('UserId');

        $validator
            ->date('CheckInProcessingDate')
            ->requirePresence('CheckInProcessingDate', 'create')
            ->notEmptyDate('CheckInProcessingDate');

        $validator
            ->time('CheckInProcessingTime')
            ->requirePresence('CheckInProcessingTime', 'create')
            ->notEmptyTime('CheckInProcessingTime');

        $validator
            ->scalar('search_status')
            ->maxLength('search_status', 1)
            ->allowEmptyString('search_status');

        $validator
            ->date('search_status_updated_date')
            ->allowEmptyDate('search_status_updated_date');

        $validator
            ->scalar('barcode_generated')
            ->maxLength('barcode_generated', 1)
            ->allowEmptyString('barcode_generated');

        $validator
            ->scalar('isnew')
            ->maxLength('isnew', 1)
            ->requirePresence('isnew', 'create')
            ->notEmptyString('isnew'); */

        return $validator;
    }

    // call for delete checkin Records
    public function findRecordByRecId($fmdId){
        $results = [];
        $results = $this->find()->where(['RecId'=>$fmdId])->disableHydration()->first();
        
        return $results;
    }


    public function getMainDataByDocType($ClientFlNocolno,  $doctype){
		$results= [];
		$this->setAlias('fcd');
		$query = $this->find()
					->where(['fmd.PartnerFileNumber'=>$ClientFlNocolno, 'fcd.TransactionType'=>$doctype])
					->join([
						'table' => 'files_main_data'.ARCHIVE_PREFIX,
						'alias' => 'fmd',
						'type' => 'LEFT',
						'conditions' => 'fcd.RecId = fmd.Id'
					])->select(['fmd.Id','fcd.TransactionType']);
		$results = $query->disableHydration()->all()->toArray();

		if(!empty($results)) $results=$results[0];
		return $results;
		
	}

    public function insertNewCheckinData($fmdLastId,$documentId,$currentUserId,$docRecived=null, $LRS_extension=0){
		// check unique records for fmd_id & doc_id
		$exist = $this->exists(['RecId' => $fmdLastId, 'TransactionType' => $documentId]);
		 
		if(!$exist){  // not found so insert new
		 
			$filesCheckinData = $this->newEmptyEntity();
			$insertCheckInData =  [
									'RecId' => $fmdLastId,
									'TransactionType' => $documentId,
									'DocumentReceived' => (($docRecived !== null) ? $docRecived : ''),
									'UserId' => $currentUserId,
									'CheckInProcessingDate' => date("Y-m-d"),
									'CheckInProcessingTime' => date("H:i:s")
								];

			if($docRecived !== null){
				$insertCheckInData['DocumentReceived'] = $docRecived;
			}
			if($LRS_extension){
				$insertCheckInData['extension'] = date('Y-m-d H:i:s');
			}
		  
			$filesCheckinData = $this->patchEntity($filesCheckinData, $insertCheckInData,['validate' => false]);
			
			if($this->save($filesCheckinData)) 
				return $filesCheckinData->id;
			else 
				return false;
		}
	} 

    public function filecheckinQuery(array $whereCondition, array $pdata, $cm_partner_cmp = ''){
		$this->setAlias('fcd');
		 
		$query = $this->find('search', $pdata['condition'])
				->join([
					'table' => 'files_main_data'.ARCHIVE_PREFIX,
					'alias' => 'fmd',
					'type' => 'INNER',
					'conditions' => 'fmd.Id = fcd.RecId'
				])
				->join([
					'table' => 'document_type_mst',
					'alias' => 'dtm',
					'type' => 'LEFT',
					'conditions' => 'dtm.Id = fcd.TransactionType'
				])
				->where($whereCondition);

	//	if(!empty($cm_partner_cmp)){
			$query = $query->join([
							'table' => 'company_mst',
							'alias' => 'cpm',
							'type' => 'LEFT',
							'conditions' => 'cpm.cm_id = fmd.company_id'
						]);
	//	}
		//for reject search on checking section
		$tableFldCount = $this->tblFldCountExport($pdata['condition']['fields']);  
		$query = $this->getOtherTableJoin($query, $tableFldCount,null, null, null, ['files_checkin_data'.ARCHIVE_PREFIX]);
		//$query = $query->group(['fcd.files_main_data_id', 'fcd.document_type_mst_id']);
		return $query;
		
	}
	
	public function updateCheckInData($documentId,$DocumentReceived, $fmdId, $documentTypeHidden=null)
	{
	 
		if($documentTypeHidden == null) $documentTypeHidden = $documentId;
		$documentTypeHidden = explode(',',$documentTypeHidden);
		$query = $this->find('all')->where(['RecId'=>$fmdId, 'TransactionType IN'=>$documentTypeHidden])->select(['Id']);
 
		$results = $query->disableHydration()->all()->toArray(); // expected only one record
	 
		// expected one record
		$checkInData =  [
							'TransactionType' => $documentId,
							'DocumentReceived' => $DocumentReceived,
							'CheckInProcessingDate' => date("Y-m-d"),
							'CheckInProcessingTime' => date("H:i:s")
						];
 
		if(!empty($results)){

			foreach($results as $result){
				// update by check in Id
				$this->updateAll($checkInData, ['Id' =>$result['Id']]);
			}
		}

		return true;
	}


    // call from record listing page // here call behavior function 
    public function searchByFileMainIdDocType($filemainDataId, $fileDocType, $partnerMapFields){
        $results= [];
        $this->setAlias('fcd');
        $fieldsSearch = ['dtm.Title','cpm.cm_comp_name','fcd.Id', 'fcd.TransactionType','fcd.DocumentReceived', 'fcd.CheckInProcessingDate', 'fcd.CheckInProcessingTime'];
        
        $headerQueryFld = $this->setHeaderQueryFld($partnerMapFields);
        
        $fieldsSearch = array_filter(array_merge($fieldsSearch, $headerQueryFld['querymapfields']));
            $where = ['fcd.RecId IN '=>$filemainDataId, 'fcd.TransactionType IN '=>$fileDocType];
        $this->setAlias('fcd');	
        $query =  $this->setQuery($where, $fieldsSearch);
            
        
        // add conditional Join Query
        
        $query = $this->getOtherTableJoin($query, $headerQueryFld['tableFldCount'],null,null,null,['files_checkin_data'.ARCHIVE_PREFIX]);
        
        $rowData = $query->all()->toArray();
        
        $listRecord = $this->setListRecords($rowData,$headerQueryFld['headerParams']);
        
        return ['records'=>$listRecord, 'headerParams'=>$headerQueryFld['headerParams']];
        
    }

    
	public function setQuery($where, $fieldsSearch){
		$this->setAlias('fcd');
		 $query = $this->find()
					->where($where)
					->select($fieldsSearch)
					->join([
						'table' => 'files_main_data'.ARCHIVE_PREFIX,
						'alias' => 'fmd',
						'type' => 'LEFT',
						'conditions' => 'fcd.RecId = fmd.Id'
					])
					->join([
						'table' => 'document_type_mst',
						'alias' => 'dtm',
						'type' => 'LEFT',
						'conditions' => 'fcd.TransactionType = dtm.Id'
					])
					->join([
						'table' => 'company_mst',
						'alias' => 'cpm',
						'type' => 'LEFT',
						'conditions' => 'fmd.company_id = cpm.cm_id'
					])->distinct('fcd.Id');
		return $query;
	}

	
	public function updateDocumentStatus($documentStatus, $checkinId)
	{ 
		$this->updateAll(['DocumentReceived'=>$documentStatus], ['Id' =>$checkinId]);
		return true;
	}
	 
	
	public function getCheckInData($fmdId, $doctype = ''){
		
		$query = $this->find()
		->where(['RecId'=>$fmdId])
		->select(['Id','DocumentReceived','CheckInProcessingDate','search_status']);
		
		if(!empty($doctype)) $query = $query->where(['TransactionType'=> $doctype]);
		
		$results = $query->disableHydration()->toArray();
		if(!empty($results)) return $results[0];
	}
	
	
	// call for delete checkin Records
	public function countByFileId($fmdId){
		$results = 0;
		$query = $this->find()->where(['RecId'=>$fmdId, 'TransactionType IS NOT'=>null]);
		$results = $query->all()->count();
		return $results;
	}

	public function sqlDataInsertByForm($rowData,$currentUserId,$cmFileEnabled,$NATFileNumber){
		if($NATFileNumber != null)
		$rowData['NATFileNumber']=$NATFileNumber;
	
		$rowData['FileStartDate']=  date("Y-m-d H:i:s",strtotime($rowData['FileStartDate']));
		$rowData['UserId']=$currentUserId;
		$rowData['DateAdded']=date("Y-m-d H:i:s");
		$rowData['ECapable']=$cmFileEnabled; //$CountyTitle[cm_file_enabled]
		$rowData['TransactionType']=$rowData['TransactionType'];
		//array_push($rowData,['document_type_mst_id'=>$rowData['TransactionType']]); 

		if(isset($rowData['saveBtn'])) unset($rowData['saveBtn']);
		if(isset($rowData['saveOpenBtn'])) unset($rowData['saveOpenBtn']);

		unset($rowData['TransactionType']);
		if(isset($rowData['fmd_id'])) unset($rowData['fmd_id']);
		
		return $rowData;
	}
	
	public function checkCountByFileIdDoctype($fmdId, $doctype){
		$results = 0;
		$query = $this->find()->where(['RecId'=>$fmdId, 'TransactionType'=>$doctype]);
		$results = $query->all()->count();
		return $results;
	}

 
	 // update FMD table for lock status  
	 public function updateLockRecord($fcdId, $lock_status){  
		$filesRecData = $this->get($fcdId);  
		$filesRecData = $this->patchEntity($filesRecData, ['lock_status'=>$lock_status],['validate' => false]); 
		if ($this->save($filesRecData)) {
          return  ['RecId' => $filesRecData->RecId, 'TransactionType' =>$filesRecData->TransactionType];
		}else 
            return false;
    }
    
 
	public function updateRejected($filesMainId, $documentTypeId, $status) {

		if($status != 'OK') {
			$rejected = 1;
		} else {
			$rejected = 0;
		}
		$this->updateAll(['rejected'=>$rejected], ['RecId' =>$filesMainId, 'TransactionType' => $documentTypeId]);
		return true;

	}


	public function getCheckInDataCSC($fmdId, $doctype = ''){
		
		$query = $this->find()
		->where(['RecId'=>$fmdId])
		->select(['Id','RecId','TransactionType','DocumentReceived','CheckInProcessingDate']);
		
		if(!empty($doctype)) $query = $query->where(['TransactionType'=> $doctype]);
		
		$results = $query->disableHydration()->toArray();
		return $results;
	}

	public function updateFCDByFmdDoc($fmdId, $docId, array $data)
	{ 
		$result  = $this->updateAll($data, ['RecId'=>$fmdId, 'TransactionType'=>$docId]);
		if($result)
			return true;
		else
			return false;
	}



		

	//, 'year(fcd.CheckInProcessingDate)'=>$year
	public function executiveCheckInData($where){
		$this->setAlias('fcd');
		$where = array_merge($where,['fcd.DocumentReceived '=>'Y']);
		$query = $this->find()
				->where($where)
				->join(['table' => 'files_main_data'.ARCHIVE_PREFIX,
									'alias' => 'fmd',
									'type' => 'LEFT',
									'conditions' => ['fcd.RecId = fmd.Id']])
				->select(['fcd.Id','fcd.CheckInProcessingDate','fcd.CheckInProcessingTime']);

		$results = $query->disableHydration()->All()->toArray();

		return $results;
	}

	// same as executiveRejectReportQuery in filemaindata model
	//, 'year(fcd.CheckInProcessingDate)'=>$year
	public function executiveCheckInQCData($where, $callType='STATUS'){

		$this->setAlias('fcd');
		if($callType == 'STATUS'){
			$where = array_merge($where, ['fqcd.SentToPartner !='=>'1',  'fqcd.Status NOT IN' => ['OK','']]);	 //'OR'=>['fqcd.Status != ' => 'OK', 'fqcd.Status IS NOT' => NULL]
		}/* if($callType == 'CRN'){
			$where = array_merge($where, ['fqcd.SentToPartner !='=>'1','fqcd.CRNStatus NOT IN' => ['OK','']]);
		}if($callType == 'STATUS_CRN'){
			$where = array_merge($where, ['fqcd.SentToPartner !='=>'1','OR'=>['fqcd.Status NOT IN' => ['OK',''], 'fqcd.CRNStatus NOT IN' => ['OK','']]]);
		} */
		
		$query = $this->find()
				->where($where)
				->join(['table' => 'files_main_data'.ARCHIVE_PREFIX,
									'alias' => 'fmd',
									'type' => 'LEFT',
									'conditions' => ['fcd.RecId = fmd.Id']])
				->join(['table' => 'files_qc_data'.ARCHIVE_PREFIX,
									'alias' => 'fqcd',
									'type' => 'LEFT OUTER',
									'conditions' => ['fqcd.RecId = fcd.RecId','fqcd.TransactionType = fcd.TransactionType']])
				->select(['fcd.Id','fcd.CheckInProcessingDate','fcd.CheckInProcessingTime'])->disableHydration(false);

		$results = $query->All()->toArray();
		return $results;
	}

	// check for multiple Doc
	//$recIdname pass from checkin record Edit
	public function getMainDataByMultiDocType($ClientFlNocolno,  $doctype, $recIdname="PartnerFileNumber"){
		$results= [];
	 
		$this->setAlias('fcd');
		$query = $this->find('all')
					->where(['fmd.'.$recIdname =>$ClientFlNocolno, 'fcd.TransactionType'=>$doctype])
					->join([
						'table' => 'files_main_data'.ARCHIVE_PREFIX,
						'alias' => 'fmd',
						'type' => 'LEFT',
						'conditions' => 'fcd.RecId = fmd.Id'
					])->join([
						'table' => 'files_qc_data'.ARCHIVE_PREFIX,
						'alias' => 'fqcd',
						'type' => 'LEFT',
						'conditions' => ['fcd.RecId = fqcd.RecId', 'fcd.TransactionType = fqcd.TransactionType']
					])->select(['fmd.Id','fcd.TransactionType', 'fqcd.Id','fqcd.Status']);
 
		$results = $query->disableHydration()->first();
	 
		$setFlag = 0; $qcid=$RecId='';
		// not in array 
		if(!empty($results))
		{
			if(!in_array($results['fqcd']['Status'], ['', 'OK'])){
				$ext = 0; 
				$setFlag = 1;
				$qcid=$results['fqcd']['Id'];
				$RecId=$results['fmd']['Id'];
			}else{
				$ext = 1;
			}
		}else{$ext = 0;}
		 
		return ['ext'=>$ext, 'setFlag'=>$setFlag, 'RecId'=>$RecId, 'qcid'=>$qcid]; 
		
	}


	//update existing record ( with checkingDATA date time, change Y)  
 
}
