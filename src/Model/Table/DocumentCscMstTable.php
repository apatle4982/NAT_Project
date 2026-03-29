<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentCscMst Model
 *
 * @property \App\Model\Table\StatesTable&\Cake\ORM\Association\BelongsTo $States
 *
 * @method \App\Model\Entity\DocumentCscMst newEmptyEntity()
 * @method \App\Model\Entity\DocumentCscMst newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentCscMst[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentCscMst get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentCscMst findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\DocumentCscMst patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentCscMst[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentCscMst|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentCscMst saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentCscMst[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DocumentCscMst[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\DocumentCscMst[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DocumentCscMst[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class DocumentCscMstTable extends Table
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

        $this->setTable('document_csc_mst');
        $this->setDisplayField('Id');
        $this->setPrimaryKey('Id');

        $this->belongsTo('States', [
            'foreignKey' => 'State_code',
			'bindingKey' => 'State_code',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('CountyMst', [
            'foreignKey' => 'County_id',
            'joinType' => 'LEFT'
        ]);
		$this->belongsTo('DocumentTypeMst', [
            'foreignKey' => 'document_type_id',
            'joinType' => 'LEFT'
        ]);
		
		$this->addBehavior('Search.Search');
		
		// Setup search filter using search manager
        $this->searchManagerConfig();
    }
	public function searchManagerConfig()
    {
        $search = $this->searchManager(); 
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
			->scalar('State_code')
            ->maxLength('State_code', 11)
            ->allowEmptyString('State_code');

        $validator
            ->integer('County_id')
            ->allowEmptyString('County_id');

        $validator
            ->integer('document_type_id')
            ->allowEmptyString('document_type_id');

        $validator
            ->scalar('document_type_name')
            ->maxLength('document_type_name', 100)
            ->allowEmptyString('document_type_name');

        $validator
            ->notEmptyString('is_active');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        //$rules->add($rules->existsIn('State_id', 'States'), ['errorField' => 'State_id']);

        return $rules;
    }
	
	public function documentCSCTypeListing(){
		return $this->find('list', [
			'keyField' => 'Id',
			'valueField' => 'document_type_name'
		])->toArray();
	}
}
