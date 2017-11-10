<?php

require_once __DIR__.'/../_support/CallTest.php';

use Illuminate\Support\Facades\Artisan;

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
        Artisan::setFacadeApplication(app());
        Artisan::call('wamp:run-server', [
            '--realm'         => 'realm',
            '--host'          => '127.0.0.1',
            '--port'          => 9192,
            '--in-background' => '--in-background',
            '--no-debug'      => '--no-debug',
        ]);
        sleep(2);
        Artisan::call('wamp:register-routes', [
            '--realm'         => 'realm',
            '--host'          => '127.0.0.1',
            '--port'          => 9192,
            '--in-background' => '--in-background',
            '--no-debug'      => '--no-debug',
        ]);
        sleep(3);

        $this->tester = $tester;
    }

    public function _after(UnitTester $tester)
    {
        Artisan::call('wamp:stop');
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

        app()->wampClient->on('open', function (\Thruway\ClientSession $session) {
            $session->call('test')->then(function (\Thruway\CallResult $res) use ($session) {
                app()->wampClient->onClose('Done', false);
                app()->wampClient->getLoop()->stop();
                $session->getLoop()->stop();
                $this->tester->assertInstanceOf(\Thruway\CallResult::class, $res);
                $this->tester->assertEquals('test_message', $res->getResultMessage()->getArguments()[0]);
            }, function (\Thruway\Message\ErrorMessage $error) use (&$tester, $session) {
                app()->wampClient->onClose('Done', false);
                app()->wampClient->getLoop()->stop();
                $session->getLoop()->stop();
            });
        });
        app()->wampClient->start(true);
    }

    /**
     * Subscribe
     *
     * @param \UnitTester $tester
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function subscribeTest(UnitTester $tester)
    {
        $this->prepareClient();

        app()->wampClient->on('open', function (\Thruway\ClientSession $session) {
            $session->subscribe('com.test.publish', function ($res, $arg = null, $arg1 = null, $arg2 = null) use ($session) {
                app()->wampClient->onClose('Done', false);
                app()->wampClient->getLoop()->stop();
                $session->getLoop()->stop();

                $this->tester->assertInternalType('array', $res);
                $this->tester->assertCount(4, $res);
                $this->tester->assertCount(3, $res[0]);
                $this->tester->assertEquals([1, 2, 3], $res[0]);
            }, function (\Thruway\Message\ErrorMessage $error) use (&$tester, $session) {
                app()->wampClient->onClose('Done', false);
                app()->wampClient->getLoop()->stop();
                $session->getLoop()->stop();
            });

            $session->publish('com.hello');
        });
        app()->wampClient->start(true);
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
        app()->wampClient->addTransportProvider(new \Thruway\Transport\PawlTransportProvider(
            $host
        ));
    }
}
