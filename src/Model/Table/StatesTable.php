<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * States Model
 *
 * @method \App\Model\Entity\State newEmptyEntity()
 * @method \App\Model\Entity\State newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\State[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\State get($primaryKey, $options = [])
 * @method \App\Model\Entity\State findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\State patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\State[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\State|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\State saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\State[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\State[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\State[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\State[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class StatesTable extends Table
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

        $this->setTable('States');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('CountyMst', [
            'foreignKey' => 'cm_State'
        ]);
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
            ->scalar('State_code')
            ->maxLength('State_code', 5)
            ->allowEmptyString('State_code');

        $validator
            ->scalar('State_name')
            ->maxLength('State_name', 255)
            ->allowEmptyString('State_name');

        $validator
            ->scalar('country_code')
            ->maxLength('country_code', 255)
            ->requirePresence('country_code', 'create')
            ->notEmptyString('country_code');

        return $validator;
    }


    public function StateListArray(){
				
		return $this->find('list', [
					'keyField' =>  'State_code',
					'valueField' => function ($row) {
									return $row['State_code'] . ' : ' . $row['State_name'];
								} 
				])
				->order(['State_code ' => 'ASC']);
		
	}  


    public function StateListWithCodeArray(){
				
		return $this->find('list', [
					'keyField' => function ($row) {
                        return $row['id'] . '_' . $row['State_code'];
                    } ,
					'valueField' => function ($row) {
									return $row['State_code'] . ' : ' . $row['State_name'];
								} 
				])
				->order(['State_code ' => 'ASC']);
		
	}
	public function StateListWithIdArray(){
				
		return $this->find('list', [
					'keyField' => 'id',
					'valueField' => function ($row) {
									return $row['State_code'] . ' : ' . $row['State_name'];
								}
				])
				->order(['State_code ' => 'ASC']);
		
	}
}
