<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FilesRecordingData Entity
 *
 * @property int $Id
 * @property int $RecId
 * @property int $TransactionType
 * @property \Cake\I18n\FrozenDate $RecordingProcessingDate
 * @property \Cake\I18n\Time $RecordingProcessingTime
 * @property \Cake\I18n\FrozenDate|null $RecordingDate
 * @property \Cake\I18n\Time|null $RecordingTime
 * @property string|null $InstrumentNumber
 * @property string|null $Book
 * @property string|null $Page
 * @property string $Pages
 * @property string $DocumentNumber
 * @property \Cake\I18n\FrozenDate|null $EffectiveDate
 * @property string $TrackingNumber
 * @property string $File
 * @property int $UserId
 * @property string $RecordingNotes
 * @property string $RejectionFromCounty
 * @property string $RejectionReason
 * @property string $sheet_generate
 * @property string $pdf_generate
 * @property int $KNI
 * @property string $hard_copy_received
 */
class FilesRecordingData extends Entity
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
        'RecordingProcessingDate' => true,
        'RecordingProcessingTime' => true,
        'RecordingDate' => true,
        'RecordingTime' => true,
        'InstrumentNumber' => true,
        'Book' => true,
        'Page' => true,
        'Pages' => true,
        'DocumentNumber' => true,
        'EffectiveDate' => true,
        'TrackingNumber' => true,
        'File' => true,
        'file_main_path'=>true,
        'UserId' => true,
        'RecordingNotes' => true,
        'RejectionFromCounty' => true,
        'RejectionReason' => true,
        'sheet_generate' => true,
        'pdf_generate' => true,
        'KNI' => true,
        'hard_copy_received' => true,
    ];
}
