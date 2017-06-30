<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AppSessionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AppSessionsTable Test Case
 */
class AppSessionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AppSessionsTable
     */
    public $AppSessions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.app_sessions',
        'app.users',
        'app.roles',
        'app.statuses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AppSessions') ? [] : ['className' => 'App\Model\Table\AppSessionsTable'];
        $this->AppSessions = TableRegistry::get('AppSessions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AppSessions);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
