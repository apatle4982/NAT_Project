<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * CompanyImportFields Model
 *
 * @method \App\Model\Entity\CompanyImportField newEmptyEntity()
 * @method \App\Model\Entity\CompanyImportField newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CompanyImportField[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CompanyImportField get($primaryKey, $options = [])
 * @method \App\Model\Entity\CompanyImportField findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CompanyImportField patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CompanyImportField[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CompanyImportField|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompanyImportField saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompanyImportField[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CompanyImportField[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CompanyImportField[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CompanyImportField[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CompanyImportFieldsTable extends Table
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

        $this->setTable('company_import_fields');
        $this->setDisplayField('cif_id');
        $this->setPrimaryKey('cif_id');
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
            ->integer('cif_companyid')
            ->requirePresence('cif_companyid', 'create')
            ->notEmptyString('cif_companyid');

        $validator
            ->scalar('cif_fieldid')
            ->maxLength('cif_fieldid', 255)
            ->requirePresence('cif_fieldid', 'create')
            ->notEmptyString('cif_fieldid'); */

        return $validator;
    }

     

	public function importFieldsData($id = null)
    { 
		$return = array();
		
			$result  = $this->find()->where(['cif_companyid'=>$id])->select(['CompanyImportFields.cif_id', 'CompanyImportFields.cif_fieldid'])->toArray();
			
			$cif_fieldidArray = array();
			if(array_key_exists(0,$result)){
				if($result[0]['cif_fieldid'] != ''){ // && strpos($result[0]['cif_fieldid'], ',')
				 $cif_fieldidArray = explode(',', $result[0]['cif_fieldid']);
				}
				$return =  array('id'=>$result[0]['cif_id'],'fieldid'=>$cif_fieldidArray);
			}

		return $return;
    }
	 
    public function companyMapImportFields($company_id = null)
    { 

		$data= [];
		  $query = $this->find()
					->where(['cif_companyid'=>$company_id])
					->order(['fm.fm_sortorder ASC'])
					->join([
						'table' => 'fields_mst',
						'alias' => 'fm',
						'type' => 'LEFT',
						'conditions' => 'FIND_IN_SET(fm.fm_id, CompanyImportFields.cif_fieldid)'
					])->select(['fm.fm_id','fm.fm_title'])->distinct(['fm.fm_id']);
		$results = $query->disableHydration()->all()->toArray();

		if($results){
			foreach($results as $result){
				$data[] = $result['fm']['fm_title'];
			}
		}

		return $data;
	}
	
	
	public function companyMapImportCVSData($company_id = null)
    { 
		$this->CompanyFieldsMap = TableRegistry::get('CompanyFieldsMap');
		$data= [];
		$query = $this->find()
					->where(['cif_companyid'=>$company_id])
					->order(['fm.fm_sortorder ASC'])
					->join([
						'table' => 'fields_mst',
						'alias' => 'fm',
						'type' => 'LEFT',
						'conditions' => 'FIND_IN_SET(fm.fm_id, CompanyImportFields.cif_fieldid)'
					])					
					->select(['fm.fm_id','fm.fm_title'])->distinct(['fm.fm_id']);
		$results = $query->disableHydration()->all()->toArray();

		if($results){
			foreach($results as $result){
				//$data[] = $result['fm']['fm_title'];
				// checkMapFieldsTitleById use this function here
				$data[] = $this->CompanyFieldsMap->checkMapFieldsTitleById($company_id,[$result['fm']['fm_id']]);
			}
		}

		return $data;
	}


}
