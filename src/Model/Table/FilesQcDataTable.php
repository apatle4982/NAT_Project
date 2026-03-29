<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FilesQcData Model
 *
 * @method \App\Model\Entity\FilesQcData newEmptyEntity()
 * @method \App\Model\Entity\FilesQcData newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FilesQcData[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FilesQcData get($primaryKey, $options = [])
 * @method \App\Model\Entity\FilesQcData findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FilesQcData patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FilesQcData[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FilesQcData|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesQcData saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesQcData[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesQcData[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesQcData[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesQcData[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FilesQcDataTable extends Table
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

        $this->setTable('files_qc_data'.ARCHIVE_PREFIX);
        $this->setDisplayField('Id');
        $this->setPrimaryKey('Id');

        $this->addBehavior('Search.Search');	
		$this->addBehavior('CustomLRS');
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
            ->scalar('Status')
            ->maxLength('Status', 10)
            ->requirePresence('Status', 'create')
            ->notEmptyString('Status');

        $validator
            ->scalar('PRRCRNType')
            ->maxLength('PRRCRNType', 10)
            ->allowEmptyString('PRRCRNType');

        $validator
            ->scalar('StatusNote')
            ->requirePresence('StatusNote', 'create')
            ->notEmptyString('StatusNote');

        $validator
            ->scalar('StatusReason')
            ->requirePresence('StatusReason', 'create')
            ->notEmptyString('StatusReason');

        $validator
            ->scalar('RejectionReason')
            ->requirePresence('RejectionReason', 'create')
            ->notEmptyString('RejectionReason');

        $validator
            ->scalar('CarrierName4RR')
            ->maxLength('CarrierName4RR', 100)
            ->requirePresence('CarrierName4RR', 'create')
            ->notEmptyString('CarrierName4RR');

        $validator
            ->scalar('TrackingNo4RR')
            ->maxLength('TrackingNo4RR', 50)
            ->requirePresence('TrackingNo4RR', 'create')
            ->notEmptyString('TrackingNo4RR');

        $validator
            ->scalar('CRNStatus')
            ->maxLength('CRNStatus', 2)
            ->requirePresence('CRNStatus', 'create')
            ->notEmptyString('CRNStatus');

        $validator
            ->scalar('CountyRejectionReason')
            ->requirePresence('CountyRejectionReason', 'create')
            ->notEmptyString('CountyRejectionReason');

        $validator
            ->scalar('CountyRejectionNote')
            ->requirePresence('CountyRejectionNote', 'create')
            ->notEmptyString('CountyRejectionNote');

        $validator
            ->scalar('CRNCarrierName4RR')
            ->maxLength('CRNCarrierName4RR', 100)
            ->requirePresence('CRNCarrierName4RR', 'create')
            ->notEmptyString('CRNCarrierName4RR');

        $validator
            ->scalar('CRNTrackingNo4RR')
            ->maxLength('CRNTrackingNo4RR', 50)
            ->requirePresence('CRNTrackingNo4RR', 'create')
            ->notEmptyString('CRNTrackingNo4RR');

        $validator
            ->date('CountyRejectionProcessingDate')
            ->requirePresence('CountyRejectionProcessingDate', 'create')
            ->notEmptyDate('CountyRejectionProcessingDate');

        $validator
            ->time('CountyRejectionProcessingTime')
            ->requirePresence('CountyRejectionProcessingTime', 'create')
            ->notEmptyTime('CountyRejectionProcessingTime');

        $validator
            ->scalar('SentToPartner')
            ->maxLength('SentToPartner', 1)
            ->requirePresence('SentToPartner', 'create')
            ->notEmptyString('SentToPartner');

        $validator
            ->date('LastModified')
            ->allowEmptyDate('LastModified');

        $validator
            ->integer('UserId')
            ->requirePresence('UserId', 'create')
            ->notEmptyString('UserId');

        $validator
            ->date('QCProcessingDate')
            ->requirePresence('QCProcessingDate', 'create')
            ->notEmptyDate('QCProcessingDate');

        $validator
            ->time('QCProcessingTime')
            ->requirePresence('QCProcessingTime', 'create')
            ->notEmptyTime('QCProcessingTime'); */

        return $validator;
    }


    public function insertNewQcData($fmdId,$doctype,$currentUserId){
		 
		$exist = $this->exists(['RecId' => $fmdId, 'TransactionType' => $doctype]);
		if(!$exist){
			$filesQcData = $this->newEmptyEntity();
			$insertQcData = [
								'RecId' => $fmdId,
								'TransactionType' => $doctype,
								'UserId' => $currentUserId,
                                'Status'=> ''
							];
			$filesQcData = $this->patchEntity($filesQcData, $insertQcData,['validate' => false]);
			$this->save($filesQcData);
		}
		return true;
	}
 
	public function getQCData($fmdId, $doctype=''){
		
		$query = $this->find()
		->where(['RecId'=>$fmdId])
		->select(['Id','TransactionType', 'Status', 'TrackingNo4RR', 'RejectionReason', 'LastModified', 'QCProcessingDate'])
        ->disableHydration();

		if(!empty($doctype)) $query = $query->where(['TransactionType'=> $doctype]);
		
		$results = $query->toArray();
		 if(!empty($results)) return $results[0];
	}
    
    public function checkQCreject($PartnerFileNumber, $TransactionType, $company_id){
        $query =  $this->find()->join([
            'table' => 'files_main_data'.ARCHIVE_PREFIX,
            'alias' => 'fmd',
            'type' => 'RIGHT OUTER',
            'conditions' => ['FilesQcData.RecId = fmd.Id']
        ])
        ->where(['fmd.PartnerFileNumber'=>$PartnerFileNumber, 'fmd.TransactionType'=>$TransactionType, 'fmd.company_id'=>$company_id, 'FilesQcData.Id != '=>0])
        ->select(['fmd.NATFileNumber', 'fmd.Id','FilesQcData.Id', 'FilesQcData.Status'])->order(['FilesQcData.Id'=>'desc'])->limit(1);
        //debug($query->sql());
        $data = $query->disableHydration()->all()->toArray();
  
        return $data;
    } 

    public function saveQCData(array $qcData){
		
		$filesQcData = $this->newEmptyEntity();
		$filesQcData = $this->patchEntity($filesQcData, $qcData,['validate' => false]);
		if($this->save($filesQcData)) 
			return true;  
		else 
			return false;
	}
	
	public function updateQCData($id, array $data)
	{
		$filesQcData = $this->get($id);
		$filesQcData = $this->patchEntity($filesQcData, $data,['validate' => false]);
		if ($this->save($filesQcData))
			return true;
		else 
			return false;
	}

    public function getfilesQcData($recordMainId,$doctype){
        $search =[ 				
                   "qcId" => "FilesQcData.Id",
                   "Status" => "FilesQcData.Status",
                   "RejectionReason" => "FilesQcData.RejectionReason",   
                   "TrackingNo4RR" => "FilesQcData.TrackingNo4RR",
                   "QCProcessingDate" => "FilesQcData.QCProcessingDate"
               ];

       $result  = $this->find()
                   ->select($search)
                   ->where(['FilesQcData.RecId'=>$recordMainId, 'FilesQcData.TransactionType'=>$doctype])
                   ->limit(1)
                   ->order('FilesQcData.Id')
                   ->All()
                   ->toArray();
                   
       $FilesQcData = (!empty($result)) ? $result[0] : '';
       
       if(empty($FilesQcData)){
           $FilesQcData =  $this;
       }
       return $FilesQcData;
   }

   public function getNewFilesQcData($recordMainId,$doctype){
        $search =[
                "RecId" => "FilesQcData.RecId",
                "TransactionType" => "FilesQcData.TransactionType"
                ];
        
        $result  = $this->find()->select($search)->where(['FilesQcData.RecId'=>$recordMainId, 'FilesQcData.TransactionType'=>$doctype,"FilesQcData.Status !=" => ""])->limit(1)->all()->toArray();
        
        $filesQcData = (!empty($result)) ? $result[0] : [];
        
        return $filesQcData;
    }

    public function getQCStatusData($fmdId, $doctype=''){
		
		$query = $this->find()
		->where(['RecId'=>$fmdId])
		->select(['Status'])
        ->disableHydration();

		if(!empty($doctype)) $query = $query->where(['TransactionType'=> $doctype]);
		
		$results = $query->toArray();
		 if(!empty($results)) return $results[0];
	}
}
