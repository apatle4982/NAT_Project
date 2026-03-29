<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FieldSectionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FieldSectionsTable Test Case
 */
class FieldSectionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FieldSectionsTable
     */
    protected $FieldSections;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FieldSections',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FieldSections') ? [] : ['className' => FieldSectionsTable::class];
        $this->FieldSections = $this->getTableLocator()->get('FieldSections', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FieldSections);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FieldSectionsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
