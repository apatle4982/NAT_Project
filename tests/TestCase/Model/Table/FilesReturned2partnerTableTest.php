<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FilesReturned2partnerTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FilesReturned2partnerTable Test Case
 */
class FilesReturned2partnerTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FilesReturned2partnerTable
     */
    protected $FilesReturned2partner;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FilesReturned2partner',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FilesReturned2partner') ? [] : ['className' => FilesReturned2partnerTable::class];
        $this->FilesReturned2partner = $this->getTableLocator()->get('FilesReturned2partner', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FilesReturned2partner);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FilesReturned2partnerTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
