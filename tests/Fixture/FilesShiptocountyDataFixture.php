<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FilesShiptoCountyDataFixture
 */
class FilesShiptoCountyDataFixture extends TestFixture
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
                'id' => 1,
                'RecId' => 1,
                'TransactionType' => 1,
                'CarrierName' => 'Lorem ipsum dolor sit amet',
                'CarrierTrackingNo' => 'Lorem ipsum dolor sit amet',
                'VendorID' => 'Lorem ipsum dolor sit amet',
                'MappingCode' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'FedexShipping' => '',
                'FedexMappingDate' => '2023-02-01',
                'AddingDate' => '2023-02-01',
                'LabelImage' => 'Lorem ipsum dolor sit amet',
                'Rate' => 'Lorem ipsum dolor sit amet',
                'ShippingProcessingDate' => '2023-02-01',
                'ShippingProcessingTime' => '10:01:56',
                'UserId' => 1,
                'DeliveryDate' => '2023-02-01',
                'DeliveryTime' => '10:01:56',
                'DeliverySignature' => 'Lorem ipsum dolor sit amet',
                'Status' => 'Lorem ipsum dolor sit amet',
                'RecipientCompany' => 'Lorem ipsum dolor sit amet',
                'DeliveredTo' => 'Lorem ipsum dolor sit amet',
                'ReceivedBy' => 'Lorem ipsum dolor sit amet',
                'DateDelivered' => '2023-02-01',
                'FedexEntryDate' => '2023-02-01',
            ],
        ];
        parent::init();
    }
}
