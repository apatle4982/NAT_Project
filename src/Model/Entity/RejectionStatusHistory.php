<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RejectionStatusHistory Entity
 *
 * @property int $Id
 * @property int $RecId
 * @property int $TransactionType
 * @property string|null $Type
 * @property string $RejectionReasonStatus
 * @property string $StatusNote
 * @property string|null $StatusReason
 * @property \Cake\I18n\FrozenTime|null $LastModified
 * @property \Cake\I18n\FrozenTime|null $DateCreated
 * @property string|null $ClearanceNote
 */
class RejectionStatusHistory extends Entity
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
        'RecId' => true,
        'TransactionType' => true,
        'Type' => true,
        'RejectionReasonStatus' => true,
        'StatusNote' => true,
        'StatusReason' => true,
        'LastModified' => true,
        'DateCreated' => true,
        'ClearanceNote' => true,
    ];
}
