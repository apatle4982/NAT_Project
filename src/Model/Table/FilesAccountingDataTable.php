<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FilesAccountingData Model
 *
 * @method \App\Model\Entity\FilesAccountingData newEmptyEntity()
 * @method \App\Model\Entity\FilesAccountingData newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FilesAccountingData[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FilesAccountingData get($primaryKey, $options = [])
 * @method \App\Model\Entity\FilesAccountingData findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FilesAccountingData patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FilesAccountingData[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FilesAccountingData|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesAccountingData saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesAccountingData[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesAccountingData[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesAccountingData[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesAccountingData[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FilesAccountingDataTable extends Table
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

        $this->setTable('files_accounting_data'.ARCHIVE_PREFIX);
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
            ->scalar('CountyRecordingFee')
            ->maxLength('CountyRecordingFee', 25)
            ->allowEmptyString('CountyRecordingFee');

        $validator
            ->scalar('Taxes')
            ->maxLength('Taxes', 25)
            ->allowEmptyString('Taxes');

        $validator
            ->scalar('AdditionalFees')
            ->maxLength('AdditionalFees', 25)
            ->allowEmptyString('AdditionalFees');

        $validator
            ->scalar('Total')
            ->maxLength('Total', 25)
            ->allowEmptyString('Total');

        $validator
            ->integer('CheckNumber1')
            ->allowEmptyString('CheckNumber1');

        $validator
            ->integer('CheckNumber2')
            ->allowEmptyString('CheckNumber2');

        $validator
            ->numeric('EPortalActual')
            ->allowEmptyString('EPortalActual');

        $validator
            ->numeric('UploadedCountyrecordingfee')
            ->requirePresence('UploadedCountyrecordingfee', 'create')
            ->notEmptyString('UploadedCountyrecordingfee');

        $validator
            ->numeric('UploadedTaxes')
            ->requirePresence('UploadedTaxes', 'create')
            ->notEmptyString('UploadedTaxes');

        $validator
            ->numeric('UploadedAdditionalfees')
            ->requirePresence('UploadedAdditionalfees', 'create')
            ->notEmptyString('UploadedAdditionalfees');

        $validator
            ->numeric('UploadedTotal')
            ->requirePresence('UploadedTotal', 'create')
            ->notEmptyString('UploadedTotal');

        $validator
            ->dateTime('UploadedDateTime')
            ->requirePresence('UploadedDateTime', 'create')
            ->notEmptyDateTime('UploadedDateTime');

        $validator
            ->date('LastModified')
            ->requirePresence('LastModified', 'create')
            ->notEmptyDate('LastModified');

        $validator
            ->integer('UserId')
            ->requirePresence('UserId', 'create')
            ->notEmptyString('UserId');

        $validator
            ->scalar('AccountingNotes')
            ->requirePresence('AccountingNotes', 'create')
            ->notEmptyString('AccountingNotes');

        $validator
            ->scalar('AccountingProcessingDate')
            ->maxLength('AccountingProcessingDate', 20)
            ->allowEmptyString('AccountingProcessingDate');

        $validator
            ->time('AccountingProcessingTime')
            ->requirePresence('AccountingProcessingTime', 'create')
            ->notEmptyTime('AccountingProcessingTime');

        $validator
            ->scalar('CheckNumber')
            ->maxLength('CheckNumber', 50)
            ->requirePresence('CheckNumber', 'create')
            ->notEmptyString('CheckNumber');

        $validator
            ->scalar('ClearedBank')
            ->maxLength('ClearedBank', 10)
            ->requirePresence('ClearedBank', 'create')
            ->notEmptyString('ClearedBank');

        $validator
            ->numeric('ClearedAmount')
            ->requirePresence('ClearedAmount', 'create')
            ->notEmptyString('ClearedAmount');

        $validator
            ->date('CheckUpdatedDate')
            ->requirePresence('CheckUpdatedDate', 'create')
            ->notEmptyDate('CheckUpdatedDate');

        $validator
            ->scalar('jrf_cc_fees')
            ->maxLength('jrf_cc_fees', 25)
            ->allowEmptyString('jrf_cc_fees');

        $validator
            ->scalar('jrf_icg_fees')
            ->maxLength('jrf_icg_fees', 25)
            ->allowEmptyString('jrf_icg_fees');

        $validator
            ->scalar('jrf_curative')
            ->maxLength('jrf_curative', 25)
            ->allowEmptyString('jrf_curative');

        $validator
            ->scalar('jrf_final_fees')
            ->maxLength('jrf_final_fees', 25)
            ->allowEmptyString('jrf_final_fees');

        $validator
            ->scalar('tt_cc_fees')
            ->maxLength('tt_cc_fees', 25)
            ->allowEmptyString('tt_cc_fees');

        $validator
            ->scalar('tt_icg_fees')
            ->maxLength('tt_icg_fees', 25)
            ->allowEmptyString('tt_icg_fees');

        $validator
            ->scalar('tt_curative')
            ->maxLength('tt_curative', 25)
            ->allowEmptyString('tt_curative');

        $validator
            ->scalar('tt_final_fees')
            ->maxLength('tt_final_fees', 25)
            ->allowEmptyString('tt_final_fees');

        $validator
            ->scalar('it_cc_fees')
            ->maxLength('it_cc_fees', 25)
            ->allowEmptyString('it_cc_fees');

        $validator
            ->scalar('it_icg_fees')
            ->maxLength('it_icg_fees', 25)
            ->allowEmptyString('it_icg_fees');

        $validator
            ->scalar('it_curative')
            ->maxLength('it_curative', 25)
            ->allowEmptyString('it_curative');

        $validator
            ->scalar('it_final_fees')
            ->maxLength('it_final_fees', 25)
            ->allowEmptyString('it_final_fees');

        $validator
            ->scalar('ot_cc_fees')
            ->maxLength('ot_cc_fees', 25)
            ->allowEmptyString('ot_cc_fees');

        $validator
            ->scalar('ot_icg_fees')
            ->maxLength('ot_icg_fees', 25)
            ->allowEmptyString('ot_icg_fees');

        $validator
            ->scalar('ot_curative')
            ->maxLength('ot_curative', 25)
            ->allowEmptyString('ot_curative');

        $validator
            ->scalar('ot_final_fees')
            ->maxLength('ot_final_fees', 25)
            ->allowEmptyString('ot_final_fees');

        $validator
            ->scalar('ns_cc_fees')
            ->maxLength('ns_cc_fees', 25)
            ->allowEmptyString('ns_cc_fees');

        $validator
            ->scalar('ns_icg_fees')
            ->maxLength('ns_icg_fees', 25)
            ->allowEmptyString('ns_icg_fees');

        $validator
            ->scalar('ns_curative')
            ->maxLength('ns_curative', 25)
            ->allowEmptyString('ns_curative');

        $validator
            ->scalar('ns_final_fees')
            ->maxLength('ns_final_fees', 25)
            ->allowEmptyString('ns_final_fees');

        $validator
            ->scalar('wu_cc_fees')
            ->maxLength('wu_cc_fees', 25)
            ->allowEmptyString('wu_cc_fees');

        $validator
            ->scalar('wu_icg_fees')
            ->maxLength('wu_icg_fees', 25)
            ->allowEmptyString('wu_icg_fees');

        $validator
            ->scalar('wu_curative')
            ->maxLength('wu_curative', 25)
            ->allowEmptyString('wu_curative');

        $validator
            ->scalar('wu_final_fees')
            ->maxLength('wu_final_fees', 25)
            ->allowEmptyString('wu_final_fees');

        $validator
            ->scalar('of_cc_fees')
            ->maxLength('of_cc_fees', 25)
            ->allowEmptyString('of_cc_fees');

        $validator
            ->scalar('of_icg_fees')
            ->maxLength('of_icg_fees', 25)
            ->allowEmptyString('of_icg_fees');

        $validator
            ->scalar('of_curative')
            ->maxLength('of_curative', 25)
            ->allowEmptyString('of_curative');

        $validator
            ->scalar('of_final_fees')
            ->maxLength('of_final_fees', 25)
            ->allowEmptyString('of_final_fees');

        $validator
            ->scalar('total_cc_fees')
            ->maxLength('total_cc_fees', 25)
            ->allowEmptyString('total_cc_fees');

        $validator
            ->scalar('total_icg_fees')
            ->maxLength('total_icg_fees', 25)
            ->allowEmptyString('total_icg_fees');

        $validator
            ->scalar('total_curative')
            ->maxLength('total_curative', 25)
            ->allowEmptyString('total_curative');

        $validator
            ->scalar('total_final_fees')
            ->maxLength('total_final_fees', 25)
            ->allowEmptyString('total_final_fees');

        $validator
            ->scalar('check_cleared')
            ->maxLength('check_cleared', 10)
            ->allowEmptyString('check_cleared'); */

        return $validator;
    }
	 
	public function getfilesACData($recordMainId,$doctype){
		$search =[ 				
					"accountId" => "FilesAccountingData.Id",
					"CountyRecordingFee" => "FilesAccountingData.CountyRecordingFee",
					"Taxes" => "FilesAccountingData.Taxes ",
					"AdditionalFees" => "FilesAccountingData.AdditionalFees",
					"Total" => "FilesAccountingData.Total",
					"AccountingNotes" => "FilesAccountingData.AccountingNotes",
					"CheckNumber1" => "FilesAccountingData.CheckNumber1",
					"CheckNumber2" => "FilesAccountingData.CheckNumber1",
					"CheckNumber3" => "FilesAccountingData.CheckNumber1",
					"AccountingProcessingDate" => "FilesAccountingData.AccountingProcessingDate"
				];
		
		//$query  = $this->find()->select($search)->where(['FilesAccountingData.RecId'=>$recordMainId, 'FilesAccountingData.TransactionType'=>$doctype]);
		$query  = $this->find()->select()->where(['FilesAccountingData.RecId'=>$recordMainId, 'FilesAccountingData.TransactionType'=>$doctype]);
		
		$result = $query->disableHydration(false)->limit(1)->All()->toArray();
		
		if(!empty($result)){
			$result =  $result[0];
		}
		
		return $result;
	}

    public function getfilesAccountingData($recordMainId,$doctype){
		$search =[ 				
					"accountId" => "FilesAccountingData.Id",
                    "RecId" => "FilesAccountingData.RecId",
                    "Total" => "FilesAccountingData.Total",
                    "AdditionalFees" => "FilesAccountingData.AdditionalFees",
                    "Taxes" => "FilesAccountingData.Taxes",
                    "CountyRecordingFee" => "FilesAccountingData.CountyRecordingFee",
                        
					"jrf_cc_fees" => "FilesAccountingData.jrf_cc_fees",
					"jrf_icg_fees" => "FilesAccountingData.jrf_icg_fees",
					"jrf_curative" => "FilesAccountingData.jrf_curative",
					"jrf_final_fees" => "FilesAccountingData.jrf_final_fees",
					"tt_cc_fees" => "FilesAccountingData.tt_cc_fees",
					"tt_icg_fees" => "FilesAccountingData.tt_icg_fees", 
                    "tt_curative" => "FilesAccountingData.tt_curative",
					"tt_final_fees" => "FilesAccountingData.tt_final_fees",
                    "it_cc_fees" => "FilesAccountingData.it_cc_fees",
					"it_icg_fees" => "FilesAccountingData.it_icg_fees", 
                    "it_curative" => "FilesAccountingData.it_curative",
					"it_final_fees" => "FilesAccountingData.it_final_fees",
                    "ot_cc_fees" => "FilesAccountingData.ot_cc_fees",
					"ot_icg_fees" => "FilesAccountingData.ot_icg_fees", 
                    "ot_curative" => "FilesAccountingData.ot_curative",
					"ot_final_fees" => "FilesAccountingData.ot_final_fees",
                    "ns_cc_fees" => "FilesAccountingData.ns_cc_fees",
					"ns_icg_fees" => "FilesAccountingData.ns_icg_fees", 
                    "ns_curative" => "FilesAccountingData.ns_curative",
					"ns_final_fees" => "FilesAccountingData.ns_final_fees",
                    "wu_cc_fees" => "FilesAccountingData.wu_cc_fees",
					"wu_icg_fees" => "FilesAccountingData.wu_icg_fees", 
                    "wu_curative" => "FilesAccountingData.wu_curative",
					"wu_final_fees" => "FilesAccountingData.wu_final_fees",
                    "of_cc_fees" => "FilesAccountingData.of_cc_fees",
					"of_icg_fees" => "FilesAccountingData.of_icg_fees", 
                    "of_curative" => "FilesAccountingData.of_curative",
					"of_final_fees" => "FilesAccountingData.of_final_fees",
                    "total_cc_fees" => "FilesAccountingData.total_cc_fees",
					"total_icg_fees" => "FilesAccountingData.total_icg_fees", 
                    "total_curative" => "FilesAccountingData.total_curative",
					"total_final_fees" => "FilesAccountingData.total_final_fees",
                    "check_cleared" => "FilesAccountingData.check_cleared",
					"AccountingProcessingDate" => "FilesAccountingData.AccountingProcessingDate"
				];
		
		$result  = $this->find()->select($search)->where(['FilesAccountingData.RecId'=>$recordMainId, 'FilesAccountingData.TransactionType'=>$doctype])->limit(1)->all()->toArray();
		
		$filesAccountingData = (!empty($result)) ? $result[0] : [];
		 
		return $filesAccountingData;

	}

    public function insertNewAccountData(array $insertAccountData){
		
		$filesAccountingData = $this->newEmptyEntity();
		$filesAccountingData = $this->patchEntity($filesAccountingData, $insertAccountData,['validate' => false]);
		if($this->save($filesAccountingData)) 
			return true;
		else 
			return false;
	}

    public function updateAccountData($id, array $data)
	{
		$filesAccountingData = $this->get($id); 
		$filesAccountingData = $this->patchEntity($filesAccountingData, $data,['validate' => false]);
		
		if ($this->save($filesAccountingData))
			return true;
		else 
			return false;
	}

// TODO data
    public function updateAccountDataCSC($id, $data)
	{
		$filesAccountingData = $this->get($id); 
		$filesAccountingData = $this->patchEntity($filesAccountingData, $data,['validate' => false]);
		
		if ($this->save($filesAccountingData))
			return true;
		else 
			return false;
	}
}
