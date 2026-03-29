<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FilesCsvMasterFixture
 */
class FilesCsvMasterFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'files_csv_master';
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
                'company_id' => 1,
                'SheetName' => 'Lorem ipsum dolor sit amet',
                'CSVDate' => '2023-02-06 10:07:42',
            ],
        ];
        parent::init();
    }
}
