<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FilesAccountingDataTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FilesAccountingDataTable Test Case
 */
class FilesAccountingDataTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FilesAccountingDataTable
     */
    protected $FilesAccountingData;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FilesAccountingData',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FilesAccountingData') ? [] : ['className' => FilesAccountingDataTable::class];
        $this->FilesAccountingData = $this->getTableLocator()->get('FilesAccountingData', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FilesAccountingData);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FilesAccountingDataTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
