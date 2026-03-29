<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
  
/**
 * CompanyExportmapSettings Model
 *
 * @method \App\Model\Entity\CompanyExportmapSetting newEmptyEntity()
 * @method \App\Model\Entity\CompanyExportmapSetting newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CompanyExportmapSetting[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CompanyExportmapSetting get($primaryKey, $options = [])
 * @method \App\Model\Entity\CompanyExportmapSetting findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CompanyExportmapSetting patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CompanyExportmapSetting[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CompanyExportmapSetting|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompanyExportmapSetting saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompanyExportmapSetting[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CompanyExportmapSetting[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CompanyExportmapSetting[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CompanyExportmapSetting[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CompanyExportmapSettingsTable extends Table
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

        $this->setTable('company_exportmap_settings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->integer('company_id')
            ->requirePresence('company_id', 'create')
            ->notEmptyString('company_id');

        $validator
            ->scalar('sheet_name')
            ->maxLength('sheet_name', 255)
            ->allowEmptyString('sheet_name');

        $validator
            ->scalar('export_fields')
            ->allowEmptyString('export_fields');

        $validator
            ->scalar('export_field_mapid')
            ->requirePresence('export_field_mapid', 'create')
            ->notEmptyString('export_field_mapid');

        $validator
            ->allowEmptyString('document_status');

        $validator
            ->date('date_from')
            ->requirePresence('date_from', 'create')
            ->notEmptyDate('date_from');

        $validator
            ->date('date_to')
            ->requirePresence('date_to', 'create')
            ->notEmptyDate('date_to');

        $validator
            ->dateTime('added_date')
            ->notEmptyDateTime('added_date');

        $validator
            ->notEmptyString('is_delete'); */

        return $validator;
    }


    public function listReports(){
		return $this->find('all', ['order'=>['added_date'=>'DESC']])->select(['id','sheet_name'])->where(['is_delete'=>0])->disableHydration()->toArray();
	}

    public function fetchReports($report_id){
		$fetchReports = $this->find('all', ['order'=>['added_date'=>'ASC']])->where(['id'=>$report_id,'is_delete'=>0])->disableHydration()->toArray();
        if(count($fetchReports)>0){ 
            $fetchReports[0]['export_fields'] = unserialize($fetchReports[0]['export_fields']);
            return $fetchReports[0];
        }else{
            return [];
        }
    }

    
    public function addExportSetting($postData){
        
        if(!empty($postData['report_id'])){
            $exportData = $this->get($postData['report_id']);  
            unset($postData['report_id']);
        }else{
            $exportData = $this->newEmptyEntity();
        } 
        
		$publicNotesData = $this->patchEntity($exportData, $postData,['validate' => false]);
		if($this->save($publicNotesData))	
            return $publicNotesData->id; 
			//return true;
		else 
			return false;
	}
    
}
