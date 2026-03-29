<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ApplicableForms Model
 *
 * @method \App\Model\Entity\ApplicableForm newEmptyEntity()
 * @method \App\Model\Entity\ApplicableForm newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ApplicableForm[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ApplicableForm get($primaryKey, $options = [])
 * @method \App\Model\Entity\ApplicableForm findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ApplicableForm patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ApplicableForm[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ApplicableForm|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ApplicableForm saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ApplicableForm[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ApplicableForm[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ApplicableForm[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ApplicableForm[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ApplicableFormsTable extends Table
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

        $this->setTable('applicable_forms');
        $this->setDisplayField('af_id');
        $this->setPrimaryKey('af_id');

        $this->belongsTo('CountyMst', [
            'foreignKey' => 'cm_id'
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
       /*  $validator
            ->scalar('af_title')
            ->maxLength('af_title', 250)
            ->requirePresence('af_title', 'create')
            ->notEmptyString('af_title');

        $validator
            ->integer('af_County_id')
            ->requirePresence('af_County_id', 'create')
            ->notEmptyString('af_County_id');

        $validator
            ->scalar('af_url')
            ->maxLength('af_url', 250)
            ->requirePresence('af_url', 'create')
            ->notEmptyString('af_url'); */

        return $validator;
    }
}
