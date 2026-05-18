<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CureExamResultsTable
 *
 * Stores extraction-result callbacks received from the CURE Flask app.
 * Table: cure_exam_results
 *
 * Mirror of the DatatraceApiLogsTable pattern. Phase 2 stores the full payload
 * as JSON for flexibility while the "Nat Data Field for DT" schema is finalized.
 * Phase 3 will add field-level extraction for the Receipt of Exam UI.
 */
class CureExamResultsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('cure_exam_results');
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
            ->scalar('nat_file_number')
            ->maxLength('nat_file_number', 64)
            ->requirePresence('nat_file_number', 'create')
            ->notEmptyString('nat_file_number');

        $validator
            ->scalar('status')
            ->maxLength('status', 20)
            ->notEmptyString('status');

        return $validator;
    }
}
