<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ApplicableFormsFixture
 */
class ApplicableFormsFixture extends TestFixture
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
                'af_id' => 1,
                'af_title' => 'Lorem ipsum dolor sit amet',
                'af_County_id' => 1,
                'af_url' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
