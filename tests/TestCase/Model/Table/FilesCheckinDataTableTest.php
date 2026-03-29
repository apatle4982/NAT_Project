<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FilesCheckinDataTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FilesCheckinDataTable Test Case
 */
class FilesCheckinDataTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FilesCheckinDataTable
     */
    protected $FilesCheckinData;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FilesCheckinData',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FilesCheckinData') ? [] : ['className' => FilesCheckinDataTable::class];
        $this->FilesCheckinData = $this->getTableLocator()->get('FilesCheckinData', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FilesCheckinData);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FilesCheckinDataTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
