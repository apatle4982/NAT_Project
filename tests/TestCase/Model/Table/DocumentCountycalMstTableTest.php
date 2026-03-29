<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentCountycalMstTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentCountycalMstTable Test Case
 */
class DocumentCountycalMstTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentCountycalMstTable
     */
    protected $DocumentCountycalMst;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.DocumentCountycalMst',
        'app.States',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DocumentCountycalMst') ? [] : ['className' => DocumentCountycalMstTable::class];
        $this->DocumentCountycalMst = $this->getTableLocator()->get('DocumentCountycalMst', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->DocumentCountycalMst);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DocumentCountycalMstTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DocumentCountycalMstTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
