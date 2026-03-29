<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FieldSections Model
 *
 * @method \App\Model\Entity\FieldSection newEmptyEntity()
 * @method \App\Model\Entity\FieldSection newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FieldSection[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FieldSection get($primaryKey, $options = [])
 * @method \App\Model\Entity\FieldSection findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FieldSection patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FieldSection[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FieldSection|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FieldSection saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FieldSection[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FieldSection[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FieldSection[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FieldSection[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FieldSectionsTable extends Table
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

        $this->setTable('field_sections');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

       
        $this->hasMany('FieldsMst', [
            'foreignKey' => 'field_sections_id',
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
        /* $validator
            ->scalar('section_name')
            ->maxLength('section_name', 250)
            ->allowEmptyString('section_name');

        $validator
            ->scalar('field_tblname')
            ->maxLength('field_tblname', 255)
            ->allowEmptyString('field_tblname');

        $validator
            ->notEmptyString('set_order'); */

        return $validator;
    }

  /*   public function getFieldSectionData(){
       return $this->find('all')->disableHydration()->contain(['FieldsMst'=>[ 'sort' => ['FieldsMst.fm_sortorder' => 'ASC'] ]])->toArray();
    } */
}
