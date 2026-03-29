<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CompanyMst Entity
 *
 * @property int $cm_id
 * @property string|null $cm_sales_representative
 * @property string|null $cm_comp_name
 * @property string|null $cm_proper_name
 * @property string|null $cm_first_name
 * @property string|null $cm_last_name
 * @property string|null $cm_url
 * @property string|null $cm_logo
 * @property string|null $cm_address
 * @property string|null $cm_address1
 * @property string|null $cm_City
 * @property string|null $cm_State
 * @property string|null $cm_zip
 * @property string|null $cm_County
 * @property string|null $cm_phone
 * @property string|null $cm_fax
 * @property string|null $cm_email
 * @property string|null $cm_partner
 * @property string|null $cm_ownedBy
 * @property string|null $cm_partner_cmp
 * @property string|null $cm_partner_type
 * @property string|null $cm_clients
 * @property string|null $cm_delivery_add1
 * @property string|null $cm_delivery_add2
 * @property string|null $cm_delivery_zip
 * @property string|null $cm_delivery_City
 * @property string|null $cm_delivery_State
 * @property string|null $cm_delivery_County
 * @property string $cm_enabled
 * @property string $cm_approved
 * @property string $cm_pricingInfo
 * @property string $cm_specialInst
 * @property string $cm_checkinsheet_prefix
 * @property string $cm_qcsheet_prefix
 * @property string $cm_accsheet_prefix
 * @property string $cm_recsheet_prefix
 * @property string $cm_s2csheet_prefix
 * @property string $cm_rf2psheet_prefix
 * @property string $cm_cmposheet_prefix
 * @property string $cm_mssheet_prefix
 * @property string $cm_checkinsheet_dt
 * @property string $cm_qcsheet_dt
 * @property string $cm_accsheet_dt
 * @property string $cm_recsheet_dt
 * @property string $cm_s2csheet_dt
 * @property string $cm_rf2psheet_dt
 * @property string $cm_cmposheet_dt
 * @property string $cm_mssheet_dt
 * @property string|null $cm_sheet_name
 *
 * @property \App\Model\Entity\User[] $users
 */
class CompanyMst extends Entity
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
        'cm_sales_representative' => true,
        'cm_comp_name' => true,
        'cm_proper_name' => true,
        'cm_first_name' => true,
        'cm_last_name' => true,
        'cm_url' => true,
        'cm_logo' => true,
        'cm_address' => true,
        'cm_address1' => true,
        'cm_City' => true,
        'cm_State' => true,
        'cm_zip' => true,
        'cm_County' => true,
        'cm_phone' => true,
        'cm_fax' => true,
        'cm_email' => true,
        'cm_partner' => true,
        'cm_ownedBy' => true,
        'cm_partner_cmp' => true,
        'cm_partner_type' => true,
        'cm_clients' => true,
        'cm_delivery_add1' => true,
        'cm_delivery_add2' => true,
        'cm_delivery_zip' => true,
        'cm_delivery_City' => true,
        'cm_delivery_State' => true,
        'cm_delivery_County' => true,
        'cm_enabled' => true,
        'cm_approved' => true,
        'cm_pricingInfo' => true,
        'cm_specialInst' => true,
        'cm_checkinsheet_prefix' => true,
        'cm_qcsheet_prefix' => true,
        'cm_accsheet_prefix' => true,
        'cm_recsheet_prefix' => true,
        'cm_s2csheet_prefix' => true,
        'cm_rf2psheet_prefix' => true,
        'cm_cmposheet_prefix' => true,
        'cm_mssheet_prefix' => true,
        'cm_checkinsheet_dt' => true,
        'cm_qcsheet_dt' => true,
        'cm_accsheet_dt' => true,
        'cm_recsheet_dt' => true,
        'cm_s2csheet_dt' => true,
        'cm_rf2psheet_dt' => true,
        'cm_cmposheet_dt' => true,
        'cm_mssheet_dt' => true,
        'cm_sheet_name' => true,
        'cm_active' => true,
        'users' => true,
    ];
}
