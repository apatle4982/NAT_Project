<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Database\Expression\QueryExpression;

class FieldsMstExamTable extends Table
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

        $this->setTable('fields_mst_exam');
        $this->setDisplayField('fm_id');
        $this->setPrimaryKey('fm_id');

       

        $this->belongsTo('FieldSectionsExam', [
            'foreignKey' => 'field_sections_id',
            'targetForeignKey' => 'id',
            'joinType' => 'INNER'
        ]);
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
            ->scalar('fm_title')
            ->maxLength('fm_title', 50)
            ->requirePresence('fm_title', 'create')
            ->notEmptyString('fm_title');

        $validator
            ->integer('fm_sortorder')
            ->requirePresence('fm_sortorder', 'create')
            ->notEmptyString('fm_sortorder');

        $validator
            ->scalar('fm_main')
            ->maxLength('fm_main', 1)
            ->requirePresence('fm_main', 'create')
            ->notEmptyString('fm_main');

        return $validator;
    }

    public function listFields(){
		return  $this->find('all', ['limit' => 200, 'order'=>['FieldsMstExam.fm_sortorder'=>'ASC','FieldsMstExam.fm_title'=>'ASC']])->toArray();
		
	}

    public function listFieldsByIDs($fmdids){
       
        $fmdidArr = explode(',', $fmdids);  
        
        $return = $this->find()->disableHydration()->select('fm_title')->where(['fm_id IN'=> $fmdidArr])->toArray();
          if($return[0]){

            return $return[0];
        }else{
            return $return = DEFAULTFMDFIELDS;
           
        } 
		
	}

    public function getFieldSectionData(){
        return $this->FieldSectionsExam->find('all', ['limit' => 200, 'order'=>['FieldSectionsExam.set_order'=>'ASC']])
									->where(['FieldSectionsExam.id not in '=>[9,10]])
									->disableHydration()->contain(['FieldsMstExam'=>['sort' => ['FieldsMstExam.fm_sortorder' => 'ASC'] ]])->toArray();
    }

   /*  public function getFieldsAssociation($flds=[]){
        return $this->FieldSections->find('all')->disableHydration()->contain(['FieldsMstExam'=>['whereIn'=>['fm_id'=>$flds], 'sort' => ['FieldsMst.fm_sortorder' => 'ASC'] ]])->toArray();
    } */




    // here we are not using company mapping.
    public function checkMapFieldsExport($company_id = null,  array $mapTitlesId){
		$data= [];
 
		if(!empty($company_id)){
			// search by company Id 
			$query = $this->find()
						->where(['FieldsMstExam.fm_id IN'=>$mapTitlesId])
						->join([
							'table' => 'field_sections',
							'alias' => 'fs',
							'type' => 'LEFT',
							'conditions' => 'fs.id = FieldsMstExam.field_sections_id'
						])->select(['FieldsMstExam.fm_id','FieldsMstExam.display_fm_title','FieldsMstExam.fm_title','FieldsMstExam.alies_fm_title','fs.table_alies']);
			 
		} else{
            return $data;
		//	$query = $this->notFoundByCompanyExport($mapTitlesId);
		}
		/*
		// if search by company id found empty result then its default search
		if($query->isEmpty()){
			$query = $this->notFoundByCompanyExport($mapTitlesId);
		} */
 
		$results = $query->order('FieldsMstExam.fm_sortorder')->disableHydration()->all()->toArray();
   
		if($results){ 
			foreach($results as $key=>$result){
				$data[trim($result['alies_fm_title'])] =  (!empty($result['display_fm_title']) ? trim($result['display_fm_title']) : '');
			}
		}
 
		return $data;
	}
	
	// here we are not using company mapping.
    public function checkMapFieldsExportNew($company_id = null,  array $mapTitlesId){
		$data= [];
 
		if(!empty($company_id)){
			// search by company Id 
			$query = $this->find()
						->where(['FieldsMstExam.fm_id IN'=>$mapTitlesId])
						->join([
							'table' => 'field_sections',
							'alias' => 'fs',
							'type' => 'LEFT',
							'conditions' => 'fs.id = FieldsMstExam.field_sections_id'
						])->select(['FieldsMstExam.fm_id','FieldsMstExam.display_fm_title','FieldsMstExam.fm_title','FieldsMstExam.alies_fm_title','fs.table_alies']);
			 
		} else{
			$query = $this->find()
						->where(['FieldsMstExam.fm_id IN'=>$mapTitlesId])
						->join([
							'table' => 'field_sections',
							'alias' => 'fs',
							'type' => 'LEFT',
							'conditions' => 'fs.id = FieldsMstExam.field_sections_id'
						])->select(['FieldsMstExam.fm_id','FieldsMstExam.display_fm_title','FieldsMstExam.fm_title','FieldsMstExam.alies_fm_title','fs.table_alies']);
            //return $data;
		//	$query = $this->notFoundByCompanyExport($mapTitlesId);
		}
		/*
		// if search by company id found empty result then its default search
		if($query->isEmpty()){
			$query = $this->notFoundByCompanyExport($mapTitlesId);
		} */
 
		$results = $query->order('FieldsMstExam.fm_sortorder')->disableHydration()->all()->toArray();
   
		if($results){ 
			foreach($results as $key=>$result){
				$data[trim($result['alies_fm_title'])] =  (!empty($result['display_fm_title']) ? trim($result['display_fm_title']) : '');
			}
		}
 
		return $data;
	}

	 
}
