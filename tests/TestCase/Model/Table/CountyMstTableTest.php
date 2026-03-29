<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CountyMstTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CountyMstTable Test Case
 */
class CountyMstTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CountyMstTable
     */
    protected $CountyMst;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.CountyMst',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CountyMst') ? [] : ['className' => CountyMstTable::class];
        $this->CountyMst = $this->getTableLocator()->get('CountyMst', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CountyMst);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CountyMstTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
