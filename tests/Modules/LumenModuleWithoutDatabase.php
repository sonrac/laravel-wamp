<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii <doniysa@gmail.com>
 * Date: 11/6/17
 * Time: 6:19 PM
 */

namespace sonrac\WAMP\tests\Modules;

use Codeception\Lib\Connector\Lumen as LumenConnector;
use Codeception\Module\Lumen;
use Codeception\TestInterface;

/**
 * @class  LumenModule
 * <summary>
 *
 * @author Donii Sergii <doniysa@gmail.com>
 */
class LumenModuleWithoutDatabase extends Lumen
{
    public function _before(TestInterface $test)
    {
        $this->client = new LumenConnector($this);
    }

    public function _after(TestInterface $test)
    {
    }
}
