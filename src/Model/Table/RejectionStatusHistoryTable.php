<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RejectionStatusHistory Model
 *
 * @method \App\Model\Entity\RejectionStatusHistory newEmptyEntity()
 * @method \App\Model\Entity\RejectionStatusHistory newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\RejectionStatusHistory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RejectionStatusHistory get($primaryKey, $options = [])
 * @method \App\Model\Entity\RejectionStatusHistory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\RejectionStatusHistory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RejectionStatusHistory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RejectionStatusHistory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RejectionStatusHistory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RejectionStatusHistory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RejectionStatusHistory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\RejectionStatusHistory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RejectionStatusHistory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class RejectionStatusHistoryTable extends Table
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

        $this->setTable('rejection_status_history');
        $this->setDisplayField('Id');
        $this->setPrimaryKey('Id');
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
            ->scalar('Type')
            ->maxLength('Type', 10)
            ->allowEmptyString('Type');

        $validator
            ->scalar('RejectionReasonStatus')
            ->notEmptyString('RejectionReasonStatus');

        $validator
            ->scalar('StatusNote')
            ->requirePresence('StatusNote', 'create')
            ->notEmptyString('StatusNote');

        $validator
            ->scalar('StatusReason')
            ->allowEmptyString('StatusReason');

        $validator
            ->dateTime('LastModified')
            ->allowEmptyDateTime('LastModified');

        $validator
            ->dateTime('DateCreated')
            ->allowEmptyDateTime('DateCreated');

        $validator
            ->scalar('ClearanceNote')
            ->allowEmptyString('ClearanceNote'); */

        return $validator;
    }


    
	public function rejectionHistoryData($recordMainId,$doctype){
		$search =[ 				
					"rshId" => "RejectionStatusHistory.Id", 
					"Type" => "RejectionStatusHistory.Type", 
					"StatusNote" => "RejectionStatusHistory.StatusNote",
					"StatusReason" => "RejectionStatusHistory.StatusReason",
					"LastModified" => "RejectionStatusHistory.LastModified",
					"ClearanceNote" => "RejectionStatusHistory.ClearanceNote"
					
				];
		
		$result  = $this->find()->select($search)
						->where(['RejectionStatusHistory.RecId'=>$recordMainId, 'RejectionStatusHistory.TransactionType'=>$doctype])
						->order(['rshId'=>'DESC'])
						->All()
						->toArray();
	
		return $result;
	}

    public function saveRSHData(array $postData){
		$filesRSHData = $this->newEmptyEntity();
		  
		$dataRSH['RecId'] = $postData['fmdId'];
		$dataRSH['TransactionType'] = $postData['docTypeId'];
		$dataRSH['Type'] = $postData['Status'];	
		 
        $dataRSH['StatusNote'] = (!empty($postData['TrackingNo4RR']) ? $postData['TrackingNo4RR'] : "");
        $dataRSH['StatusReason'] = (!empty($postData['RejectionReason']) ? $postData['RejectionReason'] : "");
         
		$dataRSH['LastModified'] = date("Y-m-d H:i:s");	
		$dataRSH['DateCreated'] = date("Y-m-d H:i:s");	
 		$filesRSHData = $this->patchEntity($filesRSHData, $dataRSH,['validate' => false]);
		
		if($this->save($filesRSHData)) {
			return true;  
		}
		else 
			return false;
	}

    public function updateAllRSHData(array $ids, $ClearanceNote='')
	{
		$dataRSH = [];
		$ids = array_filter($ids); // remove empty value
		// expected one record
		$dataRSH['RejectionReasonStatus'] = 'Cleared';
		$dataRSH['ClearanceNote'] = $ClearanceNote;
		$dataRSH['LastModified'] = date("Y-m-d H:i:s");
		
		if($this->updateAll($dataRSH,['Id IN' => $ids]))
			return true;
		else 
			return false;
		
	}
	
}
