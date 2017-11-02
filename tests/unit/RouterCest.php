<?php

use Codeception\Util\Stub;
use sonrac\WAMP\Routers\Router;

class RouterCest
{
    protected $openConnection = null;
    protected $closeConnection = null;
    protected $startRouter = null;
    protected $stopRouter = null;

    protected $router;

    public function _before(UnitTester $I)
    {
    }

    public function _after(UnitTester $I)
    {
    }

    // tests
    public function testRouterEvents(UnitTester $I)
    {

    }
}
