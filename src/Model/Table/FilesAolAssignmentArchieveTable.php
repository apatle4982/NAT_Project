<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class FilesAolAssignmentArchieveTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('files_aol_assignment_archieve');
        $this->setPrimaryKey('Id'); // same structure assumed
    }
}
