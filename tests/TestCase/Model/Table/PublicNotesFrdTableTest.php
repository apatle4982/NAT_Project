<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PublicNotesFrdTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PublicNotesFrdTable Test Case
 */
class PublicNotesFrdTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PublicNotesFrdTable
     */
    protected $PublicNotesFrd;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.PublicNotesFrd',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PublicNotesFrd') ? [] : ['className' => PublicNotesFrdTable::class];
        $this->PublicNotesFrd = $this->getTableLocator()->get('PublicNotesFrd', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PublicNotesFrd);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PublicNotesFrdTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
