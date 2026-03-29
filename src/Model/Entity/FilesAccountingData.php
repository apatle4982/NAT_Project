<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FilesAccountingData Entity
 *
 * @property int $Id
 * @property int $RecId
 * @property int $TransactionType
 * @property string|null $CountyRecordingFee
 * @property string|null $Taxes
 * @property string|null $AdditionalFees
 * @property string|null $Total
 * @property int|null $CheckNumber1
 * @property int|null $CheckNumber2
 * @property float|null $EPortalActual
 * @property float $UploadedCountyrecordingfee
 * @property float $UploadedTaxes
 * @property float $UploadedAdditionalfees
 * @property float $UploadedTotal
 * @property \Cake\I18n\FrozenTime $UploadedDateTime
 * @property \Cake\I18n\FrozenDate $LastModified
 * @property int $UserId
 * @property string $AccountingNotes
 * @property string|null $AccountingProcessingDate
 * @property \Cake\I18n\Time $AccountingProcessingTime
 * @property string $CheckNumber
 * @property string $ClearedBank
 * @property float $ClearedAmount
 * @property \Cake\I18n\FrozenDate $CheckUpdatedDate
 * @property string|null $jrf_cc_fees
 * @property string|null $jrf_icg_fees
 * @property string|null $jrf_curative
 * @property string|null $jrf_final_fees
 * @property string|null $tt_cc_fees
 * @property string|null $tt_icg_fees
 * @property string|null $tt_curative
 * @property string|null $tt_final_fees
 * @property string|null $it_cc_fees
 * @property string|null $it_icg_fees
 * @property string|null $it_curative
 * @property string|null $it_final_fees
 * @property string|null $ot_cc_fees
 * @property string|null $ot_icg_fees
 * @property string|null $ot_curative
 * @property string|null $ot_final_fees
 * @property string|null $ns_cc_fees
 * @property string|null $ns_icg_fees
 * @property string|null $ns_curative
 * @property string|null $ns_final_fees
 * @property string|null $wu_cc_fees
 * @property string|null $wu_icg_fees
 * @property string|null $wu_curative
 * @property string|null $wu_final_fees
 * @property string|null $of_cc_fees
 * @property string|null $of_icg_fees
 * @property string|null $of_curative
 * @property string|null $of_final_fees
 * @property string|null $total_cc_fees
 * @property string|null $total_icg_fees
 * @property string|null $total_curative
 * @property string|null $total_final_fees
 * @property string|null $check_cleared
 */
class FilesAccountingData extends Entity
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
        'CountyRecordingFee' => true,
        'Taxes' => true,
        'AdditionalFees' => true,
        'Total' => true,
        'CheckNumber1' => true,
        'CheckNumber2' => true,
        'EPortalActual' => true,
        'UploadedCountyrecordingfee' => true,
        'UploadedTaxes' => true,
        'UploadedAdditionalfees' => true,
        'UploadedTotal' => true,
        'UploadedDateTime' => true,
        'LastModified' => true,
        'UserId' => true,
        'AccountingNotes' => true,
        'AccountingProcessingDate' => true,
        'AccountingProcessingTime' => true,
        'CheckNumber' => true,
        'ClearedBank' => true,
        'ClearedAmount' => true,
        'CheckUpdatedDate' => true,
        'jrf_cc_fees' => true,
        'jrf_icg_fees' => true,
        'jrf_curative' => true,
        'jrf_final_fees' => true,
        'tt_cc_fees' => true,
        'tt_icg_fees' => true,
        'tt_curative' => true,
        'tt_final_fees' => true,
        'it_cc_fees' => true,
        'it_icg_fees' => true,
        'it_curative' => true,
        'it_final_fees' => true,
        'ot_cc_fees' => true,
        'ot_icg_fees' => true,
        'ot_curative' => true,
        'ot_final_fees' => true,
        'ns_cc_fees' => true,
        'ns_icg_fees' => true,
        'ns_curative' => true,
        'ns_final_fees' => true,
        'wu_cc_fees' => true,
        'wu_icg_fees' => true,
        'wu_curative' => true,
        'wu_final_fees' => true,
        'of_cc_fees' => true,
        'of_icg_fees' => true,
        'of_curative' => true,
        'of_final_fees' => true,
        'total_cc_fees' => true,
        'total_icg_fees' => true,
        'total_curative' => true,
        'total_final_fees' => true,
        'check_cleared' => true,
    ];
}
