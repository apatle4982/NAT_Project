<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FieldSection Entity
 *
 * @property int $id
 * @property string|null $section_name
 * @property string|null $field_tblname
 * @property int $set_order
 */
class FieldSectionExam extends Entity
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
        'section_name' => true,
        'field_tblname' => true,
        'set_order' => true,
    ];
}
