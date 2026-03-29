<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CountyMst Model
 *
 * @method \App\Model\Entity\CountyMst newEmptyEntity()
 * @method \App\Model\Entity\CountyMst newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CountyMst[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CountyMst get($primaryKey, $options = [])
 * @method \App\Model\Entity\CountyMst findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CountyMst patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CountyMst[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CountyMst|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CountyMst saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CountyMst[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CountyMst[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CountyMst[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CountyMst[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CountyMstTable extends Table
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

        $this->setTable('County_mst');
        $this->setDisplayField('cm_id');
        $this->setPrimaryKey('cm_id');
        
        $this->hasMany('States', [
            'foreignKey' => 'State_code',
			 'joinType' => 'INNER'
        ]);
        $this->addBehavior('Search.Search');
		$this->addBehavior('CustomLRS');

         // Setup search filter using search manager
         $this->searchManagerConfig();
    }


    public function searchManagerConfig()
    {
        $search = $this->searchManager();
        $search->like('cm_State');
		$search->like('cm_title');
		$search->like('cm_vendor_class_id');
        $search->like('cm_code');
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
        $validator
            ->scalar('cm_title')
            ->maxLength('cm_title', 250)
            ->requirePresence('cm_title', 'create')
            ->notEmptyString('cm_title');

       /*  $validator
            ->scalar('cm_vendor_class_id')
            ->maxLength('cm_vendor_class_id', 100)
            ->allowEmptyString('cm_vendor_class_id'); */

        /* $validator
            ->scalar('cm_code')
            ->maxLength('cm_code', 250)
            ->allowEmptyString('cm_code'); */

        $validator
            ->scalar('cm_State')
            ->maxLength('cm_State', 50)
            ->requirePresence('cm_State', 'create')
            ->notEmptyString('cm_State');

       /*  $validator
            ->scalar('cm_township_division')
            ->maxLength('cm_township_division', 250)
            ->allowEmptyString('cm_township_division');

        $validator
            ->scalar('cm_department_office')
            ->maxLength('cm_department_office', 250)
            ->allowEmptyString('cm_department_office');

        $validator
            ->scalar('cm_address1')
            ->allowEmptyString('cm_address1');

        $validator
            ->scalar('cm_address2')
            ->allowEmptyString('cm_address2');

        $validator
            ->scalar('cm_City')
            ->maxLength('cm_City', 50)
            ->allowEmptyString('cm_City');

        $validator
            ->scalar('cm_zip')
            ->maxLength('cm_zip', 10)
            ->allowEmptyString('cm_zip');

        $validator
            ->scalar('cm_phone')
            ->maxLength('cm_phone', 20)
            ->allowEmptyString('cm_phone');

        $validator
            ->scalar('cm_payable')
            ->allowEmptyString('cm_payable');

        $validator
            ->scalar('cm_file_enabled')
            ->maxLength('cm_file_enabled', 1)
            ->allowEmptyFile('cm_file_enabled');

        $validator
            ->scalar('cm_all_doc_type')
            ->maxLength('cm_all_doc_type', 1)
            ->allowEmptyString('cm_all_doc_type');

        $validator
            ->scalar('cm_limited_doc_type')
            ->maxLength('cm_limited_doc_type', 1)
            ->allowEmptyString('cm_limited_doc_type');

        $validator
            ->scalar('cm_recording_information_avail')
            ->maxLength('cm_recording_information_avail', 1)
            ->allowEmptyString('cm_recording_information_avail');

        $validator
            ->scalar('cm_link')
            ->maxLength('cm_link', 250)
            ->allowEmptyString('cm_link');

        $validator
            ->scalar('cm_user_name')
            ->maxLength('cm_user_name', 50)
            ->allowEmptyString('cm_user_name');

        $validator
            ->scalar('cm_password')
            ->maxLength('cm_password', 250)
            ->allowEmptyString('cm_password');

        $validator
            ->scalar('cm_original_password')
            ->maxLength('cm_original_password', 250)
            ->allowEmptyString('cm_original_password');

        $validator
            ->scalar('cm_doc')
            ->allowEmptyString('cm_doc');

        $validator
            ->scalar('cm_County_info')
            ->allowEmptyString('cm_County_info');

        $validator
            ->scalar('cm_State_reg')
            ->allowEmptyString('cm_State_reg');

        $validator
            ->date('date_created')
            ->requirePresence('date_created', 'create')
            ->notEmptyDate('date_created');

        $validator
            ->date('date_modified')
            ->requirePresence('date_modified', 'create')
            ->notEmptyDate('date_modified');

        $validator
            ->scalar('cm_status')
            ->maxLength('cm_status', 1)
            ->notEmptyString('cm_status');

        $validator
            ->scalar('cm_vendor_id')
            ->maxLength('cm_vendor_id', 50)
            ->allowEmptyString('cm_vendor_id');

        $validator
            ->scalar('cm_contact_name')
            ->maxLength('cm_contact_name', 250)
            ->allowEmptyString('cm_contact_name');

        $validator
            ->scalar('cm_no_in_av_ol_web')
            ->maxLength('cm_no_in_av_ol_web', 1)
            ->allowEmptyString('cm_no_in_av_ol_web');

        $validator
            ->scalar('cm_op_rd_in_im_av_no_ch')
            ->maxLength('cm_op_rd_in_im_av_no_ch', 1)
            ->allowEmptyString('cm_op_rd_in_im_av_no_ch');

        $validator
            ->scalar('cm_op_rd_in_av_no_in')
            ->maxLength('cm_op_rd_in_av_no_in', 1)
            ->allowEmptyString('cm_op_rd_in_av_no_in');

        $validator
            ->scalar('cm_op_rd_in_im_av')
            ->maxLength('cm_op_rd_in_im_av', 1)
            ->allowEmptyString('cm_op_rd_in_im_av');

        $validator
            ->scalar('cm_sub_rd_in_im_av_no_ch')
            ->maxLength('cm_sub_rd_in_im_av_no_ch', 1)
            ->allowEmptyString('cm_sub_rd_in_im_av_no_ch');

        $validator
            ->scalar('cm_sub_rd_in_av_no_in')
            ->maxLength('cm_sub_rd_in_av_no_in', 1)
            ->allowEmptyString('cm_sub_rd_in_av_no_in');

        $validator
            ->scalar('cm_sub_rd_in_im_av')
            ->maxLength('cm_sub_rd_in_im_av', 1)
            ->allowEmptyString('cm_sub_rd_in_im_av');

        $validator
            ->scalar('file_avl')
            ->maxLength('file_avl', 250)
            ->requirePresence('file_avl', 'create')
            ->notEmptyFile('file_avl');

        $validator
            ->scalar('rec_info_avl')
            ->maxLength('rec_info_avl', 250)
            ->requirePresence('rec_info_avl', 'create')
            ->notEmptyString('rec_info_avl');

        $validator
            ->scalar('rec_info_main')
            ->maxLength('rec_info_main', 1)
            ->notEmptyString('rec_info_main');

        $validator
            ->scalar('sub_info_main')
            ->maxLength('sub_info_main', 1)
            ->notEmptyString('sub_info_main');
 */
        return $validator;
    }
 
    public function StateListArray(){
				
		return $this->find('list', [
					'keyField' => 'cm_State',
					'valueField' => 'cm_State'
				])
				->order(['cm_State ' => 'ASC']);
		
	}
 
	public function getCountyTitle(array $wherefld){
		$query = $this->find()
						->where($wherefld)
						->select(['cm_title','cm_file_enabled'])
						->limit(1);
		$results = $query->disableHydration()->toArray();
		 if(!empty($results)) return $results[0];
	}

    public function getCountysByStateName($Statecode=''){
		if(!empty($Statecode)){
			$query = $this->find('all')
					 ->where(['cm_State'=>$Statecode])
				 	 ->select(['cm_title'])
					 ->order(['cm_title ASC']);
		}else{
			$query = $this->find('all')
					 ->select(['cm_title'])
					 ->order(['cm_State ASC']);
		}
		$results = $query->disableHydration()->toArray();
		
		return $results;
	}
 
	public function getCountyTitleByState($cm_State=null){
		if($cm_State == null){

			return $this->find('list', [
					'keyField' => 'cm_title',
					'valueField' => 'cm_title'
				])
				->group('cm_title');
				//->order(['cm_State ASC']);
		}else{
			return $this->find('list', [
					'keyField' => 'cm_title',
					'valueField' => 'cm_title'
				])
				->where(['cm_State'=>$cm_State])
				->group('cm_title')
				->order(['cm_State ASC']);
		}
	}
    
    public function getCountyTitleByStateNew($cm_State=null){
		if($cm_State == null){

			return $this->find('list', [
					'keyField' => 'cm_title',
					'valueField' => 'cm_title'
				])
				->group('cm_title')->toArray();
				//->order(['cm_State ASC']);
		}else{
			return $this->find('list', [
					'keyField' => 'cm_title',
					'valueField' => 'cm_title'
				])
				->where(['cm_State'=>$cm_State])
				->group('cm_title')
				->order(['cm_State ASC'])->toArray();
		}
	}
	
    public function countTownshipDivision($State, $County){
		$query = $this->find()
						->where(['UPPER(cm_State)'=>strtoupper(trim($State)),'UPPER(cm_title)'=>strtoupper(trim($County))])->select(['cm_id']);
		
		$results = $query->disableHydration()->all()->count();	
			
		return $results;
	}
	
    public function listTownshipDivision($State, $County, $fmd_id){
		$results = [];	
		$query = $this->find()
				->where(['UPPER(cm_State)'=>strtoupper(trim($State)),'UPPER(cm_title)'=>strtoupper(trim($County))])
				->select(['cm_township_division']) 
				//->group('cm_title')
				->order(['cm_township_division' => 'ASC']);
		$results = $query->disableHydration()->all()->toArray();


		$listTownship='';
		$listTownship .= '<select name="fmd_township_division[]" id="townshipSelect">
							<option value="">Township/Division</option>';
							foreach($results as $result){
								$listTownship .= '<option value="'.$fmd_id.'_'.$result['cm_township_division'].'" >'.$result['cm_township_division'].'</option>';
							}
		$listTownship .= '</select>';
		
		return $listTownship;

	}

    
	public function getCountyDetails($State, $County){
		$query = $this->find()
						->where(['UPPER(cm_State)'=>strtoupper(trim($State)),'UPPER(cm_title)'=>strtoupper(trim($County))])
						->select(['cm_City','cm_zip', 'cm_payable'])
						->limit(1);
		$results = $query->disableHydration()->toArray();
		 if(!empty($results)) return $results[0];
	}
	
	public function getCountyTitleByStateCounty($State, $County){
		$query = $this->find()
						->where(['UPPER(cm_State)'=>strtoupper(trim($State)),'UPPER(cm_title)'=>strtoupper(trim($County))])
						->select(['cm_title','cm_file_enabled'])
						->limit(1);
		$results = $query->disableHydration()->toArray();
		if(!empty($results)) return $results[0];
	}

	
	public function getCountyIdByState($cm_State=null){
		if($cm_State == null){

			return $this->find('list', [
					'keyField' => 'cm_id',
					'valueField' => 'cm_title'
				])
				->group('cm_title')
				->order(['cm_State ASC']);
		}else{
			return $this->find('list', [
					'keyField' => 'cm_id',
					'valueField' => 'cm_title'
				])
				->where(['cm_State'=>$cm_State])
				->group('cm_title')
				->order(['cm_State ASC']);
		}
	}
	
	public function getCountysByStateId($Statecode=''){
		
		if(!empty($Statecode)){
			$query = $this->find('all')
					 ->where(['cm_State'=>$Statecode])
				 	 ->select(['cm_id','cm_title'])
					 ->order(['cm_State ASC']);
		}else{
			$query = $this->find('all')
					 ->select(['cm_id','cm_title'])
					 ->order(['cm_State ASC']);
		}
		
		$results = $query->disableHydration()->toArray();
		
		return $results;

	}
 
    public function fedExDetailByStateCounty($State, $County){
		$query = $this->find()
						->where(['UPPER(cm_State)'=>strtoupper(trim($State)),'UPPER(cm_title)'=>strtoupper(trim($County))])
						->select(['fedex_person_name','fedex_phone_number','fedex_company_name','fedex_address_1','fedex_address_2','fedex_City','fedex_State','fedex_postal','fedex_country_code'])
						->limit(1);
		$results = $query->disableHydration()->toArray();
		 if(!empty($results)) return $results[0];

	}


    
	
	public function turmTimeAnalysisQuery(array $whereCondition){
		
		$this->setAlias('cpm');
		$search = ['cpm.cm_State', 'cpm.cm_title', 'cpm.cm_file_enabled', 'totalTimeRec'=>'avg((UNIX_TIMESTAMP(frd.RecordingProcessingDate)+TIME_TO_SEC(frd.RecordingProcessingTime))-(UNIX_TIMESTAMP(fcd.CheckInProcessingDate)+TIME_TO_SEC(fcd.CheckInProcessingTime)))', 'cpm.cm_no_in_av_ol_web', 'cpm.rec_info_main', 'cpm.sub_info_main','fmd.company_id'];
		$query = $this->find()
					->select($search)
					->join(['table' => 'files_main_data'.ARCHIVE_PREFIX,
							'alias' => 'fmd',
							'type' => 'LEFT',
							'conditions' => ['cpm.cm_title = fmd.County', 
											'cpm.cm_State = fmd.State',
											'fmd.company_id'=>$whereCondition['fmd.company_id']
											]
							])
					->join([
						'table' => 'files_recording_data'.ARCHIVE_PREFIX,
						'alias' => 'frd',
						'type' => 'LEFT OUTER',
						'conditions' => ['frd.RecId = fmd.Id', 
										'frd.RecordingProcessingDate IS NOT' => NULL, 
										'frd.RecordingProcessingDate >' => 'fcd.CheckInProcessingDate', 'frd.RecordingProcessingDate <=' => $whereCondition['frd.RecordingProcessingDate']
										]
						])
					->join([
						'table' => 'document_type_mst',
						'alias' => 'dtm',
						'type' => 'LEFT OUTER',
						'conditions' => ['dtm.Id = frd.TransactionType']])
					->join([
						'table' => 'files_checkin_data'.ARCHIVE_PREFIX,
						'alias' => 'fcd',
						'type' => 'LEFT OUTER',
						'conditions' => ['fcd.RecId = frd.RecId',
										'fcd.TransactionType = frd.TransactionType', 
										'fcd.DocumentReceived' => 'Y', 
										'fcd.CheckInProcessingDate >=' => $whereCondition['fcd.CheckInProcessingDate']
										]
						])
					->join([
						'table' => 'files_qc_data'.ARCHIVE_PREFIX,
						'alias' => 'fqcd',
						'type' => 'LEFT OUTER',
						'conditions' =>['fqcd.RecId = frd.RecId',	
										'fqcd.TransactionType = frd.TransactionType', 
										'fqcd.Status'=>'OK'
										]
						])
					->group(['cpm.cm_title', 'cpm.cm_State'])
					->order(['cpm.cm_title'=>'asc', 'cpm.cm_State'=>'asc']);

		$query= $query->disableHydration();
	//	$result = $query->All()->toArray();  //->where($whereCondition)
		return $query;

	}
	
	public function turmTimeAnalysisR2PQuery(array $whereCondition){
	
		$this->setAlias('cpm');
		$search = ['totalTimeR2P'=>'avg((UNIX_TIMESTAMP(frtp.RTPProcessingDate)+TIME_TO_SEC(frtp.RTPProcessingTime))-(UNIX_TIMESTAMP(fcd.CheckInProcessingDate)+TIME_TO_SEC(fcd.CheckInProcessingTime)))'];
		$query = $this->find()
					->select($search)
					->join(['table' => 'files_main_data'.ARCHIVE_PREFIX,
							'alias' => 'fmd',
							'type' => 'LEFT',
							'conditions' => [
											'cpm.cm_title = fmd.County', 
											'cpm.cm_State = fmd.State', 
											'fmd.company_id'=>$whereCondition['fmd.company_id']
											]
							])
					->join([
						'table' => 'files_returned2partner'.ARCHIVE_PREFIX,
						'alias' => 'frtp',
						'type' => 'LEFT OUTER',
						'conditions' => [
										'frtp.RecId = fmd.Id', 
										'frtp.RTPProcessingDate IS NOT' => NULL, 
										'frtp.RTPProcessingDate >' => 'fcd.CheckInProcessingDate', 'frtp.RTPProcessingDate <=' => $whereCondition['frtp.RTPProcessingDate']
										]
						])
					->join([
						'table' => 'document_type_mst',
						'alias' => 'dtm',
						'type' => 'LEFT OUTER',
						'conditions' => ['dtm.Id = frtp.TransactionType']])
					->join([
						'table' => 'files_checkin_data'.ARCHIVE_PREFIX,
						'alias' => 'fcd',
						'type' => 'LEFT OUTER',
						'conditions' => [
										'fcd.RecId = frtp.RecId', 
										'fcd.TransactionType = frtp.TransactionType', 
										'fcd.DocumentReceived' => 'Y', 
										'fcd.CheckInProcessingDate >=' => $whereCondition['fcd.CheckInProcessingDate']
										]
						])
					->join([
						'table' => 'files_qc_data'.ARCHIVE_PREFIX,
						'alias' => 'fqcd',
						'type' => 'LEFT OUTER',
						'conditions' =>  [
										'fqcd.RecId = frtp.RecId', 
										'fqcd.TransactionType = frtp.TransactionType', 
										'fqcd.Status'=>'OK']
						])
					->group(['cpm.cm_title', 'cpm.cm_State'])
					->order(['cpm.cm_title'=>'asc', 'cpm.cm_State'=>'asc']);

		$query= $query->disableHydration();
		//$result = $query->All()->toArray(); //->where($whereCondition)

		return $query;
		
	}
}
