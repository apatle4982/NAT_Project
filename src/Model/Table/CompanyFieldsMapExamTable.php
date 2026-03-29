<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CompanyFieldsMap Model
 *
 * @method \App\Model\Entity\CompanyFieldsMap newEmptyEntity()
 * @method \App\Model\Entity\CompanyFieldsMap newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CompanyFieldsMap[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CompanyFieldsMap get($primaryKey, $options = [])
 * @method \App\Model\Entity\CompanyFieldsMap findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CompanyFieldsMap patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CompanyFieldsMap[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CompanyFieldsMap|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompanyFieldsMap saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompanyFieldsMap[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CompanyFieldsMap[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CompanyFieldsMap[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CompanyFieldsMap[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CompanyFieldsMapExamTable extends Table
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

        $this->setTable('company_fields_map_exam');
        $this->setDisplayField('cfm_id');
        $this->setPrimaryKey('cfm_id');

        $this->belongsTo('CompanyMst', [
            'foreignKey' => 'cfm_companyid',
            'joinType' => 'INNER',
            'targetForeignKey' => 'cm_id'
        ]);
        $this->belongsTo('FieldsMstExam', [
            'foreignKey' => 'cfm_fieldid',
            'joinType' => 'INNER',
            'targetForeignKey' => 'fm_id'
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
       /*  $validator
            ->integer('cfm_companyid')
            ->requirePresence('cfm_companyid', 'create')
            ->notEmptyString('cfm_companyid');

        $validator
            ->integer('cfm_fieldid')
            ->requirePresence('cfm_fieldid', 'create')
            ->notEmptyString('cfm_fieldid');

        $validator
            ->scalar('cfm_maptitle')
            ->maxLength('cfm_maptitle', 100)
            ->requirePresence('cfm_maptitle', 'create')
            ->notEmptyString('cfm_maptitle');

        $validator
            ->integer('cfm_sortorder')
            ->requirePresence('cfm_sortorder', 'create')
            ->notEmptyString('cfm_sortorder');

        $validator
            ->scalar('cfm_datafield')
            ->maxLength('cfm_datafield', 50)
            ->requirePresence('cfm_datafield', 'create')
            ->notEmptyString('cfm_datafield');

        $validator
            ->scalar('cfm_defaultvalues')
            ->maxLength('cfm_defaultvalues', 255)
            ->requirePresence('cfm_defaultvalues', 'create')
            ->notEmptyString('cfm_defaultvalues');

        $validator
            ->scalar('cfm_group')
            ->maxLength('cfm_group', 50)
            ->requirePresence('cfm_group', 'create')
            ->notEmptyString('cfm_group');
 */
        return $validator;
    }

     // new function for only get partner map fields 
	// use for error show in upload data by csv in fcd controller
	public function mapFieldsByCompanyId($company_id = null, $columnData){
		$data= $results = $arrMerge = [];
	
		if(!empty($company_id)){
			// search by company Id
			$query = $this->find()
						->where(['CompanyFieldsMap.cfm_companyid'=>$company_id])
						->join([
							'table' => 'fields_mst',
							'alias' => 'fm',
							'type' => 'LEFT',
							'conditions' => 'CompanyFieldsMap.cfm_fieldid = fm.fm_id'
						])->select(['fm.fm_id','fm.fm_title','CompanyFieldsMap.cfm_maptitle']);
            $results = $query->order('fm.fm_sortorder')->disableHydration()->all()->toArray();
		}
		
		
 
		if($results){
          
            foreach($results as $key=>$result){
                
                //$data[trim($result['fm']['fm_title'])] = trim($result['cfm_maptitle']);
                if(!empty(trim($result['cfm_maptitle']))) 
                {	
                    $data[] = trim($result['cfm_maptitle']);
                }  
                
            }
         
           // $arrMerge = array_diff_assoc($columnData, $data);    

		}

		return $data;
	}
	 
    
	public function checkMapFieldsTitle($company_id,  $mapTitles, $all=null){
		$data= $results = [];
		if(!empty($company_id)){
			$query = $this->find()
					->where(['CompanyFieldsMap.cfm_companyid'=>$company_id, 'CompanyFieldsMap.cfm_maptitle IN '=>$mapTitles])
					->join([
						'table' => 'fields_mst',
						'alias' => 'fm',
						'type' => 'LEFT',
						'conditions' => 'CompanyFieldsMap.cfm_fieldid = fm.fm_id'
					])->select(['fm.fm_id','fm.fm_title','CompanyFieldsMap.cfm_maptitle']);
					
			$results = $query->disableHydration()->all()->toArray();
        }
        
        if($results){
            
            foreach($results as $key=>$result){
                if($all != null){
                    $data[trim($result['cfm_maptitle'])] = trim($result['fm']['fm_title']);
                }else{
                
                    // check for empty value result
                    $data = trim($result['fm']['fm_title']);
                    //$data = ($result['fm']['fm_title'] == 'ECapable') ? '' :  $result['fm']['fm_title'];
                }
            }
        }else{
 
            // new change
            //$mapTitles = ((trim($mapTitles) == 'PartnerID') ? 'cfm_companyid' : $mapTitles);
            if($all != null){
                $data[] = trim($mapTitles);
            }else $data = trim($mapTitles);
        }
			
        return $data;
	}

	// $flag_sup for $superScript call from coversheet PDF page 
	public function partnerMapFields($company_id=0,$is_group=0, $flag_sup=true){
		$results= [];
		
		$query = $this->find()
			 ->join([
				'table' => 'fields_mst',
				'alias' => 'fm',
				'type' => 'RIGHT',
				'conditions' => ['CompanyFieldsMap.cfm_fieldid = fm.fm_id','CompanyFieldsMap.cfm_companyid'=>$company_id]
			 ])
			 ->select(['fm.fm_id','fm.fm_title','CompanyFieldsMap.cfm_maptitle','CompanyFieldsMap.cfm_group']);

		$results = $query->disableHydration()->all()->toArray();
		$data = [];
		$counter = 2;
		$data['help'] ='1: Partner specific fields. These are fields A to Z in "Map Partner Field" section <br>';
		
		foreach($results as $listcfm){

			if($listcfm['cfm_maptitle'] != "" && trim($listcfm['fm']['fm_title']) !=''){
				
				//$data['mappedtitle'][trim($listcfm['fm']['fm_title'])] = trim($listcfm['cfm_maptitle'])."<sup><font color=red size=1><i>".$counter."</i></font></sup> ";
				//check non A-Z letters

				if(preg_match('/[^A-Z]/',$listcfm['fm']['fm_title']))
				{
					$superScript = (($flag_sup) ? "<sup><font color=red size=1><i>".$counter."</i></font></sup>" : '');
					$data['mappedtitle'][trim($listcfm['fm']['fm_title'])] = 
					trim($listcfm['cfm_maptitle']).$superScript;
					
					$data['help'] .= "$counter: ".trim($listcfm['fm']['fm_title']).' <br>';
					$counter++;
				}else{
					
					$superScript = (($flag_sup) ? "<sup><font color=red size=1><i>1</i></font></sup> " : '');
					$data['mappedtitle'][trim($listcfm['fm']['fm_title'])] = trim($listcfm['cfm_maptitle']).$superScript;
					
					if($is_group == 0){
						if($listcfm['cfm_group'] == "Recording Entry"){
							$data['fieldsvalsRE'][] = $listcfm;
						}elseif($listcfm['cfm_group'] == "Fees Details"){
							$data['fieldsvalsFD'][] = $listcfm;
						}elseif($listcfm['cfm_group'] == "Address"){
							$data['fieldsvalsAD'][] = $listcfm;
						}elseif($listcfm['cfm_group'] == "File"){
							$data['fieldsvalsFL'][] = $listcfm;
						}elseif($listcfm['cfm_group'] == "Mortgagor / Grantor"){
							$data['fieldsvalsMGR'][] = $listcfm;
						}elseif($listcfm['cfm_group'] == "Mortgagee / Grantee"){
							$data['fieldsvalsMGE'][] = $listcfm;
						}else{
							$data['fieldsvalsPS'][] = $listcfm;
						}
					}
				}	
			}else{
				
					$data['mappedtitle'][trim($listcfm['fm']['fm_title'])] = trim($listcfm['fm']['fm_title']);
				
			}

		}

		return $data;
	}

    public function checkMapFieldsTitleById($company_id = null,  array $mapTitlesId){
		$data= [];
	
		if(!empty($company_id)){
			// search by company Id 
			$query = $this->find()
						->where(['CompanyFieldsMapExam.cfm_companyid'=>$company_id, 'fm.fm_id IN'=>$mapTitlesId])
						->join([
							'table' => 'fields_mst_exam',
							'alias' => 'fm',
							'type' => 'LEFT',
							'conditions' => 'CompanyFieldsMapExam.cfm_fieldid = fm.fm_id'
						])->select(['fm.fm_id','fm.fm_title','fm.field_sections_id', 'CompanyFieldsMapExam.cfm_maptitle']);
		//echo $query;exit;
		}else{
			$query = $this->notFoundByCompany($mapTitlesId);
		}
		// if search by company id found empty result then its default search
		if($query->isEmpty()){
			$query = $this->notFoundByCompany($mapTitlesId);
		}

		$results = $query->order('fm.fm_sortorder')->disableHydration()->all()->toArray();
        //echo "<pre>";print_r($results);echo "</pre>";exit;
		if($results){
			foreach($results as $key=>$result){
				$data[trim($result['fm']['fm_title'])] =  (empty($result['cfm_maptitle']) ? trim($result['fm']['fm_title']): trim($result['cfm_maptitle']));
			}
		}
 
		return $data;
	}


    
	private function notFoundByCompany($mapTitlesId){
		$query = $this->find()
				->where(['fm.fm_id IN'=>$mapTitlesId])
				->join([
					'table' => 'fields_mst_exam',
					'alias' => 'fm'  ,
					'type' => 'LEFT',
					'conditions' => 'CompanyFieldsMapExam.cfm_fieldid = fm.fm_id'
				])->select(['fm.fm_id','fm.fm_title', 'fm.field_sections_id' ,'CompanyFieldsMapExam.cfm_maptitle' ]);
		return $query;
	}
 
}
