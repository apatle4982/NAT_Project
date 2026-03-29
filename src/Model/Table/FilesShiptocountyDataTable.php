<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FilesShiptoCountyData Model
 *
 * @method \App\Model\Entity\FilesShiptoCountyData newEmptyEntity()
 * @method \App\Model\Entity\FilesShiptoCountyData newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FilesShiptoCountyData[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FilesShiptoCountyData get($primaryKey, $options = [])
 * @method \App\Model\Entity\FilesShiptoCountyData findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FilesShiptoCountyData patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FilesShiptoCountyData[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FilesShiptoCountyData|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesShiptoCountyData saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesShiptoCountyData[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesShiptoCountyData[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesShiptoCountyData[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesShiptoCountyData[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FilesShiptoCountyDataTable extends Table
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

        $this->setTable('files_shiptoCounty_data'.ARCHIVE_PREFIX);
        $this->setDisplayField('Id');
        $this->setPrimaryKey('Id'); 
        
        $this->addBehavior('Search.Search');	
		$this->addBehavior('CustomLRS');
		
        $this->belongsTo('FilesMainData', [
            'foreignKey' => 'RecId',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('DocumentTypeMst', [
            'foreignKey' => 'TransactionType',
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
      /*   $validator
            ->integer('RecId')
            ->requirePresence('RecId', 'create')
            ->notEmptyString('RecId');

        $validator
            ->integer('TransactionType')
            ->requirePresence('TransactionType', 'create')
            ->notEmptyString('TransactionType');

        $validator
            ->scalar('CarrierName')
            ->maxLength('CarrierName', 100)
            ->allowEmptyString('CarrierName');

        $validator
            ->scalar('CarrierTrackingNo')
            ->maxLength('CarrierTrackingNo', 100)
            ->allowEmptyString('CarrierTrackingNo');

        $validator
            ->scalar('VendorID')
            ->maxLength('VendorID', 250)
            ->allowEmptyString('VendorID');

        $validator
            ->scalar('MappingCode')
            ->allowEmptyString('MappingCode');

        $validator
            ->scalar('FedexShipping')
            ->maxLength('FedexShipping', 1)
            ->notEmptyString('FedexShipping');

        $validator
            ->date('FedexMappingDate')
            ->requirePresence('FedexMappingDate', 'create')
            ->notEmptyDate('FedexMappingDate');

        $validator
            ->date('AddingDate')
            ->allowEmptyDate('AddingDate');

        $validator
            ->scalar('LabelImage')
            ->maxLength('LabelImage', 255)
            ->allowEmptyString('LabelImage');

        $validator
            ->scalar('Rate')
            ->maxLength('Rate', 100)
            ->allowEmptyString('Rate');

        $validator
            ->date('ShippingProcessingDate')
            ->allowEmptyDate('ShippingProcessingDate');

        $validator
            ->time('ShippingProcessingTime')
            ->requirePresence('ShippingProcessingTime', 'create')
            ->notEmptyTime('ShippingProcessingTime');

        $validator
            ->integer('UserId')
            ->requirePresence('UserId', 'create')
            ->notEmptyString('UserId');

        $validator
            ->date('DeliveryDate')
            ->requirePresence('DeliveryDate', 'create')
            ->notEmptyDate('DeliveryDate');

        $validator
            ->time('DeliveryTime')
            ->requirePresence('DeliveryTime', 'create')
            ->notEmptyTime('DeliveryTime');

        $validator
            ->scalar('DeliverySignature')
            ->maxLength('DeliverySignature', 250)
            ->requirePresence('DeliverySignature', 'create')
            ->notEmptyString('DeliverySignature');

        $validator
            ->scalar('Status')
            ->maxLength('Status', 50)
            ->requirePresence('Status', 'create')
            ->notEmptyString('Status');

        $validator
            ->scalar('RecipientCompany')
            ->maxLength('RecipientCompany', 255)
            ->requirePresence('RecipientCompany', 'create')
            ->notEmptyString('RecipientCompany');

        $validator
            ->scalar('DeliveredTo')
            ->maxLength('DeliveredTo', 255)
            ->requirePresence('DeliveredTo', 'create')
            ->notEmptyString('DeliveredTo');

        $validator
            ->scalar('ReceivedBy')
            ->maxLength('ReceivedBy', 255)
            ->requirePresence('ReceivedBy', 'create')
            ->notEmptyString('ReceivedBy');

        $validator
            ->date('DateDelivered')
            ->requirePresence('DateDelivered', 'create')
            ->notEmptyDate('DateDelivered');

        $validator
            ->date('FedexEntryDate')
            ->requirePresence('FedexEntryDate', 'create')
            ->notEmptyDate('FedexEntryDate'); */

        return $validator;
    }

    public function saveShippingData(array $data){
		
		$filesS2CData = $this->newEmptyEntity();
		$filesS2CData = $this->patchEntity($filesS2CData, $data);
 
		if ($this->save($filesS2CData))
			return true;
		else 
			return false; 
	}
	
	public function updateShippingData($id, array $data)
	{
		$filesS2CData = $this->get($id);
		// expected one record
		$filesS2CData = $this->patchEntity($filesS2CData, $data);
		
		if ($this->save($filesS2CData))
			return true;
		else 
			return false; 
	}

    public function getS2CEditData($fmdId, $doctype){
		
		$query = $this->find()
		->where(['RecId'=>$fmdId, 'TransactionType '=>$doctype])
		->select(['Id', 'CarrierName', 'CarrierTrackingNo', 'shipLabelURL', 'AddingDate', 'ShippingProcessingDate', 'ShippingProcessingTime']);

		$results = $query->toArray();
		 if(!empty($results)) return $results[0];
	}

	public function getS2CData($fmdId, $doctype){
		
		$query = $this->find()
		->where(['RecId'=>$fmdId, 'TransactionType '=>$doctype])
		/* ->select(['Status', 'TrackingNo4RR', 'CRNStatus', 'CRNTrackingNo4RR', 'LastModified', 'LastModified', 'QCProcessingDate']) */
		->disableHydration(false);

		$results = $query->toArray();
		 if(!empty($results)) return $results[0];
	}

    public function fetchS2CDataCSC($fmdId, $doctype){
		
		$query = $this->find()->select('Id')
		->where(['RecId'=>$fmdId, 'TransactionType '=>$doctype])
		/* ->select(['Status', 'TrackingNo4RR', 'CRNStatus', 'CRNTrackingNo4RR', 'LastModified', 'LastModified', 'QCProcessingDate']) */
		->disableHydration(false);

		$results = $query->toArray();
		 if(!empty($results)) return $results[0];
	}
}
