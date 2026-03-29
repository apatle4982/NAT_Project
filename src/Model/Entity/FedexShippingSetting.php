<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FedexShippingSetting Entity
 *
 * @property int $user_id
 * @property string $user_email
 * @property string|null $sender
 * @property string $shipping_mode
 * @property string|null $s_account_no
 * @property string|null $s_meter_no
 * @property string|null $s_company_name
 * @property string|null $s_address
 * @property string $s_address1
 * @property string|null $s_City
 * @property string|null $s_zip
 * @property string|null $s_State
 * @property string|null $s_country
 * @property int $s_paymentType
 * @property string $s_depName
 * @property string $s_delCountry
 * @property int $s_height
 * @property int $s_width
 * @property int $s_length
 * @property string $s_defaultCurrency
 * @property string $s_fedexWeight
 * @property int $s_packageNum
 * @property string $s_hDelivery
 * @property string $s_sDelivery
 * @property string $s_dropType
 * @property string $s_labelType
 * @property string $s_printerType
 * @property string $s_labelMedia
 */
class FedexShippingSetting extends Entity
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
        'user_email' => true,
        'sender' => true,
        'shipping_mode' => true,
        's_account_no' => true,
        's_meter_no' => true,
        's_company_name' => true,
        's_address' => true,
        's_address1' => true,
        's_City' => true,
        's_zip' => true,
        's_State' => true,
        's_country' => true,
        's_paymentType' => true,
        's_depName' => true,
        's_delCountry' => true,
        's_height' => true,
        's_width' => true,
        's_length' => true,
        's_defaultCurrency' => true,
        's_fedexWeight' => true,
        's_packageNum' => true,
        's_hDelivery' => true,
        's_sDelivery' => true,
        's_dropType' => true,
        's_labelType' => true,
        's_printerType' => true,
        's_labelMedia' => true,
        's_name' => true,
        's_number' => true,
        's_fedexWeight_unit' => true,
    ];
}
