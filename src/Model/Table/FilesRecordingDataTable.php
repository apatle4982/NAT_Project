<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * FilesRecordingData Model
 *
 * @method \App\Model\Entity\FilesRecordingData newEmptyEntity()
 * @method \App\Model\Entity\FilesRecordingData newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FilesRecordingData[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FilesRecordingData get($primaryKey, $options = [])
 * @method \App\Model\Entity\FilesRecordingData findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FilesRecordingData patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FilesRecordingData[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FilesRecordingData|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesRecordingData saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesRecordingData[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesRecordingData[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesRecordingData[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesRecordingData[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FilesRecordingDataTable extends Table
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

        $this->setTable('files_recording_data'.ARCHIVE_PREFIX);
        $this->setDisplayField('Id');
        $this->setPrimaryKey('Id');
        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');    
        $this->addBehavior('CustomLRS');
        $this->setAlias('frd');
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
            ->date('RecordingProcessingDate')
            ->requirePresence('RecordingProcessingDate', 'create')
            ->notEmptyDate('RecordingProcessingDate');

        $validator
            ->time('RecordingProcessingTime')
            ->requirePresence('RecordingProcessingTime', 'create')
            ->notEmptyTime('RecordingProcessingTime');

        $validator
            ->date('RecordingDate')
            ->allowEmptyDate('RecordingDate');

        $validator
            ->time('RecordingTime')
            ->allowEmptyTime('RecordingTime');

        $validator
            ->scalar('InstrumentNumber')
            ->maxLength('InstrumentNumber', 50)
            ->allowEmptyString('InstrumentNumber');

        $validator
            ->scalar('Book')
            ->maxLength('Book', 50)
            ->allowEmptyString('Book');

        $validator
            ->scalar('Page')
            ->maxLength('Page', 25)
            ->allowEmptyString('Page');

        $validator
            ->scalar('Pages')
            ->maxLength('Pages', 10)
            ->requirePresence('Pages', 'create')
            ->notEmptyString('Pages');

        $validator
            ->scalar('DocumentNumber')
            ->maxLength('DocumentNumber', 50)
            ->requirePresence('DocumentNumber', 'create')
            ->notEmptyString('DocumentNumber');

        $validator
            ->date('EffectiveDate')
            ->allowEmptyDate('EffectiveDate');

        $validator
            ->scalar('TrackingNumber')
            ->maxLength('TrackingNumber', 100)
            ->requirePresence('TrackingNumber', 'create')
            ->notEmptyString('TrackingNumber');

        $validator
            ->scalar('File')
            ->maxLength('File', 100)
            ->requirePresence('File', 'create')
            ->notEmptyString('File');

        $validator
            ->integer('UserId')
            ->requirePresence('UserId', 'create')
            ->notEmptyString('UserId');

        $validator
            ->scalar('RecordingNotes')
            ->requirePresence('RecordingNotes', 'create')
            ->notEmptyString('RecordingNotes');

        $validator
            ->scalar('RejectionFromCounty')
            ->maxLength('RejectionFromCounty', 1)
            ->requirePresence('RejectionFromCounty', 'create')
            ->notEmptyString('RejectionFromCounty');

        $validator
            ->scalar('RejectionReason')
            ->requirePresence('RejectionReason', 'create')
            ->notEmptyString('RejectionReason');

        $validator
            ->scalar('sheet_generate')
            ->maxLength('sheet_generate', 1)
            ->requirePresence('sheet_generate', 'create')
            ->notEmptyString('sheet_generate');

        $validator
            ->scalar('pdf_generate')
            ->maxLength('pdf_generate', 1)
            ->requirePresence('pdf_generate', 'create')
            ->notEmptyString('pdf_generate');

        $validator
            ->integer('KNI')
            ->notEmptyString('KNI');

        $validator
            ->scalar('hard_copy_received')
            ->maxLength('hard_copy_received', 1)
            ->notEmptyString('hard_copy_received'); */

        return $validator;
    }

    public function filecheckinQuery(array $whereCondition, array $pdata, $cm_partner_cmp = ''){

        $FilesExamReceiptTable = TableRegistry::getTableLocator()->get('FilesMainData');
        $FilesExamReceiptTable->setAlias('fmd');

        $query = $FilesExamReceiptTable->find('search', $pdata['condition'])
                ->join([
                    'table' => 'files_recording_data',
                    'alias' => 'frd',
                    'type' => 'LEFT',
                    'conditions' => 'fmd.Id = frd.RecId'
                ])
                ->join([
                    'table' => 'document_type_mst',
                    'alias' => 'dtm',
                    'type' => 'LEFT',
                    'conditions' => 'dtm.Id = fmd.TransactionType'
                ])
                ->join([
                    'table' => 'company_mst',
                    'alias' => 'cpm',
                    'type' => 'LEFT',
                    'conditions' => 'cpm.cm_id = fmd.company_id'
                ])
                ->join([
                    'table' => 'files_vendor_assignment',
                    'alias' => 'fva',
                    'type' => 'LEFT',
                    'conditions' => 'fva.RecId = fmd.Id'
                ])
                ->where($whereCondition)
                ->select("fva.vendorid");;

        //$tableFldCount = $this->tblFldCountExport($pdata['condition']['fields']);  
        //$query = $this->getOtherTableJoin($query, $tableFldCount,null, null, null, ['files_main_data'.ARCHIVE_PREFIX]);
        return $query;
        
    } 

    public function getMainDataAll($recordMainId){
        
        $search =[
                    "frd.RecordingProcessingDate", "frd.RecordingProcessingTime", "frd.RecordingDate", "frd.RecordingTime", "frd.InstrumentNumber", "frd.Book", "frd.Page", "frd.Pages", "frd.DocumentNumber", "frd.EffectiveDate", "frd.TrackingNumber", "frd.File", "frd.file_main_path", "frd.UserId", "frd.RecordingNotes", "frd.RejectionFromCounty", "frd.RejectionReason", "frd.sheet_generate", "frd.pdf_generate", "frd.KNI", "frd.hard_copy_received", "frd.created", "frd.modified", "users.user_name", "users.user_lastname", "users.user_email", "users.user_phone"
        ];

        $query = $this->find()
                        ->join([
                            'table' => 'files_main_data',
                            'alias' => 'fmd',
                            'type' => 'LEFT',
                            'conditions' => 'fmd.Id = frd.RecId'
                        ])
                        ->join([
                                'table' => 'users',
                                'alias' => 'users',
                                'type' => 'LEFT OUTER',
                                'conditions' => ['users.user_id = frd.user_id']
                        ]) 
                        ->where(['frd.RecId'=>$recordMainId])
                        ->select($search)->limit(1);
        $results = $query->toArray();
        return (!empty($results)) ? $results[0] : []; 

    }

    // generate PDF 
    public function updateRecordingData($recordId=null, $field){

        $dataRec = [];
        $filesRecData = $this->get($recordId);
        // expected one record // pfd_generate , hard_copy_received sheet_generate
        $dataRec[$field] = 'Y';
        
        $filesRecData = $this->patchEntity($filesRecData, $dataRec,['validate' => false]);

        if ($this->save($filesRecData))
            return true;
        else 
            return false;
    
    }

    public function getRecordingData($fmdId, $doctype = ''){
        $where  =['RecId'=>$fmdId];
        if(!empty($doctype)){
            $where = array_merge($where, ['TransactionType'=>$doctype]);
        }
        $query = $this->find()->where($where)->disableHydration();
        
        $results = $query->toArray();
        if(!empty($results)) return $results[0];
    }

    public function getRecordingDataEdit($fmdId, $doctype){
         
        $query  = $this->find()->where(['RecId'=>$fmdId, 'TransactionType'=>$doctype])->limit(1);
       
        $results  = $query->all()->toArray();
        $FilesRecordingData = (!empty($results)) ? $results[0] : [];
         
        return $FilesRecordingData;
    } 

    public function saveFRDData(array $data){
        
        $filesR2PData = $this->newEmptyEntity();
        $filesR2PData = $this->patchEntity($filesR2PData, $data,['validate' => false]);
        if($this->save($filesR2PData)) 
            return true; 
        else 
            return false;
    }

    public function updateFRDData($id, array $data)
    {
        $filesR2PData = $this->get($id); 
        $filesR2PData = $this->patchEntity($filesR2PData, $data,['validate' => false]);
        
        if ($this->save($filesR2PData))
            return true;
        else
            return false;
    }

    public function fetchRecordingDataCSC($fmdId, $doctype){
        
        $query = $this->find()->select('Id')
        ->where(['RecId'=>$fmdId, 'TransactionType '=>$doctype])->disableHydration(false);
        /* ->select(['Status', 'TrackingNo4RR', 'CRNStatus', 'CRNTrackingNo4RR', 'LastModified', 'LastModified', 'QCProcessingDate']) */
          
        $results = $query->toArray();
         if(!empty($results)) return $results[0];
    }

    public function fetchRecordingFilePath($fmdId, $doctype){
        
        $query = $this->find('all')->select(['file', 'file_main_path'])
        ->where(['RecId'=>$fmdId, 'TransactionType '=>$doctype])
        ->disableHydration(false);
      
        $results = $query->first();
        
        return $results;
       // if(!empty($results)) return $results[0];
    }


    public function updateAllSheetGenerate(array $ids)
    {
        $result = false;

        if(!empty($ids)){
            $ids = array_unique($ids);
            $result  = $this->updateAll(['sheet_generate'=>'Y'], ['Id IN'=>$ids]);
        }

        if ($result)
            return true;
        else 
            return false;

    }

    public function getRecordData($RecId) {
        return $this->find()
            ->where(['RecId' => $RecId])
            ->first(); // Fetches only one result instead of a ResultSet
    }
    
}
