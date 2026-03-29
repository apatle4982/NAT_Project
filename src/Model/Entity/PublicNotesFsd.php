<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PublicNotesFsd Entity
 *
 * @property int $Id
 * @property int $RecId
 * @property int $TransactionType
 * @property int $UserId
 * @property string $Regarding
 * @property string $Type
 * @property string $Section
 * @property \Cake\I18n\FrozenDate $AddingDate
 * @property \Cake\I18n\Time $AddingTime
 * @property string $Public_Internal
 * @property string|null $subject
 * @property string|null $body
 */
class PublicNotesFsd extends Entity
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
        'RecId' => true,
        'TransactionType' => true,
        'UserId' => true,
        'Regarding' => true,
        'Type' => true,
        'Section' => true,
        'AddingDate' => true,
        'AddingTime' => true,
        'Public_Internal' => true,
        'subject' => true,
        'body' => true,
    ];
}
