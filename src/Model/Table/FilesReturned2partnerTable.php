<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


/**
 * FilesReturned2partner Model
 *
 * @method \App\Model\Entity\FilesReturned2partner newEmptyEntity()
 * @method \App\Model\Entity\FilesReturned2partner newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FilesReturned2partner[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FilesReturned2partner get($primaryKey, $options = [])
 * @method \App\Model\Entity\FilesReturned2partner findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FilesReturned2partner patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FilesReturned2partner[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FilesReturned2partner|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesReturned2partner saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesReturned2partner[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesReturned2partner[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesReturned2partner[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesReturned2partner[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
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
        $this->setDisplayField('Id');
        $this->setPrimaryKey('Id');

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

        $this->addBehavior('CustomLRS');
        // add in plugin
        $this->addBehavior('Search.Search'); 

         // Setup search filter using search manager
         $this->searchManagerConfig();
    }

    public function searchManagerConfig()
    {
        $search = $this->searchManager();
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
            ->integer('RecId')
            ->requirePresence('RecId', 'create')
            ->notEmptyString('RecId');

        $validator
            ->integer('TransactionType')
            ->requirePresence('TransactionType', 'create')
            ->notEmptyString('TransactionType');

        $validator
            ->scalar('CarrierName')
            ->maxLength('CarrierName', 100)
            ->requirePresence('CarrierName', 'create')
            ->notEmptyString('CarrierName');

        $validator
            ->scalar('CarrierTrackingNo')
            ->maxLength('CarrierTrackingNo', 100)
            ->requirePresence('CarrierTrackingNo', 'create')
            ->notEmptyString('CarrierTrackingNo');

        $validator
            ->integer('UserId')
            ->requirePresence('UserId', 'create')
            ->notEmptyString('UserId');

        $validator
            ->date('RTPProcessingDate')
            ->allowEmptyDate('RTPProcessingDate');

        $validator
            ->time('RTPProcessingTime')
            ->requirePresence('RTPProcessingTime', 'create')
            ->notEmptyTime('RTPProcessingTime');

        $validator
            ->scalar('dateDelivered')
            ->maxLength('dateDelivered', 100)
            ->allowEmptyString('dateDelivered');

        $validator
            ->scalar('receipient')
            ->maxLength('receipient', 100)
            ->allowEmptyString('receipient');

        $validator
            ->scalar('deliveredTo')
            ->maxLength('deliveredTo', 100)
            ->allowEmptyString('deliveredTo');

        $validator
            ->scalar('receivedBy')
            ->maxLength('receivedBy', 100)
            ->allowEmptyString('receivedBy'); */

        return $validator;
    }
    
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


    // run custome query
    /* public function returnToPartnerNew()
    {   //$use Cake\Datasource\ConnectionManager; 
		$db = ConnectionManager::get("default");
		$result = $db->execute("SELECT * FROM files_returned2partner ORDER by Id desc limit 10")
		 ->fetchAll('assoc');
        return $result;
	} */
 
}
