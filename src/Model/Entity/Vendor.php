<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Vendor extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
