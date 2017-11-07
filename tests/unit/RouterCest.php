<?php

use sonrac\WAMP\Routers\Router;
use Thruway\Event\ConnectionCloseEvent;
use Thruway\Event\ConnectionOpenEvent;
use Thruway\Event\RouterStartEvent;
use Thruway\Event\RouterStopEvent;

class RouterCest
{
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
    public function testConnectionRouterEventsDispatch(UnitTester $tester)
    {
        $this->router->onConnectionOpen(function () {
            return '123';
        });

        $this->router->removeEvent(Router::EVENT_CONNECTION_OPEN,
            $this->router->getEventDispatcher()->getListeners(Router::EVENT_CONNECTION_OPEN)[0]);

        $session = Mockery::mock(\Thruway\Session::class);
        $session->shouldReceive('getSessionId')->andReturn(123);
        $session->dispatcher = Mockery::mock(\Thruway\Event\EventDispatcher::class);
        $session->dispatcher->shouldReceive('addRealmSubscriber')
            ->andReturn(1);

        $tester->assertInstanceOf(ConnectionOpenEvent::class, $result = $this->router->getEventDispatcher()
            ->dispatch(Router::EVENT_CONNECTION_OPEN, new ConnectionOpenEvent($session)));
    }

    public function testConnectionRemoveEventCallback(UnitTester $tester)
    {
        $callback = function () {
        };
        $this->router->onConnectionOpen($callback);
        $tester->assertCount(3, $this->router->getEventDispatcher()->getListeners(Router::EVENT_CONNECTION_OPEN));
        $this->router->removeEvent(Router::EVENT_CONNECTION_OPEN, $callback);
        $tester->assertCount(2, $this->router->getEventDispatcher()->getListeners(Router::EVENT_CONNECTION_OPEN));
    }

    public function testCloseRouterEventsDispatch(UnitTester $tester)
    {
        $this->router->onConnectionOpen(function () {
            return '123';
        });

        $this->router->removeEvent(Router::EVENT_CONNECTION_CLOSE,
            $this->router->getEventDispatcher()->getListeners(Router::EVENT_CONNECTION_CLOSE)[0]);

        $session = Mockery::mock(\Thruway\Session::class);
        $session->shouldReceive('getSessionId')->andReturn(123);
        $session->dispatcher = Mockery::mock(\Thruway\Event\EventDispatcher::class);
        $session->dispatcher->shouldReceive('addRealmSubscriber')
            ->andReturn(1);

        $tester->assertInstanceOf(ConnectionCloseEvent::class, $result = $this->router->getEventDispatcher()
            ->dispatch(Router::EVENT_CONNECTION_CLOSE, new ConnectionCloseEvent($session)));
    }

    public function testCloseRemoveEventCallback(UnitTester $tester)
    {
        $callback = function () {
        };
        $this->router->onConnectionClose($callback);
        $tester->assertCount(3, $this->router->getEventDispatcher()->getListeners(Router::EVENT_CONNECTION_CLOSE));
        $this->router->removeEvent(Router::EVENT_CONNECTION_CLOSE, $callback);
        $tester->assertCount(2, $this->router->getEventDispatcher()->getListeners(Router::EVENT_CONNECTION_CLOSE));
    }

    public function testRouteStartRouterEventsDispatch(UnitTester $tester)
    {
        $this->router->onConnectionOpen(function () {
            return '123';
        });

        $session = Mockery::mock(\Thruway\Session::class);
        $session->shouldReceive('getSessionId')->andReturn(123);
        $session->dispatcher = Mockery::mock(\Thruway\Event\EventDispatcher::class);
        $session->dispatcher->shouldReceive('addRealmSubscriber')
            ->andReturn(1);

        $tester->assertInstanceOf(RouterStartEvent::class, $result = $this->router->getEventDispatcher()
            ->dispatch(Router::EVENT_ROUTER_START, new RouterStartEvent()));
    }

    public function testRouteStartRemoveEventCallback(UnitTester $tester)
    {
        $callback = function () {
        };
        $this->router->onRouterStart($callback);
        $tester->assertCount(1, $this->router->getEventDispatcher()->getListeners(Router::EVENT_ROUTER_START));
        $this->router->removeEvent(Router::EVENT_ROUTER_START, $callback);
        $tester->assertCount(0, $this->router->getEventDispatcher()->getListeners(Router::EVENT_ROUTER_START));
    }

    public function testRouteStopRouterEventsDispatch(UnitTester $tester)
    {
        $this->router->onConnectionOpen(function () {
            return '123';
        });

        $session = Mockery::mock(\Thruway\Session::class);
        $session->shouldReceive('getSessionId')->andReturn(123);

        $tester->assertInstanceOf(RouterStopEvent::class, $result = $this->router->getEventDispatcher()
            ->dispatch(Router::EVENT_ROUTER_STOP, new RouterStopEvent()));
    }

    public function testRouteStopRemoveEventCallback(UnitTester $tester)
    {
        $callback = function () {
        };
        $this->router->onRouterStop($callback);
        $tester->assertCount(1, $this->router->getEventDispatcher()->getListeners(Router::EVENT_ROUTER_STOP));
        $this->router->removeEvent(Router::EVENT_ROUTER_STOP, $callback);
        $tester->assertCount(0, $this->router->getEventDispatcher()->getListeners(Router::EVENT_ROUTER_STOP));
    }

    public function testRemoveEvent(UnitTester $tester)
    {
        $tester->assertCount(2, $this->router->getEventDispatcher()->getListeners(Router::EVENT_CONNECTION_OPEN));
        $this->router->onConnectionOpen(['handleConnectionOpen', 10]);
        $tester->assertCount(3, $this->router->getEventDispatcher()->getListeners(Router::EVENT_CONNECTION_OPEN));
        $this->router->removeEvent(Router::EVENT_CONNECTION_OPEN, ['handleConnectionOpen', 10]);
        $tester->assertCount(2, $this->router->getEventDispatcher()->getListeners(Router::EVENT_CONNECTION_OPEN));
    }

    public function testGroupRoutes(UnitTester $tester)
    {
        app()->rpcRouter->group([
            'namespace' => 'test',
        ], function ($clientSession, $client) {
        });

        $tester->assertCount(1, app()->rpcRouter->getGroups());
    }

    public function testSetGetClient(UnitTester $tester)
    {
        $client = Mockery::mock(\sonrac\WAMP\Client::class);
        app()->wampRouter->setClient($client);

        $tester->assertEquals($client, app()->wampRouter->getClient());
    }

    public function testSetRouter(UnitTester $tester)
    {
        $this->router->setRouter(app()->wampRouter);

        $tester->assertEquals(app()->wampRouter, $this->router->getRouter());
    }

    public function testControllerNamespace(UnitTester $tester)
    {
        app()->wampRouter->setControllerNamespace('\test');

        $tester->assertEquals('\test', app()->wampRouter->getControllerNamespace());
    }
}
