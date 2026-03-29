<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FilesCsvMasterTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FilesCsvMasterTable Test Case
 */
class FilesCsvMasterTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FilesCsvMasterTable
     */
    protected $FilesCsvMaster;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FilesCsvMaster',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FilesCsvMaster') ? [] : ['className' => FilesCsvMasterTable::class];
        $this->FilesCsvMaster = $this->getTableLocator()->get('FilesCsvMaster', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FilesCsvMaster);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FilesCsvMasterTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
