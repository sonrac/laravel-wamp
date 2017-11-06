<?php
/**
 * Created by PhpStorm.
 *
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

$app->singleton(
    \Illuminate\Contracts\Http\Kernel::class,
    \Illuminate\Foundation\Http\Kernel::class
);

$app->singleton(
    \Illuminate\Contracts\Debug\ExceptionHandler::class,
    \Illuminate\Foundation\Exceptions\Handler::class
);

return $app;
