<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CountyMst Entity
 *
 * @property int $cm_id
 * @property string $cm_title
 * @property string|null $cm_vendor_class_id
 * @property string|null $cm_code
 * @property string $cm_State
 * @property string|null $cm_township_division
 * @property string|null $cm_department_office
 * @property string|null $cm_address1
 * @property string|null $cm_address2
 * @property string|null $cm_City
 * @property string|null $cm_zip
 * @property string|null $cm_phone
 * @property string|null $cm_payable
 * @property string|null $cm_file_enabled
 * @property string|null $cm_all_doc_type
 * @property string|null $cm_limited_doc_type
 * @property string|null $cm_recording_information_avail
 * @property string|null $cm_link
 * @property string|null $cm_user_name
 * @property string|null $cm_password
 * @property string|null $cm_original_password
 * @property string|null $cm_doc
 * @property string|null $cm_County_info
 * @property string|null $cm_State_reg
 * @property \Cake\I18n\FrozenDate $date_created
 * @property \Cake\I18n\FrozenDate $date_modified
 * @property string $cm_status
 * @property string|null $cm_vendor_id
 * @property string|null $cm_contact_name
 * @property string|null $cm_no_in_av_ol_web
 * @property string|null $cm_op_rd_in_im_av_no_ch
 * @property string|null $cm_op_rd_in_av_no_in
 * @property string|null $cm_op_rd_in_im_av
 * @property string|null $cm_sub_rd_in_im_av_no_ch
 * @property string|null $cm_sub_rd_in_av_no_in
 * @property string|null $cm_sub_rd_in_im_av
 * @property string $file_avl
 * @property string $rec_info_avl
 * @property string $rec_info_main
 * @property string $sub_info_main
 */
class CountyMst extends Entity
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
        'cm_title' => true,        
        'cm_code' => true,
        'cm_State' => true,
        'cm_file_enabled' => true,
        'cm_link' => true,
        'file_avl' => true,
        'rec_info_avl' => true,
        'date_created' => true,
        'date_modified' => true,
        'fedex_person_name' => true,
        'fedex_phone_number' => true,
        'fedex_company_name' => true,
        'fedex_address_1' => true,
        'fedex_address_2' => true,
        'fedex_City' => true,
        'fedex_State' => true,
        'fedex_postal' => true,
        'fedex_country_code' => true,
        //'cm_vendor_class_id' => true,
        //'cm_township_division' => true,
        //'cm_department_office' => true,
        //'cm_address1' => true,
        //'cm_address2' => true,
        //'cm_City' => true,
        //'cm_zip' => true,
        //'cm_phone' => true,
        //'cm_payable' => true,
        //'cm_all_doc_type' => true,
        //'cm_limited_doc_type' => true,
        //'cm_recording_information_avail' => true,
        //'cm_user_name' => true,
        //'cm_password' => true,
        //'cm_original_password' => true,
        //'cm_doc' => true,
        //'cm_County_info' => true,
        //'cm_State_reg' => true,
        //'cm_status' => true,
        //'cm_vendor_id' => true,
        //'cm_contact_name' => true,
        //'cm_no_in_av_ol_web' => true,
        //'cm_op_rd_in_im_av_no_ch' => true,
        //'cm_op_rd_in_av_no_in' => true,
        //'cm_op_rd_in_im_av' => true,
        //'cm_sub_rd_in_im_av_no_ch' => true,
        //'cm_sub_rd_in_av_no_in' => true,
        //'cm_sub_rd_in_im_av' => true,        
        //'rec_info_main' => true,
        //'sub_info_main' => true,
    ];
}