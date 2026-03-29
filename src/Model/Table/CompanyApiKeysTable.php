<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;
use Cake\ORM\Query;

/**
 * VendorApiKeys Model
 *
 * @property \App\Model\Table\CompanyMstTable&\Cake\ORM\Association\BelongsTo $CompanyMAst
 */
class CompanyApiKeysTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('company_api_keys');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('CompanyMst', [
            'className' => 'CompanyMst',
            'foreignKey' => 'company_id',
            'joinType' => 'INNER',
        ]);
    }

    public function findSearch(Query $query, array $options)
    {
        if (!empty($options['search'])) {
            $search = $options['search'];
            $query->where([
                'OR' => [
                    'CompanyApiKeys.secret_key LIKE' => '%' . $search . '%',
                    'CompanyMst.cm_comp_name LIKE' => '%' . $search . '%'
                ]
            ]);
        }

        return $query;
    }
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('secret_key')
            ->maxLength('secret_key', 255)
            ->requirePresence('secret_key', 'create')
            ->notEmptyString('secret_key');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        $validator
            ->integer('company_id')
            ->requirePresence('company_id', 'create')
            ->notEmptyString('company_id');

        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        // Ensure company_id is unique
        $rules->add($rules->isUnique(
            ['company_id'],
            'This partner already has an API key.'
        ));

        return $rules;
    }
}