<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FilesAccountingDataHistory Model
 *
 * @method \App\Model\Entity\FilesAccountingDataHistory newEmptyEntity()
 * @method \App\Model\Entity\FilesAccountingDataHistory newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FilesAccountingDataHistory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FilesAccountingDataHistory get($primaryKey, $options = [])
 * @method \App\Model\Entity\FilesAccountingDataHistory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FilesAccountingDataHistory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FilesAccountingDataHistory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FilesAccountingDataHistory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesAccountingDataHistory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesAccountingDataHistory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesAccountingDataHistory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesAccountingDataHistory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesAccountingDataHistory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FilesAccountingDataHistoryTable extends Table
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

        $this->setTable('files_accounting_data_history');
        $this->setDisplayField('Id');
        $this->setPrimaryKey('Id');

        $this->addBehavior('Timestamp');
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
            ->integer('UserId')
            ->requirePresence('UserId', 'create')
            ->notEmptyString('UserId');

        $validator
            ->scalar('serialized_data')
            ->allowEmptyString('serialized_data'); */

        return $validator;
    }

    public function addAccountingHistory($filesMainId, $documentTypeId, $UserId, array $postedData){
		
        $data['serialized_data'] = serialize($postedData);
		$data['RecId'] = $filesMainId;
		$data['TransactionType'] =$documentTypeId; 
		$data['UserId'] = $UserId;
        $data['created'] = date("H:i:s");
         
		$filesAccountingHistory = $this->newEmptyEntity();
		$filesAccountingHistory = $this->patchEntity($filesAccountingHistory, $data,['validate' => false]);
		if($this->save($filesAccountingHistory)) 
			return true;
		else 
			return false;
	}

    public function accoutHistoryData($recordMainId,$doctype){
		$search =[ 				
					"Id" => "FilesAccountingDataHistory.Id", 
					"serialized_data" => "FilesAccountingDataHistory.serialized_data",  
					"created" => "FilesAccountingDataHistory.created"
					
				];
		
		$result  = $this->find()->select($search)
						->where(['FilesAccountingDataHistory.RecId'=>$recordMainId, 'FilesAccountingDataHistory.TransactionType'=>$doctype])
						->order(['Id'=>'DESC'])
						->All()
						->toArray();
	
		return $result;
	}
    

}
