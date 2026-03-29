<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PublicNotesCoversheetTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PublicNotesCoversheetTable Test Case
 */
class PublicNotesCoversheetTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PublicNotesCoversheetTable
     */
    protected $PublicNotesCoversheet;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.PublicNotesCoversheet',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PublicNotesCoversheet') ? [] : ['className' => PublicNotesCoversheetTable::class];
        $this->PublicNotesCoversheet = $this->getTableLocator()->get('PublicNotesCoversheet', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PublicNotesCoversheet);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PublicNotesCoversheetTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
