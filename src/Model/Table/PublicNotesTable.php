<?php
declare(strict_types=1);

namespace App\Model\Table;
use Cake\Datasource\ModelAwareTrait;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
/**
 * PublicNotes Model
 *
 * @method \App\Model\Entity\PublicNote newEmptyEntity()
 * @method \App\Model\Entity\PublicNote newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PublicNote[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PublicNote get($primaryKey, $options = [])
 * @method \App\Model\Entity\PublicNote findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PublicNote patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PublicNote[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PublicNote|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PublicNote saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PublicNote[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicNote[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicNote[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicNote[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PublicNotesTable extends Table
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

        $this->setTable('public_notes_fcd');  
        $this->setDisplayField('Id');
        $this->setPrimaryKey('Id');

        $this->belongsTo('FilesMainData', [
            'foreignKey' => 'RecId',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('DocumentTypeMst', [
            'foreignKey' => 'TransactionType',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'UserId',
            'joinType' => 'INNER'
        ]);
		
		$this->addBehavior('Search.Search');
        $this->searchManagerConfig();
    }
   


    public function searchManagerConfig() 
    {
        $search = $this->searchManager();
		$search->like('Regarding');
		$search->like('Type');
		$search->like('Section');
		$search->like('Public_Internal');
        return $search;
    }
    public $notesModel;
    //*******$modelAlies ==> ['Fcd','Fqcd', 'Fad','fsd', 'Frd', 'Coversheet', 'Frtpd']*********//
    public $publicNotesmodel = ['Fcd','Fqcd', 'Fad','Fsd', 'Frd', 'Coversheet', 'Frtpd','Fva', 'Aol', 'Exam'];
    private function setNotesTable($modelAlies){
        $this->notesModel = TableRegistry::get('PublicNotes'.$modelAlies);
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
            ->integer('RecId')
            ->requirePresence('RecId', 'create')
            ->notEmptyString('RecId');

        $validator
            ->integer('TransactionType')
            ->requirePresence('TransactionType', 'create')
            ->notEmptyString('TransactionType');

        $validator
            ->integer('UserId')
            ->requirePresence('UserId', 'create')
            ->notEmptyString('UserId');

        $validator
            ->scalar('Regarding')
            ->requirePresence('Regarding', 'create')
            ->notEmptyString('Regarding');

        $validator
            ->scalar('Type')
            ->maxLength('Type', 100)
            ->requirePresence('Type', 'create')
            ->notEmptyString('Type');

        $validator
            ->scalar('Section')
            ->maxLength('Section', 100)
            ->requirePresence('Section', 'create')
            ->notEmptyString('Section');

        $validator
            ->date('AddingDate')
            ->requirePresence('AddingDate', 'create')
            ->notEmptyDate('AddingDate');

        $validator
            ->time('AddingTime')
            ->requirePresence('AddingTime', 'create')
            ->notEmptyTime('AddingTime');

        $validator
            ->scalar('Public_Internal')
            ->maxLength('Public_Internal', 1)
            ->requirePresence('Public_Internal', 'create')
            ->notEmptyString('Public_Internal');

        $validator
            ->scalar('subject')
            ->maxLength('subject', 250)
            ->allowEmptyString('subject');

        $validator
            ->scalar('body')
            ->allowEmptyString('body'); */

        return $validator;
    }


    public function insertNewPublicNotes($fmdId, $doctype, $currentUserId,$Regarding='Record Uploaded', $modelAlies='Fva',$type=false,$Section='ARD'){
		//echo $fmdId."-".$doctype."-".$currentUserId."-".$Regarding."-".$modelAlies."-".$type."-".$Section;exit;
        $this->setNotesTable($modelAlies);
      
        $publicNotesData = $this->notesModel->newEmptyEntity();
		$type = (($type) ? 'System/User Input': 'Auto Generated');
		$insertPublicData = [
								'RecId'   => $fmdId,
								'TransactionType'  => $doctype,
								'UserId' => $currentUserId,
								'Section' => $Section,   
								'AddingDate' => date("Y-m-d"),
								'AddingTime' => date("H:i:s"),
								'Type'  =>  $type,
								'Public_Internal' =>'I',
								'Regarding'      =>$Regarding
							];
		
		$publicNotesData = $this->notesModel->patchEntity($publicNotesData, $insertPublicData,['validate' => false]);
	 
        if($this->notesModel->save($publicNotesData))	
			return true;
		else 
			return false;
	}

    
	public function deleteAllRecords($fmdId, $doctype, $modelAlied){
        foreach($this->publicNotesmodel as $modelAlies){
            $this->setNotesTable($modelAlies);
            $this->notesModel->deleteAll(['RecId'=>$fmdId, 'TransactionType '=>$doctype]);
        }
        
		return true;
	}
	
	public function publicFileMainData($recordMainId, $doctype){
		
		$query = $this->find()
					 ->where(['PublicNotes.RecId'=>$recordMainId, 'PublicNotes.TransactionType'=>$doctype])
					 /* ->select([
					 'PublicNotes.TransactionType',
					 'Users.user_name',
                     'Users.user_lastname',
					 'FilesMainData.company_mst_id',
					 'CompanyMst.cm_comp_name',
					 'FilesMainData.PartnerFileNumber',
					 'FilesMainData.NATFileNumber',
					 'FilesMainData.Grantors',
					 'FilesMainData.StreetName',
					 'FilesMainData.State',
					 'FilesMainData.County']) */
					 ->contain(['Users'=> [ 
                            'fields' => [
                                'Users__user_name' => 'Users.user_name',
                                'Users__user_lastname' => 'Users.user_lastname'
                            ] 
                    ]])
					 ->limit(1);
                     debug($query->sql());
		 
		if(!empty($result)){
			$result =  $result[0];
		}
		return $result;
	}

    //
    public function publicNotesDataUnion($recordMainId, $doctype, $is_return='R'){
       
        $limit = 100;
        $queryUnion = $this->find()
                    ->contain(['Users'=> [ 
                        'fields' => [
                            'Users__user_name' => 'Users.user_name',
                            'Users__user_lastname' => 'Users.user_lastname'
                        ] 
                    ]])
                    ->where(['PublicNotes.RecId'=>$recordMainId, 'PublicNotes.TransactionType'=>$doctype])->order(['PublicNotes.AddingDate'=>'asc','PublicNotes.AddingTime'=>'asc'])->limit($limit);
     
      // $queryUnion =  $this->find('search', $condition)->contain(['Users']);
       
        unset($this->publicNotesmodel[0]); //remove notes_fcd table
        foreach($this->publicNotesmodel as $modelAlies){
            $this->setNotesTable($modelAlies);
             $queryOther = $this->notesModel->find()
                            ->contain(['Users'=> [
                                'fields' => [
                                    'Users__user_name' => 'Users.user_name',
                                    'Users__user_lastname' => 'Users.user_lastname'
                                ] 
                            ]])
                            ->where(['PublicNotes'.$modelAlies.'.RecId'=>$recordMainId, 'PublicNotes'.$modelAlies.'.TransactionType'=>$doctype])->order(['PublicNotes'.$modelAlies.'.AddingDate'=>'asc','PublicNotes'.$modelAlies.'.AddingTime'=>'asc'])->limit($limit);
                
          //  $queryOther = $this->notesModel->find('search', $condition)->contain(['Users']); 
            $queryUnion = $queryUnion->unionAll($queryOther); 
        }
 
       // debug($queryUnion->sql());   
        if($is_return == 'Q'){
            return $queryUnion;
        }if($is_return == 'C'){
            $resultcount =  $queryUnion->count();
            return $resultcount;
        }else{ 
            $result =  $queryUnion->all()->toArray();  //->disableHydration()
            return  $result;
        }
		
 
	}
	

    public function publicNotesDataJoin(Query $query, $is_return='R'){ //$recordMainId, $doctype
	 
		$query = /* $this->find()
					 ->where(['PublicNotes.RecId'=>$recordMainId, 'PublicNotes.TransactionType'=>$doctype]) */
                    $query->join([
						'table' => 'public_notes_fqcd',
						'alias' => 'notes_fqcd',
						'type' => 'LEFT',
						'conditions' => ['notes_fqcd.RecId = PublicNotes.RecId','notes_fqcd.TransactionType = PublicNotes.TransactionType']
					])
                    ->join([
						'table' => 'public_notes_fad',
						'alias' => 'notes_fad',
						'type' => 'LEFT',
						'conditions' => ['notes_fad.RecId = PublicNotes.RecId','notes_fad.TransactionType = PublicNotes.TransactionType']
					])
                    ->join([
						'table' => 'public_notes_fsd',
						'alias' => 'notes_fsd',
						'type' => 'LEFT',
						'conditions' => ['notes_fsd.RecId = PublicNotes.RecId','notes_fsd.TransactionType = PublicNotes.TransactionType']
					])
                    ->join([
						'table' => 'public_notes_frd',
						'alias' => 'notes_frd',
						'type' => 'LEFT',
						'conditions' => ['notes_frd.RecId = PublicNotes.RecId','notes_frd.TransactionType = PublicNotes.TransactionType']
					])
                    ->join([
						'table' => 'public_notes_frtpd',
						'alias' => 'notes_frtpd',
						'type' => 'LEFT',
						'conditions' => ['notes_frtpd.RecId = PublicNotes.RecId','notes_frtpd.TransactionType = PublicNotes.TransactionType']
					])
                    ->join([
						'table' => 'public_notes_coversheet',
						'alias' => 'notes_coversheet',
						'type' => 'LEFT',
						'conditions' => ['notes_coversheet.RecId = PublicNotes.RecId','notes_coversheet.TransactionType = PublicNotes.TransactionType']
					])
                    
                    ->contain(['Users'=> [ 
                        'fields' => [
                            'Users__user_name' => 'Users.user_name',
                            'Users__user_lastname' => 'Users.user_lastname'
                        ] 
                    ]])
					 ->limit(10);
        if($is_return == 'Q'){
            return $query;
        }if($is_return == 'C'){
            $resultcount =  $query->count();
            return $resultcount;
        }else{
 
            $result =  $query->toArray();
 
            return $result;
        }
		
	}
	
	
}
