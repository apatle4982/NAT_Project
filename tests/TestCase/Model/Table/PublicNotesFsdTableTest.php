<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PublicNotesFsdTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PublicNotesFsdTable Test Case
 */
class PublicNotesFsdTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PublicNotesFsdTable
     */
    protected $PublicNotesFsd;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.PublicNotesFsd',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PublicNotesFsd') ? [] : ['className' => PublicNotesFsdTable::class];
        $this->PublicNotesFsd = $this->getTableLocator()->get('PublicNotesFsd', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PublicNotesFsd);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PublicNotesFsdTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
