<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DocumentCountycalMst Entity
 *
 * @property int $Id
 * @property int|null $State_id
 * @property string|null $State_name
 * @property int|null $County_id
 * @property string|null $County_name
 * @property int|null $document_type_id
 * @property string|null $document_type_name
 * @property int $is_active
 *
 * @property \App\Model\Entity\State $State
 */
class DocumentCountycalMst extends Entity
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
        'State_code' => true,
        'County_id' => true,
        'document_type_id' => true,
        'document_type_name' => true,
        'is_active' => true,
        'State' => true,
    ];
}
