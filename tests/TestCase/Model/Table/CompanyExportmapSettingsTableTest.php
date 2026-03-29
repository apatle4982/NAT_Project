<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CompanyExportmapSettingsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CompanyExportmapSettingsTable Test Case
 */
class CompanyExportmapSettingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CompanyExportmapSettingsTable
     */
    protected $CompanyExportmapSettings;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.CompanyExportmapSettings',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CompanyExportmapSettings') ? [] : ['className' => CompanyExportmapSettingsTable::class];
        $this->CompanyExportmapSettings = $this->getTableLocator()->get('CompanyExportmapSettings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CompanyExportmapSettings);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CompanyExportmapSettingsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
