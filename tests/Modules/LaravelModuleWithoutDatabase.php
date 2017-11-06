<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii <doniysa@gmail.com>
 * Date: 11/6/17
 * Time: 6:19 PM
 */

namespace sonrac\WAMP\tests\Modules;

use Codeception\Lib\Connector\Laravel5 as LaravelConnector;
use Codeception\Module\Laravel5;
use Codeception\TestInterface;

/**
 * @class  LumenModule
 * <summary>
 *
 * @author Donii Sergii <doniysa@gmail.com>
 */
class LaravelModuleWithoutDatabase extends Laravel5
{
    public function _before(TestInterface $test)
    {
        $this->client = new LaravelConnector($this);
    }

    public function _after(TestInterface $test)
    {
    }
}
