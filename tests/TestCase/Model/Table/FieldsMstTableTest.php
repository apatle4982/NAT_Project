<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FieldsMstTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FieldsMstTable Test Case
 */
class FieldsMstTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FieldsMstTable
     */
    protected $FieldsMst;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FieldsMst',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FieldsMst') ? [] : ['className' => FieldsMstTable::class];
        $this->FieldsMst = $this->getTableLocator()->get('FieldsMst', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FieldsMst);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FieldsMstTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
