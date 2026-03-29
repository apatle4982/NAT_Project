<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ChargeMaster Model
 *
 * @method \App\Model\Entity\ChargeMaster newEmptyEntity()
 * @method \App\Model\Entity\ChargeMaster newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ChargeMaster[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ChargeMaster get($primaryKey, $options = [])
 * @method \App\Model\Entity\ChargeMaster findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ChargeMaster patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ChargeMaster[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ChargeMaster|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChargeMaster saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChargeMaster[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChargeMaster[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChargeMaster[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChargeMaster[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ChargeMasterTable extends Table
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

        $this->setTable('charge_master');
        $this->setDisplayField('cgm_id');
        $this->setPrimaryKey('cgm_id');
		
		$this->addBehavior('Search.Search');
		
		// Setup search filter using search manager
        $this->searchManagerConfig();
    }
	
	public function searchManagerConfig()
    {
        $search = $this->searchManager(); 
       
        //$search->Like('cgm_title');
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
            ->scalar('cgm_title')
			->notEmptyString('cgm_title', __('Please specify charge title'))
            ->maxLength('cgm_title', 255)
            ->requirePresence('cgm_title', 'create')
            ->notEmptyString('cgm_title');

        $validator
            ->scalar('cgm_type')
			->notEmptyString('cgm_type', __('Please specify charge type'))
            ->maxLength('cgm_type', 1)
            ->requirePresence('cgm_type', 'create')
            ->notEmptyString('cgm_type');

        return $validator;
    }
}
