<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CompanyFieldsMap Entity
 *
 * @property int $cfm_id
 * @property int $cfm_companyid
 * @property int $cfm_fieldid
 * @property string $cfm_maptitle
 * @property int $cfm_sortorder
 * @property string $cfm_datafield
 * @property string $cfm_defaultvalues
 * @property string $cfm_group
 */
class CompanyFieldsMapExam extends Entity
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
        'cfm_companyid' => true,
        'cfm_fieldid' => true,
        'cfm_maptitle' => true,
        'cfm_sortorder' => true,
        'cfm_datafield' => true,
        'cfm_defaultvalues' => true,
        'cfm_group' => true,
    ];
}
