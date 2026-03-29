<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class FilesAttorneyAssignmentTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('files_attorney_assignment'); // Table name
        $this->setPrimaryKey('Id'); // Primary key
        $this->setDisplayField('Id'); // Display field

        $this->belongsTo('Vendors', [
            'foreignKey' => 'vendorid',
            'propertyName' => 'vendor_data', // <-- custom property name to avoid clash
            'joinType' => 'INNER',
        ]);
    }
}
