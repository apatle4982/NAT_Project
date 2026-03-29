<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class CompanyImportFieldsExamTable extends Table{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('company_import_fields_exam');
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
        return $validator;
    }

     

	public function importFieldsData($id = null)
    { 
		$return = array();
		
			$result  = $this->find()->where(['cif_companyid'=>$id])->select(['CompanyImportFieldsExam.cif_id', 'CompanyImportFieldsExam.cif_fieldid'])->toArray();
			
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
						'table' => 'fields_mst_exam',
						'alias' => 'fm',
						'type' => 'LEFT',
						'conditions' => 'FIND_IN_SET(fm.fm_id, CompanyImportFieldsExam.cif_fieldid)'
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
		$this->CompanyFieldsMapExam = TableRegistry::get('CompanyFieldsMapExam');
		$data= [];
		$query = $this->find()
					->where(['cif_companyid'=>$company_id])
					->order(['fm.fm_sortorder ASC'])
					->join([
						'table' => 'fields_mst_exam',
						'alias' => 'fm',
						'type' => 'LEFT',
						'conditions' => 'FIND_IN_SET(fm.fm_id, CompanyImportFieldsExam.cif_fieldid)'
					])					
					->select(['fm.fm_id','fm.fm_title'])->distinct(['fm.fm_id']);
		$results = $query->disableHydration()->all()->toArray();

		if($results){
			foreach($results as $result){
				//$data[] = $result['fm']['fm_title'];
				// checkMapFieldsTitleById use this function here
				$data[] = $this->CompanyFieldsMapExam->checkMapFieldsTitleById($company_id,[$result['fm']['fm_id']]);
			}
		}

		return $data;
	}


}
