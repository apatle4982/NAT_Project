<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PublicNotesCoversheet Model
 *
 * @method \App\Model\Entity\PublicNotesCoversheet newEmptyEntity()
 * @method \App\Model\Entity\PublicNotesCoversheet newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PublicNotesCoversheet[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PublicNotesCoversheet get($primaryKey, $options = [])
 * @method \App\Model\Entity\PublicNotesCoversheet findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PublicNotesCoversheet patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PublicNotesCoversheet[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PublicNotesCoversheet|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PublicNotesCoversheet saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PublicNotesCoversheet[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicNotesCoversheet[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicNotesCoversheet[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicNotesCoversheet[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PublicNotesCoversheetTable extends Table
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

        $this->setTable('public_notes_coversheet');
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
        /* $validator
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
            ->allowEmptyString('body'); */

        return $validator;
    }
}
