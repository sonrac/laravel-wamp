<?php
/**
 * Created by PhpStorm.
 *
 * @author Donii Sergii <doniysa@gmail.com>
 * Date: 10/24/17
 * Time: 12:29 PM
 */

namespace sonrac\WAMP\tests\app;

use Illuminate\Foundation\Console\Kernel;
use sonrac\WAMP\Commands\DownWAMP;
use sonrac\WAMP\Commands\RegisterRoutes;
use sonrac\WAMP\Commands\RunServer;

class LaravelKernel extends Kernel
{
    protected $commands = [
        RunServer::class,
        RegisterRoutes::class,
        DownWAMP::class,
    ];
}
