<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FilesShiptoCountyDataTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FilesShiptoCountyDataTable Test Case
 */
class FilesShiptoCountyDataTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FilesShiptoCountyDataTable
     */
    protected $FilesShiptoCountyData;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FilesShiptoCountyData',
        'app.FilesMainData',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FilesShiptoCountyData') ? [] : ['className' => FilesShiptoCountyDataTable::class];
        $this->FilesShiptoCountyData = $this->getTableLocator()->get('FilesShiptoCountyData', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FilesShiptoCountyData);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FilesShiptoCountyDataTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
