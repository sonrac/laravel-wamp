<?php
/**
 * Created by PhpStorm.
 * @author Donii Sergii <doniysa@gmail.com>
 * Date: 10/23/17
 * Time: 4:47 PM
 */

$app = new \Illuminate\Foundation\Application(
    __DIR__.'/../'
);

$app->singleton(
    \Illuminate\Contracts\Console\Kernel::class,
    \sonrac\WAMP\tests\app\LaravelKernel::class
);

return $app;