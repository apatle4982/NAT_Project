<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentTypeMst Model
 *
 * @method \App\Model\Entity\DocumentTypeMst newEmptyEntity()
 * @method \App\Model\Entity\DocumentTypeMst newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentTypeMst[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentTypeMst get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentTypeMst findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\DocumentTypeMst patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentTypeMst[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentTypeMst|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentTypeMst saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentTypeMst[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DocumentTypeMst[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\DocumentTypeMst[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DocumentTypeMst[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class DocumentTypeMstTable extends Table
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

        $this->setTable('document_type_mst');
        $this->setDisplayField('Id');
        $this->setPrimaryKey('Id');
		
		$this->belongsTo('DocumentSimplifileMst', [
            'foreignKey' => 'document_simplifile_id',
            'joinType' => 'LEFT'
        ]);
		
		$this->belongsTo('DocumentCountycalMst', [
            'foreignKey' => 'document_Countycal_id',
            'joinType' => 'LEFT'
        ]);
		
		$this->belongsTo('DocumentCscMst', [
            'foreignKey' => 'document_csc_id',
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
            ->scalar('Title')
            ->maxLength('Title', 225)
            ->requirePresence('Title', 'create')
            ->notEmptyString('Title');

        $validator
            ->integer('status')
            ->notEmptyString('status');

        return $validator;
    }


    	
	public function documentList(){
		
		return $this->find('list', [
					'keyField' => 'Id',
					'valueField' => 'Title'
				])
				->group('Title')
				->order(['Title ASC']);
	}
	
	public function documentTypeListing(){
		return $this->find('list', [
			'keyField' => 'Id',
			'valueField' => 'Title'
		])->toArray();
	}
	 
	public function getDocumentTitle($dmtId){
		
		$query = $this->find()
		->where(['Id'=>$dmtId])
		->select(['Title'])->disableHydration(); 
		
		$results = $query->toArray();
       
		if(!empty($results)) return $results[0];
	}
}
