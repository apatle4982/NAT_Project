<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class AttorneyReview extends Entity
{
    protected $_accessible = [
    'Id' => true, // Primary Key
    'RecId' => true, // Ensure RecId is assignable
    'status' => true,
    'comment' => true,
    'supporting_documentation' => true,
    'notes_clearing_curative' => true,
    'created_date' => true,
    '*' => true // Allow other fields to be assigned dynamically
];
}
