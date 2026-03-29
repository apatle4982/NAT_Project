<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
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
                'user_id' => 1,
                'user_name' => 'Lorem ipsum dolor sit amet',
                'user_lastname' => 'Lorem ipsum dolor sit amet',
                'user_phone' => 'Lorem ipsum dolor sit amet',
                'user_email' => 'Lorem ipsum dolor sit amet',
                'user_username' => 'Lorem ipsum dolor sit amet',
                'user_password' => 'Lorem ipsum dolor sit amet',
                'original_password' => 'Lorem ipsum dolor sit amet',
                'user_companyid' => 1,
                'user_active' => '',
                'user_deleted' => '',
                'privileges2add' => '',
                'privileges2edit' => '',
                'privileges2delete' => '',
            ],
        ];
        parent::init();
    }
}
