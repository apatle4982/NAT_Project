<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FedexShippingSetting Model
 *
 * @method \App\Model\Entity\FedexShippingSetting newEmptyEntity()
 * @method \App\Model\Entity\FedexShippingSetting newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FedexShippingSetting[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FedexShippingSetting get($primaryKey, $options = [])
 * @method \App\Model\Entity\FedexShippingSetting findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FedexShippingSetting patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FedexShippingSetting[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FedexShippingSetting|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FedexShippingSetting saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FedexShippingSetting[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FedexShippingSetting[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FedexShippingSetting[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FedexShippingSetting[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FedexShippingSettingTable extends Table
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

        $this->setTable('fedex_shipping_setting');
        $this->setDisplayField('user_id');
        $this->setPrimaryKey('user_id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    /*public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('user_email')
            ->maxLength('user_email', 255)
            ->requirePresence('user_email', 'create')
            ->notEmptyString('user_email');

        $validator
            ->scalar('sender')
            ->maxLength('sender', 100)
            ->allowEmptyString('sender');

        $validator
            ->scalar('shipping_mode')
            ->notEmptyString('shipping_mode');

        $validator
            ->scalar('s_account_no')
            ->maxLength('s_account_no', 100)
            ->allowEmptyString('s_account_no');

        $validator
            ->scalar('s_meter_no')
            ->maxLength('s_meter_no', 100)
            ->allowEmptyString('s_meter_no');

        $validator
            ->scalar('s_company_name')
            ->maxLength('s_company_name', 250)
            ->allowEmptyString('s_company_name');

        $validator
            ->scalar('s_address')
            ->allowEmptyString('s_address');

        $validator
            ->scalar('s_address1')
            ->requirePresence('s_address1', 'create')
            ->notEmptyString('s_address1');

        $validator
            ->scalar('s_City')
            ->maxLength('s_City', 50)
            ->allowEmptyString('s_City');

        $validator
            ->scalar('s_zip')
            ->maxLength('s_zip', 50)
            ->allowEmptyString('s_zip');

        $validator
            ->scalar('s_State')
            ->maxLength('s_State', 50)
            ->allowEmptyString('s_State');

        $validator
            ->scalar('s_country')
            ->maxLength('s_country', 50)
            ->allowEmptyString('s_country');

        $validator
            ->integer('s_paymentType')
            ->requirePresence('s_paymentType', 'create')
            ->notEmptyString('s_paymentType');

        $validator
            ->scalar('s_depName')
            ->maxLength('s_depName', 100)
            ->requirePresence('s_depName', 'create')
            ->notEmptyString('s_depName');

        $validator
            ->scalar('s_delCountry')
            ->maxLength('s_delCountry', 100)
            ->requirePresence('s_delCountry', 'create')
            ->notEmptyString('s_delCountry');

        $validator
            ->integer('s_height')
            ->requirePresence('s_height', 'create')
            ->notEmptyString('s_height');

        $validator
            ->integer('s_width')
            ->requirePresence('s_width', 'create')
            ->notEmptyString('s_width');

        $validator
            ->integer('s_length')
            ->requirePresence('s_length', 'create')
            ->notEmptyString('s_length');

        $validator
            ->scalar('s_defaultCurrency')
            ->maxLength('s_defaultCurrency', 25)
            ->requirePresence('s_defaultCurrency', 'create')
            ->notEmptyString('s_defaultCurrency');

        $validator
            ->scalar('s_fedexWeight')
            ->maxLength('s_fedexWeight', 25)
            ->requirePresence('s_fedexWeight', 'create')
            ->notEmptyString('s_fedexWeight');

        $validator
            ->integer('s_packageNum')
            ->requirePresence('s_packageNum', 'create')
            ->notEmptyString('s_packageNum');

        $validator
            ->scalar('s_hDelivery')
            ->maxLength('s_hDelivery', 25)
            ->requirePresence('s_hDelivery', 'create')
            ->notEmptyString('s_hDelivery');

        $validator
            ->scalar('s_sDelivery')
            ->maxLength('s_sDelivery', 25)
            ->requirePresence('s_sDelivery', 'create')
            ->notEmptyString('s_sDelivery');

        $validator
            ->scalar('s_dropType')
            ->maxLength('s_dropType', 25)
            ->requirePresence('s_dropType', 'create')
            ->notEmptyString('s_dropType');

        $validator
            ->scalar('s_labelType')
            ->maxLength('s_labelType', 25)
            ->requirePresence('s_labelType', 'create')
            ->notEmptyString('s_labelType');

        $validator
            ->scalar('s_printerType')
            ->maxLength('s_printerType', 25)
            ->requirePresence('s_printerType', 'create')
            ->notEmptyString('s_printerType');

        $validator
            ->scalar('s_labelMedia')
            ->maxLength('s_labelMedia', 25)
            ->requirePresence('s_labelMedia', 'create')
            ->notEmptyString('s_labelMedia');

        return $validator;
    }*/


    public function getShippingData(){
		 
		$result  = $this->find()->limit(1)->all()->toArray();
		
		$shippingData = (!empty($result)) ? $result[0] : [];
		 
		return $shippingData;

	}
}
