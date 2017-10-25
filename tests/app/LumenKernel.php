<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/24/17
 * Time: 12:29 PM
 */

namespace sonrac\WAMP\tests\app;

use Laravel\Lumen\Console\Kernel;
use sonrac\WAMP\Commands\RunServer;

class LumenKernel extends Kernel
{
    protected $commands = [
        RunServer::class
    ];
}
