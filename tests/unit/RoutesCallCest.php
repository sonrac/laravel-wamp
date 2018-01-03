<?php

require_once __DIR__.'/../_support/CallTest.php';

class RoutesCallCest
{
    /**
     * @var \UnitTester
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $tester;

    public function _before(UnitTester $tester)
    {
//        Artisan::setFacadeApplication(app());
//        Artisan::call('wamp:run-server', [
//            '--realm'         => 'realm',
//            '--host'          => '127.0.0.1',
//            '--port'          => 9192,
//            '--in-background' => '--in-background',
//            '--no-debug'      => '--no-debug',
//        ]);
//        sleep(2);
//        Artisan::call('wamp:register-routes', [
//            '--realm'         => 'realm',
//            '--host'          => '127.0.0.1',
//            '--port'          => 9192,
//            '--in-background' => '--in-background',
//            '--no-debug'      => '--no-debug',
//        ]);
//        sleep(1);

        $this->tester = $tester;
    }

    public function _after(UnitTester $tester)
    {
//        Artisan::call('wamp:stop');
//        sleep(1);
    }

    /**
     * Call procedure test
     *
     * @param \UnitTester $tester
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function callProcedure(UnitTester $tester)
    {
        $this->prepareClient();

        $result = [];
        app()->wampClient->on('open', function (\Thruway\ClientSession $session) use (&$result) {
            $session->call('test')->then(function (\Thruway\CallResult $res) use ($session, &$result) {
                $result = [
                    'obj'  => $res,
                    'data' => $res->getResultMessage()->getArguments(),
                ];
                $session->getLoop()->stop();
                $this->closeLoop();
            }, function (\Thruway\Message\ErrorMessage $error) use (&$tester, $session) {
                $this->closeLoop();
                $session->getLoop()->stop();
            }, function () {

            });
        });
        app()->wampClient->start(true);

        $this->tester->assertArrayHasKey('obj', $result);
        $this->tester->assertInstanceOf(\Thruway\CallResult::class, $result['obj']);
        $this->tester->assertInternalType('array', $result['data']);
        $this->tester->assertEquals('test_message', $result['data'][0]);
    }

    /**
     * Call procedure test
     *
     * @param \UnitTester $tester
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function subscribeFromGroup(UnitTester $tester)
    {
        $this->prepareClient();

        $result = [];

        app()->wampClient->on('open', function (\Thruway\ClientSession $session) use (&$result) {
            $session->subscribe('wamp.test', function (\Thruway\CallResult $res) use (&$result, $session) {
                $result = [
                    'obj'  => $res,
                    'data' => $res->getResultMessage()->getArguments(),
                ];
                $this->closeLoop();
                $session->getLoop()->stop();
            }, function (\Thruway\Message\ErrorMessage $error) use (&$tester, $session) {
                var_dump($error);
                $this->closeLoop();
                $session->getLoop()->stop();
            });
            $session->publish('wamp.test', ['Test Message'], [], ["acknowledge" => true])->then(
                function () {
                    echo PHP_EOL."Publish Acknowledged!".PHP_EOL;
                },
                function ($error) {
                    // publish failed
                    echo PHP_EOL."Publish Error {$error}".PHP_EOL;
                    $this->closeLoop();
                }
            );
        });

        app()->wampClient->start(true);
        $this->tester->assertArrayHasKey('obj', $result);
        $this->tester->assertArrayHasKey('data', $result);
        $this->tester->assertInstanceOf(\Thruway\CallResult::class, $result['obj']);
        $this->tester->assertEquals('test', $result['data'][0]);
    }

    /**
     * Close loop
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    private function closeLoop()
    {
        app()->wampClient->onClose('Done', false);
        app()->wampClient->getLoop()->stop();
    }

    /**
     * Prepare client
     *
     * @param string $host Wamp host
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    private function prepareClient($host = 'ws://127.0.0.1:9192')
    {
        app()->wampClient = new \sonrac\WAMP\Client('realm');
        app()->wampClient->addTransportProvider(new \Thruway\Transport\PawlTransportProvider(
            $host
        ));
    }
}
