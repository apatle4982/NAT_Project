<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RejectionStatusHistoryTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RejectionStatusHistoryTable Test Case
 */
class RejectionStatusHistoryTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RejectionStatusHistoryTable
     */
    protected $RejectionStatusHistory;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.RejectionStatusHistory',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RejectionStatusHistory') ? [] : ['className' => RejectionStatusHistoryTable::class];
        $this->RejectionStatusHistory = $this->getTableLocator()->get('RejectionStatusHistory', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RejectionStatusHistory);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\RejectionStatusHistoryTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
