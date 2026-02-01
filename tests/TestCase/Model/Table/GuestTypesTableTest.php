<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GuestTypesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GuestTypesTable Test Case
 */
class GuestTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GuestTypesTable
     */
    protected $GuestTypes;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.GuestTypes',
        'app.Guests',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('GuestTypes') ? [] : ['className' => GuestTypesTable::class];
        $this->GuestTypes = $this->getTableLocator()->get('GuestTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->GuestTypes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\GuestTypesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
