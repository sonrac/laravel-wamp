<?php

class RoutesCallCest
{
    public function _before(UnitTester $I)
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
    }

    protected $start = false;
    protected $data = null;

    public function _after(UnitTester $I)
    {
//        Artisan::call('wamp:stop');
    }

    public function callProcedure(UnitTester $tester)
    {
        app()->wampClient->addTransportProvider(new \Thruway\Transport\PawlTransportProvider(
            'ws://127.0.0.1:9090'
        ));
        app()->wampClient->on('open', function (\Thruway\ClientSession $session) use (&$tester) {
            $session->call('test')->then(function ($res) use (&$tester) {
                $tester->assertEquals('test_message', $res);
                app()->wampClient->emit('close');
            }, function (\Thruway\Message\ErrorMessage $error) use (&$tester) {
                app()->wampClient->getLoop()->stop();
            });
        });

        $this->start = true;
        app()->wampClient->start(false);

        $tester->assertTrue(true);
    }

    // tests

    /**
     * @param \Thruway\Message\ErrorMessage $error
     * @param \UnitTester                   $tester
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    private function checkError($error, $tester)
    {
        $tester->assertEquals(481, $error->getErrorMsgCode());
    }
}
