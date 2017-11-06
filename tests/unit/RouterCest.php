<?php

use sonrac\WAMP\Routers\Router;
use Thruway\Event\ConnectionOpenEvent;

class RouterCest
{
    protected $openConnection = null;
    protected $closeConnection = null;
    protected $startRouter = null;
    protected $stopRouter = null;

    /**
     * @var \sonrac\WAMP\Routers\Router
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $router;

    public function _before(UnitTester $I)
    {
        $this->router = app()->wampRouter;
    }

    public function _after(UnitTester $I)
    {
    }

    // tests
    public function testRouterEventsDispatch(UnitTester $tester)
    {
        $this->router->onConnectionOpen(function () {
            return '123';
        });

        $this->router->removeEvent(Router::EVENT_CONNECTION_OPEN, $this->router->getEventDispatcher()->getListeners(Router::EVENT_CONNECTION_OPEN)[0]);

        $session = Mockery::mock(\Thruway\Session::class);
        $session->shouldReceive('getSessionId')->andReturn(123);

        $tester->assertInstanceOf(ConnectionOpenEvent::class, $result = $this->router->getEventDispatcher()
            ->dispatch(Router::EVENT_CONNECTION_OPEN, new ConnectionOpenEvent($session)));
    }

    public function testRemoveEventCallback(UnitTester $tester)
    {
        $callback = function () {
        };
        $this->router->onConnectionOpen($callback);
        $tester->assertCount(2, $this->router->getEventDispatcher()->getListeners(Router::EVENT_CONNECTION_OPEN));
        $this->router->removeEvent(Router::EVENT_CONNECTION_OPEN, $callback);
        $tester->assertCount(1, $this->router->getEventDispatcher()->getListeners(Router::EVENT_CONNECTION_OPEN));
    }

    public function testRemoveEvent(UnitTester $tester)
    {
        $tester->assertCount(1, $this->router->getEventDispatcher()->getListeners(Router::EVENT_CONNECTION_OPEN));
        $this->router->onConnectionOpen(['handleConnectionOpen', 10]);
        $tester->assertCount(2, $this->router->getEventDispatcher()->getListeners(Router::EVENT_CONNECTION_OPEN));
        $this->router->removeEvent(Router::EVENT_CONNECTION_OPEN, ['handleConnectionOpen', 10]);
        $tester->assertCount(1, $this->router->getEventDispatcher()->getListeners(Router::EVENT_CONNECTION_OPEN));
    }
}
