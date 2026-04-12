<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DatatraceApiLogsTable
 *
 * Stores every DataTrace API request and response for audit and debugging.
 * Table: datatrace_api_logs
 */
class DatatraceApiLogsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('datatrace_api_logs');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('rec_id')
            ->requirePresence('rec_id', 'create')
            ->notEmptyString('rec_id');

        $validator
            ->scalar('status')
            ->maxLength('status', 20)
            ->notEmptyString('status');

        return $validator;
    }
}
