<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CompanyMstFixture
 */
class CompanyMstFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'company_mst';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'cm_id' => 1,
                'cm_sales_representative' => 'Lorem ipsum dolor sit amet',
                'cm_comp_name' => 'Lorem ipsum dolor sit amet',
                'cm_proper_name' => 'Lorem ipsum dolor sit amet',
                'cm_first_name' => 'Lorem ipsum dolor sit amet',
                'cm_last_name' => 'Lorem ipsum dolor sit amet',
                'cm_url' => 'Lorem ipsum dolor sit amet',
                'cm_logo' => 'Lorem ipsum dolor sit amet',
                'cm_address' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'cm_address1' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'cm_City' => 'Lorem ipsum dolor sit amet',
                'cm_State' => 'Lorem ipsum dolor sit amet',
                'cm_zip' => 'Lorem ipsum dolor ',
                'cm_County' => 'Lorem ipsum dolor sit amet',
                'cm_phone' => 'Lorem ipsum dolor ',
                'cm_fax' => 'Lorem ipsum dolor ',
                'cm_email' => 'Lorem ipsum dolor sit amet',
                'cm_partner' => 'Lorem ipsum dolor sit amet',
                'cm_ownedBy' => 'Lorem ipsum dolor sit amet',
                'cm_partner_cmp' => 'Lorem ipsum dolor sit amet',
                'cm_partner_type' => 'Lorem ipsum dolor sit amet',
                'cm_clients' => 'Lorem ipsum dolor sit amet',
                'cm_delivery_add1' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'cm_delivery_add2' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'cm_delivery_zip' => 'Lorem ipsum dolor sit a',
                'cm_delivery_City' => 'Lorem ipsum dolor sit amet',
                'cm_delivery_State' => 'Lorem ipsum dolor sit amet',
                'cm_delivery_County' => 'Lorem ipsum dolor sit amet',
                'cm_enabled' => 'Lorem ipsum dolor sit amet',
                'cm_approved' => 'Lorem ipsum dolor sit amet',
                'cm_pricingInfo' => 'Lorem ipsum dolor sit amet',
                'cm_specialInst' => 'Lorem ipsum dolor sit amet',
                'cm_checkinsheet_prefix' => 'Lorem ipsum dolor sit amet',
                'cm_qcsheet_prefix' => 'Lorem ipsum dolor sit amet',
                'cm_accsheet_prefix' => 'Lorem ipsum dolor sit amet',
                'cm_recsheet_prefix' => 'Lorem ipsum dolor sit amet',
                'cm_s2csheet_prefix' => 'Lorem ipsum dolor sit amet',
                'cm_rf2psheet_prefix' => 'Lorem ipsum dolor sit amet',
                'cm_cmposheet_prefix' => 'Lorem ipsum dolor sit amet',
                'cm_mssheet_prefix' => 'Lorem ipsum dolor sit amet',
                'cm_checkinsheet_dt' => 'Lorem ipsum dolor ',
                'cm_qcsheet_dt' => 'Lorem ip',
                'cm_accsheet_dt' => 'Lorem ip',
                'cm_recsheet_dt' => 'Lorem ip',
                'cm_s2csheet_dt' => 'Lorem ip',
                'cm_rf2psheet_dt' => 'Lorem ip',
                'cm_cmposheet_dt' => 'Lorem ip',
                'cm_mssheet_dt' => 'Lorem ip',
                'cm_sheet_name' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
