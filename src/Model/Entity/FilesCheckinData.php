<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FilesCheckinData Entity
 *
 * @property int $Id
 * @property int $RecId
 * @property int $TransactionType
 * @property string $DocumentReceived
 * @property int $UserId
 * @property \Cake\I18n\FrozenDate $CheckInProcessingDate
 * @property \Cake\I18n\Time $CheckInProcessingTime
 * @property string|null $search_status
 * @property \Cake\I18n\FrozenDate|null $search_status_updated_date
 * @property string|null $barcode_generated
 * @property string $isnew
 */
class FilesCheckinData extends Entity
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
        'DocumentReceived' => true,
        'UserId' => true,
        'CheckInProcessingDate' => true,
        'CheckInProcessingTime' => true,
        'search_status' => true,
        'search_status_updated_date' => true,
        'barcode_generated' => true,
        'isnew' => true,
        'extension' =>true,
        'lock_status' =>true,
    ];
}
