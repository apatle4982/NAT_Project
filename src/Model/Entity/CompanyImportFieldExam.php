<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CompanyImportField Entity
 *
 * @property int $cif_id
 * @property int $cif_companyid
 * @property string $cif_fieldid
 */
class CompanyImportFieldExam extends Entity
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
        'cif_companyid' => true,
        'cif_fieldid' => true,
    ];
}
