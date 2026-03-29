<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FilesQcDataFixture
 */
class FilesQcDataFixture extends TestFixture
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
                'Status' => '',
                'PRRCRNType' => 'Lorem ip',
                'StatusNote' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'StatusReason' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'RejectionReason' => 1,
                'CarrierName4RR' => 'Lorem ipsum dolor sit amet',
                'TrackingNo4RR' => 'Lorem ipsum dolor sit amet',
                'CRNStatus' => '',
                'CountyRejectionReason' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'CountyRejectionNote' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'CRNCarrierName4RR' => 'Lorem ipsum dolor sit amet',
                'CRNTrackingNo4RR' => 'Lorem ipsum dolor sit amet',
                'CountyRejectionProcessingDate' => '2023-02-15',
                'CountyRejectionProcessingTime' => '06:22:45',
                'SentToPartner' => '',
                'LastModified' => '2023-02-15',
                'UserId' => 1,
                'QCProcessingDate' => '2023-02-15',
                'QCProcessingTime' => '06:22:45',
            ],
        ];
        parent::init();
    }
}
