<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class CompanyApiKey extends Entity
{
    /* protected $_accessible = [
        '*' => true,
        'id' => false,
    ]; */

    protected $_accessible = [
        'company_id' => true,
        'secret_key' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
    ];
}