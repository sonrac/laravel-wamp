<?php

use sonrac\WAMP\WAMPServiceProvider;

class ServiceProviderCest
{
    public function _before(UnitTester $I)
    {
    }

    public function _after(UnitTester $I)
    {
    }

    // tests
    public function tryToTest(UnitTester $tester)
    {
        $provider = new WAMPServiceProvider(app());

        $provider->register();

        $tester->assertInstanceOf(\sonrac\WAMP\Client::class, app()->wampClient);
    }
}
