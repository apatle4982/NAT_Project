<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FilesReturned2partner Model
 *
 * @property \App\Model\Table\FilesMainDataTable|\Cake\ORM\Association\BelongsTo $FilesMainData
 * @property \App\Model\Table\DocumentTypeMstsTable|\Cake\ORM\Association\BelongsTo $DocumentTypeMst
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\FilesReturned2partner get($primaryKey, $options = [])
 * @method \App\Model\Entity\FilesReturned2partner newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FilesReturned2partner[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FilesReturned2partner|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesReturned2partner patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FilesReturned2partner[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FilesReturned2partner findOrCreate($search, callable $callback = null, $options = [])
 */
class FilesReturned2partnerTable extends Table
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

        $this->setTable('files_returned2partner'.ARCHIVE_PREFIX);
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
		
		$this->addBehavior('Search.Search');	
		$this->addBehavior('CustomLRS');
		
        $this->belongsTo('FilesMainData', [
            'foreignKey' => 'RecId',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('DocumentTypeMst', [
            'foreignKey' => 'TransactionType',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'UsersId',
            'joinType' => 'INNER'
        ]);
    }

	public function searchConfiguration()
    {
        $search = new Manager($this);
		$search->like('Id');
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
        /* $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('CarrierName', 'create')
            ->notEmpty('CarrierName');

        $validator
            ->requirePresence('CarrierTrackingNo', 'create')
            ->notEmpty('CarrierTrackingNo');

        $validator
            ->date('RTPProcessingDate')
            ->allowEmpty('RTPProcessingDate');

        $validator
            ->time('RTPProcessingTime')
            ->requirePresence('RTPProcessingTime', 'create')
            ->notEmpty('RTPProcessingTime');
 */
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    /* public function buildRules(RulesChecker $rules): rules 
    {
        $rules->add($rules->existsIn(['RecId'], 'FilesMainData'));
        $rules->add($rules->existsIn(['TransactionType'], 'DocumentTypeMst'));
        $rules->add($rules->existsIn(['UsersId'], 'Users'));

        return $rules;
    }
	 */
	
	
	public function getR2PData($fmdId, $doctype){
		
		$query = $this->find()
		->where(['RecId'=>$fmdId, 'TransactionType'=>$doctype])
		/* ->select(['Status', 'TrackingNo4RR', 'CRNStatus', 'CRNTrackingNo4RR', 'LastModified', 'LastModified', 'QCProcessingDate']) */
		->disableHydration();

		$results = $query->toArray();
		 if(!empty($results)) return $results[0];
	}
	
	public function getR2PEditData($fmdId, $doctype){
		
		$query = $this->find()
		->where(['RecId'=>$fmdId, 'TransactionType'=>$doctype])
		->select(['Id', 'CarrierName', 'CarrierTrackingNo', 'RTPProcessingDate', 'RTPProcessingTime']);

		$results = $query->toArray();
		 if(!empty($results)) return $results[0];
	}
	
	public function saveR2PData(array $data){
		
		$filesR2PData = $this->newEmptyEntity();
		$filesR2PData = $this->patchEntity($filesR2PData, $data,['validate' => false]);
		if($this->save($filesR2PData)) 
			return true; //$filesR2PData->id;
		else 
			return false;
	}
	
	public function updateR2PData($id, array $data)
	{
		$filesR2PData = $this->get($id);
		// expected one record
		$filesR2PData = $this->patchEntity($filesR2PData, $data,['validate' => false]);
		
		if ($this->save($filesR2PData))
			return true;
		else 
			return false;
	}
	
}
