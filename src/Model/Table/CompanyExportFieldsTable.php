<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CompanyExportFields Model
 *
 * @method \App\Model\Entity\CompanyExportField newEmptyEntity()
 * @method \App\Model\Entity\CompanyExportField newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CompanyExportField[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CompanyExportField get($primaryKey, $options = [])
 * @method \App\Model\Entity\CompanyExportField findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CompanyExportField patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CompanyExportField[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CompanyExportField|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompanyExportField saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompanyExportField[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CompanyExportField[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CompanyExportField[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CompanyExportField[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CompanyExportFieldsTable extends Table
{
    public $defaultExport = [ 	
        'cef_fieldid4CHI'=>'1,3,4,5,6,51,7,9,10,11,12,13,14,53,32,33',
        'cef_fieldid4QC'=>'1,3,4,5,6,51,32,48',
        'cef_fieldid4AC'=>'3,4,5,6,7,8,9,10,11,12,13,64,34,35,36,37,38,39,40',
        'cef_fieldid4RJ'=>'3,4,5,6,7,8,9,10,11,12,13,14,51,52',  
        'cef_fieldid4RE'=>'1,3,4,5,6,51,53,32,34,35,36,37,43,44,45,46,47',
        'cef_fieldid4GP'=>'1,33,3,4,5,7,12,13,32,64', //MJ / CHK
        //'cef_fieldid4SC'=>'1,3,4,5,6,51,32,41,42',
        'cef_fieldid4SC'=>'3,4,5,6,7,8,9,10,11,12,13,14,41,42,64',
        'cef_fieldid4RP'=>'1,3,4,5,6,51,32,41,42',
        'cef_fieldid4CO'=>'1,3,4,5,6,51,7,53,32,34,35,36,37,41,42,43,44,45,46,47,83',
        'cef_fieldid4MS'=>'1,3,4,5,6,51,7,8,52,9,10,11,12,13,14,53,32,34,35,36,37,41,42,43,44,45,46,47,83'
     ];
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('company_export_fields');
        $this->setDisplayField('cef_id');
        $this->setPrimaryKey('cef_id');
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
            ->integer('cef_companyid')
            ->requirePresence('cef_companyid', 'create')
            ->notEmptyString('cef_companyid');

        $validator
            ->scalar('cef_fieldid4CHI')
            ->requirePresence('cef_fieldid4CHI', 'create')
            ->notEmptyString('cef_fieldid4CHI');

        $validator
            ->scalar('cef_fieldid4QC')
            ->requirePresence('cef_fieldid4QC', 'create')
            ->notEmptyString('cef_fieldid4QC');

        $validator
            ->scalar('cef_fieldid4AC')
            ->requirePresence('cef_fieldid4AC', 'create')
            ->notEmptyString('cef_fieldid4AC');

        $validator
            ->scalar('cef_fieldid4RE')
            ->requirePresence('cef_fieldid4RE', 'create')
            ->notEmptyString('cef_fieldid4RE');

        $validator
            ->scalar('cef_fieldid4GP')
            ->requirePresence('cef_fieldid4GP', 'create')
            ->notEmptyString('cef_fieldid4GP');

        $validator
            ->scalar('cef_fieldid4SC')
            ->requirePresence('cef_fieldid4SC', 'create')
            ->notEmptyString('cef_fieldid4SC');

        $validator
            ->scalar('cef_fieldid4RP')
            ->requirePresence('cef_fieldid4RP', 'create')
            ->notEmptyString('cef_fieldid4RP');

        $validator
            ->scalar('cef_fieldid4CO')
            ->requirePresence('cef_fieldid4CO', 'create')
            ->notEmptyString('cef_fieldid4CO');

        $validator
            ->scalar('cef_fieldid4MS')
            ->requirePresence('cef_fieldid4MS', 'create')
            ->notEmptyString('cef_fieldid4MS');
*/
        return $validator; 
    }

    /*
	// send only company id and search fields
	*/
	public function exportFieldsDataByField($id = null, $modelField)
    {  
		$return = [];
		if(!empty($id)){
			$query = $this->find()->where(['cef_companyid'=>$id])->select([$modelField]);
			$result  = $query->toArray();
			
			$cif_fieldidArray = [];
			if(array_key_exists(0,$result)){
				
				if(($modelField !='') && $result[0][$modelField] != ''){
					$cif_fieldidArray = explode(',', $result[0][$modelField]);
					$return = $cif_fieldidArray;
				}

			}else{
				// if records not found using fields name then use default
				$cif_fieldidArray = explode(',', $this->defaultExport[$modelField]);
				$return = $cif_fieldidArray;
			}
		}else{
			$cif_fieldidArray = explode(',', $this->defaultExport[$modelField]);
		
			$return = $cif_fieldidArray;
		}
		
		return $return;
    }

    public function insertExportFieldsData($id){ 
		$companyExportFields = $this->newEmptyEntity();
		$companyExportFields = $this->patchEntity($companyExportFields, [
									 'cef_companyid' => $id,
									 'cef_fieldid4CHI'=>'1,3,4,5,6,51,7,9,10,11,12,13,14,53,32,33',
									 'cef_fieldid4QC'=>'1,3,4,5,6,51,32,48',
									 'cef_fieldid4AC'=>'3,4,5,6,7,8,9,10,11,12,13,64,34,35,36,37,38,39,40',
									 'cef_fieldid4RE'=>'1,3,4,5,6,51,53,32,34,35,36,37,43,44,45,46,47',
									 'cef_fieldid4GP'=>'',
									 'cef_fieldid4SC'=>'1,3,4,5,6,51,32,41,42',
									 'cef_fieldid4RP'=>'1,3,4,5,6,51,32,41,42',
									 'cef_fieldid4CO'=>'1,3,4,5,6,51,7,53,32,34,35,36,37,41,42,43,44,45,46,47,48',
									 'cef_fieldid4MS'=>'1,3,4,5,6,51,7,8,52,9,10,11,12,13,14,53,32,34,35,36,37,41,42,43,44,45,46,47,48'
									] //,['validate'=>false]
								);

		if($this->save($companyExportFields))
			return true;
		else
			return false;
		
	}
}
