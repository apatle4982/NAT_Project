<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CompanyExportField Entity
 *
 * @property int $cef_id
 * @property int $cef_companyid
 * @property string $cef_fieldid4CHI
 * @property string $cef_fieldid4QC
 * @property string $cef_fieldid4AC
 * @property string $cef_fieldid4RE
 * @property string $cef_fieldid4GP
 * @property string $cef_fieldid4SC
 * @property string $cef_fieldid4RP
 * @property string $cef_fieldid4CO
 * @property string $cef_fieldid4MS
 */
class CompanyExportField extends Entity
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
        'cef_companyid' => true,
        'cef_fieldid4CHI' => true,
        'cef_fieldid4QC' => true,
        'cef_fieldid4AC' => true,
        'cef_fieldid4RE' => true,
        'cef_fieldid4GP' => true,
        'cef_fieldid4SC' => true,
        'cef_fieldid4RP' => true,
        'cef_fieldid4CO' => true,
        'cef_fieldid4MS' => true,
    ];
}
