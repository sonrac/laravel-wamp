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

    /**
     * @var \Thruway\Message\ErrorMessage
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $error;

    public function _before(UnitTester $tester)
    {
        Artisan::setFacadeApplication(app());
        Artisan::call('wamp:run-server', [
            '--realm'         => 'realm',
            '--host'          => '127.0.0.1',
            '--port'          => 9192,
            '--in-background' => '--in-background',
            '--no-debug'      => '--no-debug'
        ]);
        sleep(2);
        Artisan::call('wamp:register-routes', [
            '--realm'         => 'realm',
            '--host'          => '127.0.0.1',
            '--port'          => 9192,
            '--in-background' => '--in-background',
            '--no-debug'      => '--no-debug'
        ]);
        sleep(3);

        $this->tester = $tester;
    }

    protected $start = false;

    /**
     * @var null|\Thruway\CallResult
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $data = null;

    public function _after(UnitTester $tester)
    {
        Artisan::call('wamp:stop');
    }

    public function callProcedure(UnitTester $tester)
    {

        app()->wampClient->addTransportProvider(new \Thruway\Transport\PawlTransportProvider(
            'ws://127.0.0.1:9192'
        ));
        app()->wampClient->on('open', function (\Thruway\ClientSession $session) {
            $session->call('test')->then(function (\Thruway\CallResult $res) use ($session) {
                app()->wampClient->onClose('Done',false);
                app()->wampClient->getLoop()->stop();
                $session->getLoop()->stop();
                $this->data = $res;
                $this->start = true;
                $this->tester->assertInstanceOf(\Thruway\CallResult::class, $this->data);
                $this->tester->assertEquals('test_message', $this->data->getResultMessage()->getArguments()[0]);
            }, function (\Thruway\Message\ErrorMessage $error) use (&$tester, $session) {
                $this->error = $error;
                $this->start = true;
                app()->wampClient->onClose('Done',false);
                app()->wampClient->getLoop()->stop();
                $session->getLoop()->stop();
            });
        });
        app()->wampClient->start(true);
    }
}
