<?php

use sonrac\WAMP\Commands\RunServer;

/**
 * Class RunServerCommandCest
 * Run server command test
 *
 */
class RunServerCommandCest
{
    public function _before(UnitTester $I)
    {
    }

    public function _after(UnitTester $I)
    {
    }

    // tests
    public function tryToTest(UnitTester $I)
    {
        $command = new RunServer();
    }

    /**
     * Test background server run
     *
     * @param \UnitTester $I
     */
    public function testBackgroundMode(UnitTester $I) {

    }
}
