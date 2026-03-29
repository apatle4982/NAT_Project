<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FilesRecordingDataTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FilesRecordingDataTable Test Case
 */
class FilesRecordingDataTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FilesRecordingDataTable
     */
    protected $FilesRecordingData;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FilesRecordingData',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FilesRecordingData') ? [] : ['className' => FilesRecordingDataTable::class];
        $this->FilesRecordingData = $this->getTableLocator()->get('FilesRecordingData', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FilesRecordingData);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FilesRecordingDataTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
