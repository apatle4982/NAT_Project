<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CompanyMstTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CompanyMstTable Test Case
 */
class CompanyMstTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CompanyMstTable
     */
    protected $CompanyMst;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.CompanyMst',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CompanyMst') ? [] : ['className' => CompanyMstTable::class];
        $this->CompanyMst = $this->getTableLocator()->get('CompanyMst', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CompanyMst);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CompanyMstTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
