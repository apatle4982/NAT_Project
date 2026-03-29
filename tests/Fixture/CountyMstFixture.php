<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CountyMstFixture
 */
class CountyMstFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'County_mst';
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
                'cm_title' => 'Lorem ipsum dolor sit amet',
                'cm_vendor_class_id' => 'Lorem ipsum dolor sit amet',
                'cm_code' => 'Lorem ipsum dolor sit amet',
                'cm_State' => 'Lorem ipsum dolor sit amet',
                'cm_township_division' => 'Lorem ipsum dolor sit amet',
                'cm_department_office' => 'Lorem ipsum dolor sit amet',
                'cm_address1' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'cm_address2' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'cm_City' => 'Lorem ipsum dolor sit amet',
                'cm_zip' => 'Lorem ip',
                'cm_phone' => 'Lorem ipsum dolor ',
                'cm_payable' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'cm_file_enabled' => '',
                'cm_all_doc_type' => '',
                'cm_limited_doc_type' => '',
                'cm_recording_information_avail' => '',
                'cm_link' => 'Lorem ipsum dolor sit amet',
                'cm_user_name' => 'Lorem ipsum dolor sit amet',
                'cm_password' => 'Lorem ipsum dolor sit amet',
                'cm_original_password' => 'Lorem ipsum dolor sit amet',
                'cm_doc' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'cm_County_info' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'cm_State_reg' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'date_created' => '2023-01-10',
                'date_modified' => '2023-01-10',
                'cm_status' => '',
                'cm_vendor_id' => 'Lorem ipsum dolor sit amet',
                'cm_contact_name' => 'Lorem ipsum dolor sit amet',
                'cm_no_in_av_ol_web' => '',
                'cm_op_rd_in_im_av_no_ch' => '',
                'cm_op_rd_in_av_no_in' => '',
                'cm_op_rd_in_im_av' => '',
                'cm_sub_rd_in_im_av_no_ch' => '',
                'cm_sub_rd_in_av_no_in' => '',
                'cm_sub_rd_in_im_av' => '',
                'file_avl' => 'Lorem ipsum dolor sit amet',
                'rec_info_avl' => 'Lorem ipsum dolor sit amet',
                'rec_info_main' => '',
                'sub_info_main' => '',
            ],
        ];
        parent::init();
    }
}
