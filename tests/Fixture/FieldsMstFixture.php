<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FieldsMstFixture
 */
class FieldsMstFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'fields_mst';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'fm_id' => 1,
                'fm_title' => 'Lorem ipsum dolor sit amet',
                'fm_sortorder' => 1,
                'fm_main' => '',
            ],
        ];
        parent::init();
    }
}
