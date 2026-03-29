<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PublicNotesFrtpdTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PublicNotesFrtpdTable Test Case
 */
class PublicNotesFrtpdTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PublicNotesFrtpdTable
     */
    protected $PublicNotesFrtpd;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.PublicNotesFrtpd',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PublicNotesFrtpd') ? [] : ['className' => PublicNotesFrtpdTable::class];
        $this->PublicNotesFrtpd = $this->getTableLocator()->get('PublicNotesFrtpd', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PublicNotesFrtpd);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PublicNotesFrtpdTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
