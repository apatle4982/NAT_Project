<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CompanyImportFieldsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CompanyImportFieldsTable Test Case
 */
class CompanyImportFieldsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CompanyImportFieldsTable
     */
    protected $CompanyImportFields;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.CompanyImportFields',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CompanyImportFields') ? [] : ['className' => CompanyImportFieldsTable::class];
        $this->CompanyImportFields = $this->getTableLocator()->get('CompanyImportFields', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CompanyImportFields);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CompanyImportFieldsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
