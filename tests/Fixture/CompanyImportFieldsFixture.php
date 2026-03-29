<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CompanyImportFieldsFixture
 */
class CompanyImportFieldsFixture extends TestFixture
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
                'cif_id' => 1,
                'cif_companyid' => 1,
                'cif_fieldid' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
