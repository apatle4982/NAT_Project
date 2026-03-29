<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FilesShiptoCountyData Entity
 *
 * @property int $id
 * @property int $RecId
 * @property int $TransactionType
 * @property string|null $CarrierName
 * @property string|null $CarrierTrackingNo
 * @property string|null $VendorID
 * @property string|null $MappingCode
 * @property string $FedexShipping
 * @property \Cake\I18n\FrozenDate $FedexMappingDate
 * @property \Cake\I18n\FrozenDate|null $AddingDate
 * @property string|null $LabelImage
 * @property string|null $Rate
 * @property \Cake\I18n\FrozenDate|null $ShippingProcessingDate
 * @property \Cake\I18n\Time $ShippingProcessingTime
 * @property int $UserId
 * @property \Cake\I18n\FrozenDate $DeliveryDate
 * @property \Cake\I18n\Time $DeliveryTime
 * @property string $DeliverySignature
 * @property string $Status
 * @property string $RecipientCompany
 * @property string $DeliveredTo
 * @property string $ReceivedBy
 * @property \Cake\I18n\FrozenDate $DateDelivered
 * @property \Cake\I18n\FrozenDate $FedexEntryDate
 *
 * @property \App\Model\Entity\FilesMainData $files_main_data
 */
class FilesShiptoCountyData extends Entity
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
        'shipLabelURL' => true,
        'VendorID' => true,
        'MappingCode' => true,
        'FedexShipping' => true,
        'FedexMappingDate' => true,
        'AddingDate' => true,
        'LabelImage' => true,
        'Rate' => true,
        'ShippingProcessingDate' => true,
        'ShippingProcessingTime' => true,
        'UserId' => true,
        'DeliveryDate' => true,
        'DeliveryTime' => true,
        'DeliverySignature' => true,
        'Status' => true,
        'RecipientCompany' => true,
        'DeliveredTo' => true,
        'ReceivedBy' => true,
        'DateDelivered' => true,
        'FedexEntryDate' => true,
        'files_main_data' => true,
    ];
}
