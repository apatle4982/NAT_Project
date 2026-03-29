<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class NatServicesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // If necessary, specify the table name explicitly
        $this->setTable('nat_services');  // This is optional if your table is named 'nat_services'
    }
}
