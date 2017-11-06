<?php

use Mockery;

/**
 * Class ClientTestCest
 * Client test
 *
 * @author Donii Sergii <doniysa@gmail.com>
 */
class ClientTestCest
{
    protected $client = null;
    protected $session = null;
    protected $transport = null;

    public function _before(UnitTester $I)
    {
        $this->client = new \sonrac\WAMP\Client('ws://127.0.0.1:9090');
        $this->session = Mockery::mock(\Thruway\Session::class);
        $this->transport = Mockery::mock(\Thruway\Transport\PawlTransportProvider::class);
    }

    public function _after(UnitTester $I)
    {
    }

    // tests
    public function testClientRoutes(UnitTester $tester)
    {
        $client = $this->client;
        $session = $this->session;
        $transport = $this->transport;

        require __DIR__.'/../_data/routes.php';
    }

    public function testClientRoutesInPath(UnitTester $tester) {
        $this->client->setRoutePath(__DIR__.'/../_data/routes');

        $this->client->onSessionStart($this->session, $this->transport);

        $tester->assertEquals(app()->wampRouter->getClient(), $this->client);
    }

    public function testClientRoutesInFile(UnitTester $tester) {
        $this->client->setRoutePath(__DIR__.'/../_data/routes/routes-main.php');

        $this->client->onSessionStart($this->session, $this->transport);

        $tester->assertEquals(app()->wampRouter->getClient(), $this->client);
    }
}
