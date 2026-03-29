<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentCscMstFixture
 */
class DocumentCscMstFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'document_csc_mst';
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
                'County_id' => 1,
                'document_type_id' => 1,
                'document_type_name' => 'Lorem ipsum dolor sit amet',
                'is_active' => 1,
            ],
        ];
        parent::init();
    }
}
