<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ApplicableForm Entity
 *
 * @property int $af_id
 * @property string $af_title
 * @property int $af_County_id
 * @property string $af_url
 */
class ApplicableForm extends Entity
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
        'af_title' => true,
        'af_County_id' => true,
        'af_url' => true,
    ];
}
