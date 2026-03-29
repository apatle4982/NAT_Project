<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FilesReturned2partner Entity
 *
 * @property int $Id
 * @property int $RecId
 * @property int $TransactionType
 * @property string $CarrierName
 * @property string $CarrierTrackingNo
 * @property int $UserId
 * @property \Cake\I18n\FrozenDate|null $RTPProcessingDate
 * @property \Cake\I18n\Time $RTPProcessingTime
 * @property string|null $dateDelivered
 * @property string|null $receipient
 * @property string|null $deliveredTo
 * @property string|null $receivedBy
 */
class FilesReturned2partner extends Entity
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
        'CarrierName' => true,
        'CarrierTrackingNo' => true,
        'UserId' => true,
        'RTPProcessingDate' => true,
        'RTPProcessingTime' => true,
        'dateDelivered' => true,
        'receipient' => true,
        'deliveredTo' => true,
        'receivedBy' => true,
    ];
}
