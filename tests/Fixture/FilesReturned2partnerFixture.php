<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FilesReturned2partnerFixture
 */
class FilesReturned2partnerFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'files_returned2partner';
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
                'CarrierName' => 'Lorem ipsum dolor sit amet',
                'CarrierTrackingNo' => 'Lorem ipsum dolor sit amet',
                'UserId' => 1,
                'RTPProcessingDate' => '2023-03-31',
                'RTPProcessingTime' => '10:27:32',
                'dateDelivered' => 'Lorem ipsum dolor sit amet',
                'receipient' => 'Lorem ipsum dolor sit amet',
                'deliveredTo' => 'Lorem ipsum dolor sit amet',
                'receivedBy' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
