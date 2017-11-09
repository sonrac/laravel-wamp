<?php

require_once __DIR__.'/../_support/CallTest.php';

class RoutesCallCest
{
    /**
     * @var \UnitTester $tester
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

    /**
     * @var null|\React\Promise\Promise
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $promise = null;

    public function _before(UnitTester $tester)
    {
//        Artisan::setFacadeApplication(app());
//        Artisan::call('wamp:run-server', [
//            '--realm'         => 'realm',
//            '--host'          => '127.0.0.1',
//            '--port'          => 9192,
//            '--in-background' => '--in-background',
//            '--no-debug'      => '--no-debug'
//        ]);
//        Artisan::call('wamp:register-routes', [
//            '--realm'         => 'realm',
//            '--host'          => '127.0.0.1',
//            '--port'          => 9192,
//            '--in-background' => '--in-background',
//            '--no-debug'      => '--no-debug'
//        ]);
//        sleep(5);

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
//        Artisan::call('wamp:stop');
        register_shutdown_function(function () {

        });
    }

    public function callProcedure(UnitTester $tester)
    {

        app()->wampClient->addTransportProvider(new \Thruway\Transport\PawlTransportProvider(
            'ws://127.0.0.1:9090'
        ));
        app()->wampClient->on('open', function (\Thruway\ClientSession $session) {
            $this->promise = $session->call('test')->then(function (\Thruway\CallResult $res) use ($session) {
                app()->wampClient->onClose('Done',false);
                app()->wampClient->getLoop()->stop();
                $session->getLoop()->stop();
                $this->data = $res;
                $this->start = true;
                $this->tester->assertInstanceOf(\Thruway\CallResult::class, $this->data);
                $this->tester->assertEquals('test_message', $this->data->getResultMessage()->getArguments()[0]);
                $this->killProcess();
                \React\Promise\resolve($this->promise);
            }, function (\Thruway\Message\ErrorMessage $error) use (&$tester, $session) {
                $this->error = $error;
                $this->start = true;
                app()->wampClient->onClose('Done',false);
                app()->wampClient->getLoop()->stop();
                $session->getLoop()->stop();
                \React\Promise\resolve($this->promise);
            });
        });
        if (!$this->start) {
            $this->start = true;
            app()->wampClient->start(true);
            $_SESSION['stop_loop'] = true;
        }

//        $loop = React\EventLoop\Factory::create();
//
//        $asyncPromise = new React\Promise\Promise(function($resolve) use ($loop) {
//            $loop->nextTick(function() use($resolve) {
//            });
//        });
//
//        $syncPromise = new React\Promise\Promise(function($resolve) {
//            $resolve('Sync Promise');
//        });
//
//        $asyncPromise->then(function($value) {
//            echo $value.PHP_EOL;
//        });
//
//        $syncPromise->then(function($value) {
//            echo $value.PHP_EOL;
//        });
//
//        $loop->run();
    }

    protected function killProcess() {

    }

    protected function test() {


    }
}
