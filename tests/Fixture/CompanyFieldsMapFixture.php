<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CompanyFieldsMapFixture
 */
class CompanyFieldsMapFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'company_fields_map';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'cfm_id' => 1,
                'cfm_companyid' => 1,
                'cfm_fieldid' => 1,
                'cfm_maptitle' => 'Lorem ipsum dolor sit amet',
                'cfm_sortorder' => 1,
                'cfm_datafield' => 'Lorem ipsum dolor sit amet',
                'cfm_defaultvalues' => 'Lorem ipsum dolor sit amet',
                'cfm_group' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
