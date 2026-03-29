<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentCscMstTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentCscMstTable Test Case
 */
class DocumentCscMstTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentCscMstTable
     */
    protected $DocumentCscMst;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.DocumentCscMst',
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
        $config = $this->getTableLocator()->exists('DocumentCscMst') ? [] : ['className' => DocumentCscMstTable::class];
        $this->DocumentCscMst = $this->getTableLocator()->get('DocumentCscMst', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->DocumentCscMst);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DocumentCscMstTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DocumentCscMstTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
