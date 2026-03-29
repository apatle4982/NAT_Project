<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CompanyFieldsMapTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CompanyFieldsMapTable Test Case
 */
class CompanyFieldsMapTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CompanyFieldsMapTable
     */
    protected $CompanyFieldsMap;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.CompanyFieldsMap',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CompanyFieldsMap') ? [] : ['className' => CompanyFieldsMapTable::class];
        $this->CompanyFieldsMap = $this->getTableLocator()->get('CompanyFieldsMap', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CompanyFieldsMap);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CompanyFieldsMapTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
