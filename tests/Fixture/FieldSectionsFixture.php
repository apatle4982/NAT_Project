<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FieldSectionsFixture
 */
class FieldSectionsFixture extends TestFixture
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
                'section_name' => 'Lorem ipsum dolor sit amet',
                'field_tblname' => 'Lorem ipsum dolor sit amet',
                'set_order' => 1,
            ],
        ];
        parent::init();
    }
}
