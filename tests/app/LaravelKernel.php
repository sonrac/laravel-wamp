<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/24/17
 * Time: 12:29 PM
 */

namespace sonrac\WAMP\tests\app;

use \Illuminate\Foundation\Http\Kernel;
use sonrac\WAMP\Commands\RunServer;

class LaravelKernel extends Kernel
{
    protected $commands = [
        RunServer::class
    ];
}
