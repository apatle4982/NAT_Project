<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PublicNotesFadTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PublicNotesFadTable Test Case
 */
class PublicNotesFadTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PublicNotesFadTable
     */
    protected $PublicNotesFad;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.PublicNotesFad',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PublicNotesFad') ? [] : ['className' => PublicNotesFadTable::class];
        $this->PublicNotesFad = $this->getTableLocator()->get('PublicNotesFad', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PublicNotesFad);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PublicNotesFadTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
