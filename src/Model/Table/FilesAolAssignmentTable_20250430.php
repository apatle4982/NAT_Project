<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class FilesAolAssignmentTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('files_aol_assignment'); // Table name
        $this->setPrimaryKey('Id'); // Primary key
        $this->setDisplayField('Id'); // Display field
    }
}
