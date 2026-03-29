<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FilesCheckinDataFixture
 */
class FilesCheckinDataFixture extends TestFixture
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
                'DocumentReceived' => '',
                'UserId' => 1,
                'CheckInProcessingDate' => '2023-01-30',
                'CheckInProcessingTime' => '07:49:17',
                'search_status' => '',
                'search_status_updated_date' => '2023-01-30',
                'barcode_generated' => '',
                'isnew' => '',
            ],
        ];
        parent::init();
    }
}
