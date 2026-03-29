<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FilesAccountingDataHistoryTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FilesAccountingDataHistoryTable Test Case
 */
class FilesAccountingDataHistoryTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FilesAccountingDataHistoryTable
     */
    protected $FilesAccountingDataHistory;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FilesAccountingDataHistory',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FilesAccountingDataHistory') ? [] : ['className' => FilesAccountingDataHistoryTable::class];
        $this->FilesAccountingDataHistory = $this->getTableLocator()->get('FilesAccountingDataHistory', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FilesAccountingDataHistory);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FilesAccountingDataHistoryTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
