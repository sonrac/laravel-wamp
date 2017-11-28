<?php

/**
 * Class BackgroundCommandCest
 *
 * Background command test
 *
 * @author Donii Sergii <doniysa@gmail.com>
 */
class BackgroundCommandCest
{
    protected $phpBinary = null;

    public function _before(UnitTester $I)
    {
        $this->phpBinary = Mockery::mock('overload:Symfony\Component\Process\PhpExecutableFinder');
        $this->phpBinary->shouldReceive('find')->andReturn('php');
    }

    public function _after(UnitTester $I)
    {
    }

    // tests
    public function runBackGroundCommand(UnitTester $I)
    {
        $pid = \sonrac\WAMP\Commands\RunCommandInBackground::factory('wamp:register-routes')->runInBackground();

        $I->assertInternalType('int', $pid);
        $I->assertTrue(file_exists('/proc/'.$pid));
        exec('kill '.$pid);
        sleep(1);
        $I->assertFalse(file_exists('/proc/'.$pid));
    }
}
