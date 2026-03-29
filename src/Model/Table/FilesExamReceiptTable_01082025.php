<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator; 
use Cake\ORM\TableRegistry;
/**
 * FilesExamReceipt Model
 *
 * @method \App\Model\Entity\FilesExamReceipt newEmptyEntity()
 * @method \App\Model\Entity\FilesExamReceipt newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FilesExamReceipt[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FilesExamReceipt get($primaryKey, $options = [])
 * @method \App\Model\Entity\FilesExamReceipt findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FilesExamReceipt patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FilesExamReceipt[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FilesExamReceipt|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesExamReceipt saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesExamReceipt[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesExamReceipt[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesExamReceipt[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesExamReceipt[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FilesExamReceiptTable extends Table
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

        $this->setTable('files_exam_receipt');
        $this->setAlias('fer');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');
        $this->searchManagerConfig();

        $this->addBehavior('CustomLRS');
        
    }


    public function searchManagerConfig()
    {
        $search = $this->searchManager();
       // $search = $this->behaviors()->Search->searchManager();
      
        $search->Value('TransactionType'); 
        $search->Value('company_id',['prifix'=>'fmd']);
         $search->Like('NATFileNumber',['prifix'=>'fmd']);
        $search->Like('PartnerFileNumber',['prifix'=>'fmd']);
    //  $search->Like('loan_number',['prifix'=>'fmd']);
        
    //  $search->Like('street_number',['prifix'=>'fmd']);
        $search->Like('StreetName',['prifix'=>'fmd']);
    //  $search->Like('city',['prifix'=>'fmd']);
        $search->Like('County',['prifix'=>'fmd']);
        $search->Like('State',['prifix'=>'fmd']);
    //  $search->Like('zip',['prifix'=>'fmd']);

        $search->Like('grantors_g1',['prifix'=>'fmd']);
    //  $search->Like('grantees_g2',['prifix'=>'fmd']);
        
    //  $search->Like('first_name_1_g1',['prifix'=>'fmd']);
    //  $search->Like('first_name_1_g2',['prifix'=>'fmd']);
        
        $search->Value('cm_partner_cmp',['prifix'=>'cpm']);  
    
    //  $search->Like('Status',['prifix'=>'fqd']);
        return $search;
    }

    public function getMainDataAll($recordMainId){
        
        $search =[
                    "fer.vesting_attributes", "fer.open_mortgage_attributes", "fer.open_judgments_attributes", "fer.OfficialPropertyAddress", "fer.VestingDeedType", "fer.VestingConsiderationAmount", "fer.VestedAsGrantee", "fer.VestingGrantor", "fer.VestingDated", "fer.VestingRecordedDate", "fer.VestingBookPage", "fer.VestingInstrument", "fer.VestingComments", "fer.OpenMortgageAmount", "fer.OpenMortgageDated", "fer.OpenMortgageRecordedDate", "fer.OpenMortgageBookPage", "fer.OpenMortgageInstrument", "fer.OpenMortgageBorrowerMortgagor", "fer.OpenMortgageLenderMortgagee", "fer.OpenMortgageTrustee1", "fer.OpenMortgageTrustee2", "fer.OpenMortgageComments", "fer.OpenJudgmentsType", "fer.OpenJudgmentsLienHolderPlaintiff", "fer.OpenJudgmentsBorrowerDefendant", "fer.OpenJudgmentsAmount", "fer.OpenJudgmentsDateEntered", "fer.OpenJudgmentsDateRecorded", "fer.OpenJudgmentsBookPage", "fer.OpenJudgmentsInstrument", "fer.OpenJudgmentsComments", "fer.TaxStatus", "fer.TaxYear", "fer.TaxAmount", "fer.TaxType", "fer.TaxPaymentSchedule", "fer.TaxDueDate", "fer.TaxDeliquentDate", "fer.TaxComments", "fer.TaxLandValue", "fer.TaxBuildingValue", "fer.TaxTotalValue", "fer.TaxAPNAccount", "fer.TaxAssessedYear", "fer.TaxTotalValue2", "fer.TaxMunicipalityCounty", "fer.LegalDescription", "fer.created", "fer.modified", "users.user_name", "users.user_lastname", "users.user_email", "users.user_phone"
        ];

        $query = $this->find()
                        ->join([
                            'table' => 'files_main_data',
                            'alias' => 'fmd',
                            'type' => 'LEFT',
                            'conditions' => 'fmd.Id = fer.RecId'
                        ])
                        ->join([
                                'table' => 'users',
                                'alias' => 'users',
                                'type' => 'LEFT OUTER',
                                'conditions' => ['users.user_id = fer.user_id']
                        ]) 
                        ->where(['fer.RecId'=>$recordMainId])
                        ->select($search)->limit(1);
        $results = $query->toArray();
        return (!empty($results)) ? $results[0] : []; 

    }

    public function get_examReceipt($id) {
        return $this->find()
            ->where(['id' => $id])
            ->first(); // Fetches only one result instead of a ResultSet
    }

    public function getRecordData($RecId) {
        return $this->find()
            ->where(['RecId' => $RecId])
            ->first(); // Fetches only one result instead of a ResultSet
    } 

    public function filecheckinQuery(array $whereCondition, array $pdata, $cm_partner_cmp = ''){

        $FilesExamReceiptTable = TableRegistry::getTableLocator()->get('FilesMainData');
        $FilesExamReceiptTable->setAlias('fmd');

        $query = $FilesExamReceiptTable->find('search', $pdata['condition'])
                ->join([
                    'table' => 'files_exam_receipt',
                    'alias' => 'fer',
                    'type' => 'LEFT',
                    'conditions' => 'fmd.Id = fer.RecId'
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
                ->where($whereCondition);

        //$tableFldCount = $this->tblFldCountExport($pdata['condition']['fields']);  
        //$query = $this->getOtherTableJoin($query, $tableFldCount,null, null, null, ['files_main_data'.ARCHIVE_PREFIX]);
        return $query;
        
    } 

    public function filecheckinQueryNew(array $whereCondition, array $pdata, $cm_partner_cmp = ''){

        $query = $this->find('search', $pdata['condition'])
                ->join([
                    'table' => 'files_main_data',
                    'alias' => 'fmd',
                    'type' => 'LEFT',
                    'conditions' => 'fmd.Id = fer.RecId'
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
                ->where($whereCondition);

        $tableFldCount = $this->tblFldCountExport($pdata['condition']['fields']);  
        //$query = $this->getOtherTableJoin($query, $tableFldCount,null, null, null, ['files_main_data'.ARCHIVE_PREFIX]);
        return $query;
        
    }
    
    public function getCheckInData($fmdId, $doctype = ''){
		
		$query = $this->find()
		->where(['RecId'=>$fmdId])
		->select(['Id','DocumentReceived']);
		
		if(!empty($doctype)) $query = $query->where(['TransactionType'=> $doctype]);
		
		$results = $query->disableHydration()->toArray();
		if(!empty($results)) return $results[0];
	}
 
}
