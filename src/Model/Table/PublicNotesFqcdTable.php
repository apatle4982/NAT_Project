<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PublicNotesFqcd Model
 *
 * @method \App\Model\Entity\PublicNotesFqcd newEmptyEntity()
 * @method \App\Model\Entity\PublicNotesFqcd newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PublicNotesFqcd[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PublicNotesFqcd get($primaryKey, $options = [])
 * @method \App\Model\Entity\PublicNotesFqcd findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PublicNotesFqcd patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PublicNotesFqcd[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PublicNotesFqcd|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PublicNotesFqcd saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PublicNotesFqcd[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicNotesFqcd[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicNotesFqcd[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicNotesFqcd[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PublicNotesFqcdTable extends Table
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

        $this->setTable('public_notes_fqcd');
        $this->setDisplayField('Id');
        $this->setPrimaryKey('Id');
        $this->belongsTo('Users', [
            'foreignKey' => 'UserId',
            'joinType' => 'INNER'
        ]);
		
		$this->addBehavior('Search.Search');
        $this->searchManagerConfig();
    }
   


    public function searchManagerConfig() 
    {
        $search = $this->searchManager();
		$search->like('Regarding');
		$search->like('Type');
		$search->like('Section');
		$search->like('Public_Internal');
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
            ->integer('Id')
            ->requirePresence('Id', 'create')
            ->notEmptyString('Id');

        $validator
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
            ->scalar('Regarding')
            ->requirePresence('Regarding', 'create')
            ->notEmptyString('Regarding');

        $validator
            ->scalar('Type')
            ->maxLength('Type', 100)
            ->requirePresence('Type', 'create')
            ->notEmptyString('Type');

        $validator
            ->scalar('Section')
            ->maxLength('Section', 100)
            ->requirePresence('Section', 'create')
            ->notEmptyString('Section');

        $validator
            ->date('AddingDate')
            ->requirePresence('AddingDate', 'create')
            ->notEmptyDate('AddingDate');

        $validator
            ->time('AddingTime')
            ->requirePresence('AddingTime', 'create')
            ->notEmptyTime('AddingTime');

        $validator
            ->scalar('Public_Internal')
            ->maxLength('Public_Internal', 1)
            ->requirePresence('Public_Internal', 'create')
            ->notEmptyString('Public_Internal');

        $validator
            ->scalar('subject')
            ->maxLength('subject', 250)
            ->allowEmptyString('subject');

        $validator
            ->scalar('body')
            ->allowEmptyString('body');
 */
        return $validator;
    }
}
