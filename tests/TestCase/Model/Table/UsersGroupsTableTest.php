<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersGroupsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersGroupsTable Test Case
 */
class UsersGroupsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersGroupsTable
     */
    protected $UsersGroups;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.UsersGroups',
        'app.Users',
        'app.Groups',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('UsersGroups') ? [] : ['className' => UsersGroupsTable::class];
        $this->UsersGroups = $this->getTableLocator()->get('UsersGroups', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->UsersGroups);

        parent::tearDown();
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\UsersGroupsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
