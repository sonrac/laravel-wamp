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
        $tester->assertInstanceOf(\React\Promise\Promise::class, $this->router->addRoute('asd', $callback));
        $tester->assertInstanceOf(\React\Promise\Promise::class, app()->rpcRouter->addRoute('asd', $callback));
    }

    // tests
    public function testClientController(UnitTester $tester)
    {
        $callback = 'HtmlController@testAction';
        $client = Mockery::mock(\sonrac\WAMP\Client::class);
        $session = Mockery::mock(\Thruway\ClientSession::class);

        $session->shouldReceive('register')
            ->andReturn(new \React\Promise\Promise(function () use ($callback) {return $callback;}));

        $client->shouldReceive('getSession')
            ->andReturn($session);

        $this->router->setClient($client);

        $promise = $this->router->getClient()->getSession()->register('asd', $callback);

        $tester->assertInstanceOf(\React\Promise\Promise::class, $promise);
        $tester->assertInstanceOf(\React\Promise\Promise::class, $this->router->addRoute('asd', $callback));
        $tester->assertInstanceOf(\React\Promise\Promise::class, app()->rpcRouter->addRoute('asd', $callback));
    }
}