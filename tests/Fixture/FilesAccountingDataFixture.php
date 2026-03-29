<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FilesAccountingDataFixture
 */
class FilesAccountingDataFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'Id' => 1,
                'RecId' => 1,
                'TransactionType' => 1,
                'CountyRecordingFee' => 'Lorem ipsum dolor sit a',
                'Taxes' => 'Lorem ipsum dolor sit a',
                'AdditionalFees' => 'Lorem ipsum dolor sit a',
                'Total' => 'Lorem ipsum dolor sit a',
                'CheckNumber1' => 1,
                'CheckNumber2' => 1,
                'EPortalActual' => 1,
                'UploadedCountyrecordingfee' => 1,
                'UploadedTaxes' => 1,
                'UploadedAdditionalfees' => 1,
                'UploadedTotal' => 1,
                'UploadedDateTime' => '2023-03-02 12:32:26',
                'LastModified' => '2023-03-02',
                'UserId' => 1,
                'AccountingNotes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'AccountingProcessingDate' => 'Lorem ipsum dolor ',
                'AccountingProcessingTime' => '12:32:26',
                'CheckNumber' => 'Lorem ipsum dolor sit amet',
                'ClearedBank' => 'Lorem ip',
                'ClearedAmount' => 1,
                'CheckUpdatedDate' => '2023-03-02',
                'jrf_cc_fees' => 'Lorem ipsum dolor sit a',
                'jrf_icg_fees' => 'Lorem ipsum dolor sit a',
                'jrf_curative' => 'Lorem ipsum dolor sit a',
                'jrf_final_fees' => 'Lorem ipsum dolor sit a',
                'tt_cc_fees' => 'Lorem ipsum dolor sit a',
                'tt_icg_fees' => 'Lorem ipsum dolor sit a',
                'tt_curative' => 'Lorem ipsum dolor sit a',
                'tt_final_fees' => 'Lorem ipsum dolor sit a',
                'it_cc_fees' => 'Lorem ipsum dolor sit a',
                'it_icg_fees' => 'Lorem ipsum dolor sit a',
                'it_curative' => 'Lorem ipsum dolor sit a',
                'it_final_fees' => 'Lorem ipsum dolor sit a',
                'ot_cc_fees' => 'Lorem ipsum dolor sit a',
                'ot_icg_fees' => 'Lorem ipsum dolor sit a',
                'ot_curative' => 'Lorem ipsum dolor sit a',
                'ot_final_fees' => 'Lorem ipsum dolor sit a',
                'ns_cc_fees' => 'Lorem ipsum dolor sit a',
                'ns_icg_fees' => 'Lorem ipsum dolor sit a',
                'ns_curative' => 'Lorem ipsum dolor sit a',
                'ns_final_fees' => 'Lorem ipsum dolor sit a',
                'wu_cc_fees' => 'Lorem ipsum dolor sit a',
                'wu_icg_fees' => 'Lorem ipsum dolor sit a',
                'wu_curative' => 'Lorem ipsum dolor sit a',
                'wu_final_fees' => 'Lorem ipsum dolor sit a',
                'of_cc_fees' => 'Lorem ipsum dolor sit a',
                'of_icg_fees' => 'Lorem ipsum dolor sit a',
                'of_curative' => 'Lorem ipsum dolor sit a',
                'of_final_fees' => 'Lorem ipsum dolor sit a',
                'total_cc_fees' => 'Lorem ipsum dolor sit a',
                'total_icg_fees' => 'Lorem ipsum dolor sit a',
                'total_curative' => 'Lorem ipsum dolor sit a',
                'total_final_fees' => 'Lorem ipsum dolor sit a',
                'check_cleared' => 'Lorem ip',
            ],
        ];
        parent::init();
    }
}
