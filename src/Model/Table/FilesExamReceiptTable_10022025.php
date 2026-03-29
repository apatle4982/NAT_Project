<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class FilesExamReceiptTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // Set the table name
        $this->setTable('files_exam_receipt');
        // Set the primary key
        $this->setPrimaryKey('id');
        // Enable timestamps
        $this->addBehavior('Timestamp');
    }

}