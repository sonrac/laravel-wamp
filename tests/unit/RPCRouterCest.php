<?php


class RPCRouterCest
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
    public function testClient(UnitTester $tester)
    {
        $callback = function () {
            return 123;
        };
        $client = Mockery::mock(\sonrac\WAMP\Client::class);
        $session = Mockery::mock(\Thruway\ClientSession::class);

        $session->shouldReceive('register')
            ->andReturn(new \React\Promise\Promise($callback));

        $client->shouldReceive('getSession')
            ->andReturn($session);

        $this->router->setClient($client);

        $promise = $this->router->getClient()->getSession()->register('asd', $callback);

        $tester->assertInstanceOf(\React\Promise\Promise::class, $promise);
    }

    // tests
    public function testClientController(UnitTester $tester)
    {
        $callback = 'HtmlController@testAction';
        $client = Mockery::mock(\sonrac\WAMP\Client::class);
        $session = Mockery::mock(\Thruway\ClientSession::class);

        $session->shouldReceive('register')
            ->andReturn(new \React\Promise\Promise(function () use ($callback) {
                return $callback;
            }));

        $client->shouldReceive('getSession')
            ->andReturn($session);

        $this->router->setClient($client);

        $promise = $this->router->getClient()->getSession()->register('asd', $this->router->parseCallback($callback));

        $tester->assertInstanceOf(\React\Promise\Promise::class, $promise);
    }

    public function testAddRoutesGroups(UnitTester $tester)
    {
        app()->rpcRouter->group([
            'namespace' => '\test',
        ], function ($session, $client) use ($tester) {
            return null; //app()->rpcRouter->addRoute('test', 'HomeController@index');
        });
        $router = app()->wampRouter;
        app()->rpcRouter->setRouter($router);
        $session = Mockery::mock(\Thruway\Session::class);
        $session->shouldReceive('register');
        $client = Mockery::mock(\sonrac\WAMP\Client::class);
        $client->shouldReceive('getSession')
            ->andReturn($session);
        $router->setClient($client);

        $callbacks = app()->rpcRouter->parseGroups();

        $tester->assertCount(1, $callbacks);
    }

    public function parseCallbackTest(UnitTester $tester)
    {
        $callback = $this->router->parseCallback('Test');

        $tester->assertInstanceOf(\Closure::class, $callback);

        $callback = $this->router->parseCallback($origCallback = function () {
        });

        $tester->assertInstanceOf(\Closure::class, $callback);
        $tester->assertEquals($origCallback, $callback);
    }
}
