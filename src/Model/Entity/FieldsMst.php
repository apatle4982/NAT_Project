<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FieldsMst Entity
 *
 * @property int $fm_id
 * @property string $fm_title
 * @property int $fm_sortorder
 * @property string $fm_main
 */
class FieldsMst extends Entity
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
        'fm_title' => true,
        'fm_sortorder' => true,
        'fm_main' => true,
    ];
}
