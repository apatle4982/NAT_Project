<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FilesQcData Entity
 *
 * @property int $Id
 * @property int $RecId
 * @property int $TransactionType
 * @property string $Status
 * @property string|null $PRRCRNType
 * @property string $StatusNote
 * @property string $StatusReason
 * @property int $RejectionReason
 * @property string $CarrierName4RR
 * @property string $TrackingNo4RR
 * @property string $CRNStatus
 * @property string $CountyRejectionReason
 * @property string $CountyRejectionNote
 * @property string $CRNCarrierName4RR
 * @property string $CRNTrackingNo4RR
 * @property \Cake\I18n\FrozenDate $CountyRejectionProcessingDate
 * @property \Cake\I18n\Time $CountyRejectionProcessingTime
 * @property string $SentToPartner
 * @property \Cake\I18n\FrozenDate|null $LastModified
 * @property int $UserId
 * @property \Cake\I18n\FrozenDate $QCProcessingDate
 * @property \Cake\I18n\Time $QCProcessingTime
 */
class FilesQcData extends Entity
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
        'Status' => true,
        'PRRCRNType' => true,
        'StatusNote' => true,
        'StatusReason' => true,
        'RejectionReason' => true,
        'CarrierName4RR' => true,
        'TrackingNo4RR' => true,
        'CRNStatus' => true,
        'CountyRejectionReason' => true,
        'CountyRejectionNote' => true,
        'CRNCarrierName4RR' => true,
        'CRNTrackingNo4RR' => true,
        'CountyRejectionProcessingDate' => true,
        'CountyRejectionProcessingTime' => true,
        'SentToPartner' => true,
        'LastModified' => true,
        'UserId' => true,
        'QCProcessingDate' => true,
        'QCProcessingTime' => true,
    ];
}
