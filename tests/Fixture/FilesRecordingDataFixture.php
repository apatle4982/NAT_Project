<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FilesRecordingDataFixture
 */
class FilesRecordingDataFixture extends TestFixture
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
                'RecordingProcessingDate' => '2023-02-15',
                'RecordingProcessingTime' => '07:46:08',
                'RecordingDate' => '2023-02-15',
                'RecordingTime' => '07:46:08',
                'InstrumentNumber' => 'Lorem ipsum dolor sit amet',
                'Book' => 'Lorem ipsum dolor sit amet',
                'Page' => 'Lorem ipsum dolor sit a',
                'Pages' => 'Lorem ip',
                'DocumentNumber' => 'Lorem ipsum dolor sit amet',
                'EffectiveDate' => '2023-02-15',
                'TrackingNumber' => 'Lorem ipsum dolor sit amet',
                'File' => 'Lorem ipsum dolor sit amet',
                'UserId' => 1,
                'RecordingNotes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'RejectionFromCounty' => '',
                'RejectionReason' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'sheet_generate' => '',
                'pdf_generate' => '',
                'KNI' => 1,
                'hard_copy_received' => '',
            ],
        ];
        parent::init();
    }
}
