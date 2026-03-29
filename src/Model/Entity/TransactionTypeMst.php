<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DocumentTypeMst Entity
 *
 * @property int $Id
 * @property string $Title
 * @property int $status
 */
class TransactionTypeMst extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'Id' => true,
        'Title' => true,
        'document_Countycal_id' => true,
        'document_csc_id' => true,
        'document_simplifile_id' => true,
        'status' => true,
    ];
}
