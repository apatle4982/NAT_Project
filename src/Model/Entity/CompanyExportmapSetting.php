<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CompanyExportmapSetting Entity
 *
 * @property int $id
 * @property int $company_id
 * @property string|null $sheet_name
 * @property string|null $export_fields
 * @property string $export_field_mapid
 * @property int|null $document_status
 * @property \Cake\I18n\FrozenDate $date_from
 * @property \Cake\I18n\FrozenDate $date_to
 * @property \Cake\I18n\FrozenTime $added_date
 * @property int $is_delete
 */
class CompanyExportmapSetting extends Entity
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
        'company_id' => true,
        'sheet_name' => true,
        'export_fields' => true,
        'export_field_mapid' => true,
        'document_status' => true,
        'date_section' => true,
        'date_from' => true,
        'date_to' => true,
        'added_date' => true,
        'is_delete' => true,
    ];
}
