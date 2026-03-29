<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FilesMainDataTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FilesMainDataTable Test Case
 */
class FilesMainDataTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FilesMainDataTable
     */
    protected $FilesMainData;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FilesMainData',
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
        $config = $this->getTableLocator()->exists('FilesMainData') ? [] : ['className' => FilesMainDataTable::class];
        $this->FilesMainData = $this->getTableLocator()->get('FilesMainData', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FilesMainData);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FilesMainDataTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
