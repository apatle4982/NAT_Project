<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FilesCsvMaster Model
 *
 * @method \App\Model\Entity\FilesCsvMaster newEmptyEntity()
 * @method \App\Model\Entity\FilesCsvMaster newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FilesCsvMaster[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FilesCsvMaster get($primaryKey, $options = [])
 * @method \App\Model\Entity\FilesCsvMaster findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FilesCsvMaster patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FilesCsvMaster[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FilesCsvMaster|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesCsvMaster saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesCsvMaster[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesCsvMaster[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesCsvMaster[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesCsvMaster[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FilesCsvMasterTable extends Table
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

        $this->setTable('files_csv_master');
        $this->setDisplayField('Id');
        $this->setPrimaryKey('Id');
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
            ->integer('CompanyId')
            ->requirePresence('CompanyId', 'create')
            ->notEmptyString('CompanyId');

        $validator
            ->scalar('SheetName')
            ->maxLength('SheetName', 255)
            ->requirePresence('SheetName', 'create')
            ->notEmptyString('SheetName');

        $validator
            ->dateTime('CSVDate')
            ->requirePresence('CSVDate', 'create')
            ->notEmptyDateTime('CSVDate'); */

        return $validator;
    }


    
	public function insertCSVFiles($companyid, $filename){
		$filesCsvLastId = 0;
		$filesCsvMaster = $this->newEmptyEntity();
		$csvRequestData = ['CompanyId'=>$companyid,
						   'SheetName'=>$filename,
						   'CSVDate'=>date("Y-m-d H:i:s")
						  ];
		$filesCsvMaster = $this->patchEntity($filesCsvMaster,$csvRequestData);
		 
		if($this->save($filesCsvMaster)){
			$filesCsvLastId =  $filesCsvMaster->Id;
		}
		
		return $filesCsvLastId;
	}
}
