<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentCountycalMstFixture
 */
class DocumentCountycalMstFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'document_Countycal_mst';
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
                'State_id' => 1,
                'State_name' => 'Lorem ipsum dolor sit amet',
                'County_id' => 1,
                'County_name' => 'Lorem ipsum dolor sit amet',
                'document_type_id' => 1,
                'document_type_name' => 'Lorem ipsum dolor sit amet',
                'is_active' => 1,
            ],
        ];
        parent::init();
    }
}
