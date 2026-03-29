<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CountyCalApiResponse Model
 *
 * @method \App\Model\Entity\CountyCalApiResponse newEmptyEntity()
 * @method \App\Model\Entity\CountyCalApiResponse newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CountyCalApiResponse[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CountyCalApiResponse get($primaryKey, $options = [])
 * @method \App\Model\Entity\CountyCalApiResponse findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CountyCalApiResponse patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CountyCalApiResponse[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CountyCalApiResponse|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CountyCalApiResponse saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CountyCalApiResponse[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CountyCalApiResponse[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CountyCalApiResponse[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CountyCalApiResponse[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CountyCalApiResponseTable extends Table
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

        $this->setTable('County_cal_api_response');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
		
    }
	
	public function saveCountyCalAPIData(array $data){
		
		$CountyCalAPIData = $this->newEmptyEntity();
		$CountyCalAPIData = $this->patchEntity($CountyCalAPIData, $data,['validate' => false]);
		if($this->save($CountyCalAPIData)) 
			return true; 
		else 
			return false;
	}
}
