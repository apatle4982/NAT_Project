<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentSimplifileMstTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentSimplifileMstTable Test Case
 */
class DocumentSimplifileMstTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentSimplifileMstTable
     */
    protected $DocumentSimplifileMst;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.DocumentSimplifileMst',
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
        $config = $this->getTableLocator()->exists('DocumentSimplifileMst') ? [] : ['className' => DocumentSimplifileMstTable::class];
        $this->DocumentSimplifileMst = $this->getTableLocator()->get('DocumentSimplifileMst', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->DocumentSimplifileMst);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DocumentSimplifileMstTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DocumentSimplifileMstTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
