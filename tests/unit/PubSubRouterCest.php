<?php

class PubSubRouterCest
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

        $session->shouldReceive('subscribe')
            ->andReturn(new \React\Promise\Promise($callback));

        $client->shouldReceive('getSession')
            ->andReturn($session);

        $this->router->setClient($client);

        $promise = $this->router->getClient()->getSession()->subscribe('asd', $callback);

        $tester->assertInstanceOf(\React\Promise\Promise::class, $promise);
        $tester->assertInstanceOf(\React\Promise\Promise::class, $this->router->addSubscriber('asd', $callback));
        $tester->assertInstanceOf(\React\Promise\Promise::class, app()->pubSubRouter->addRoute('asd', $callback));
    }
}
