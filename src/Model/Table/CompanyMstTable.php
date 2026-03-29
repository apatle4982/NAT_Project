<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CompanyMst Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\HasMany $Users
 *
 * @method \App\Model\Entity\CompanyMst newEmptyEntity()
 * @method \App\Model\Entity\CompanyMst newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CompanyMst[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CompanyMst get($primaryKey, $options = [])
 * @method \App\Model\Entity\CompanyMst findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CompanyMst patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CompanyMst[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CompanyMst|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompanyMst saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompanyMst[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CompanyMst[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CompanyMst[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CompanyMst[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CompanyMstTable extends Table
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

        $this->setTable('company_mst');
        $this->setDisplayField('cm_id');
        $this->setPrimaryKey('cm_id');
		
		$this->addBehavior('Search.Search');
		
		// Setup search filter using search manager
        $this->searchManagerConfig();
    }
	
	public function searchManagerConfig()
    {
        $search = $this->searchManager(); 
		$search->Like('cm_comp_name');
		$search->Like('cm_phone');
		$search->Like('cm_email');
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
            ->scalar('cm_comp_name')
			->notEmptyString('cm_comp_name', __('Please Enter the Company Name'))
            ->maxLength('cm_comp_name', 255)
            ->requirePresence('cm_comp_name', 'create')
            ->notEmptyString('cm_comp_name');

        $validator
            ->scalar('cm_email')
			->notEmptyString('cm_email', __('Please Enter the Valid Email'))
            ->maxLength('cm_email', 255)
            ->requirePresence('cm_email', 'create')
            ->notEmptyString('cm_email');

        return $validator;
    }


    // CHK
    // serch company dada for select drodown
     
    public function companyListArray(){
				
		return $this->find('list', [
					'keyField' => 'cm_id',
					'valueField' => 'cm_comp_name'
				])
				->order(['cm_comp_name' => 'ASC']);
				//->limit(100);
		
	}
	
	
	public function partnerCompanyList(){
				
		return $this->find('list', [
					'keyField' => 'cm_id',
					'valueField' => 'cm_partner_cmp'
				])->where(['cm_partner_cmp !=' => ''])
				->order(['cm_partner_cmp' => 'ASC']);
				//->limit(100);
		
	}


    public function getExportCsvName($id=Null,$fldName){
		$results = [];	
		if(!empty($id)){
			$query = $this->find()
					->where(['cm_id'=>$id])
					->select(['cm_'.$fldName.'_prefix', 'cm_'.$fldName.'_dt']);
			$results = $query->first()->toArray();

            if(empty($results['cm_'.$fldName.'_prefix'])){
                $results['cm_'.$fldName.'_prefix']= $fldName;
            }
            if(empty($results['cm_'.$fldName.'_dt'])){
                $results['cm_'.$fldName.'_dt']= 'Ymd';
            }
            
            return $results['cm_'.$fldName.'_prefix'].''.date($results['cm_'.$fldName.'_dt']."His");
		} else {
            return $fldName.'_'.date("Ymd");
        }
		
		// if records not found using fields name then use default
		
		
		
		
	}
 
}
