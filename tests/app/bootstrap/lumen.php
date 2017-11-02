<?php
/**
 * Created by PhpStorm.
 * @author Donii Sergii <doniysa@gmail.com>
 * Date: 10/23/17
 * Time: 4:47 PM
 */

$app = new \Laravel\Lumen\Application(
    __DIR__ . '/../'
);

$app->instance('path.config', app()->basePath() . DIRECTORY_SEPARATOR . 'config');
$app->instance('path.storage', app()->basePath() . DIRECTORY_SEPARATOR . 'storage');

$app->singleton(
    \Illuminate\Contracts\Http\Kernel::class,
    \Laravel\Lumen\Console\Kernel::class
);

$app->singleton(
    \Illuminate\Contracts\Console\Kernel::class,
    \sonrac\WAMP\tests\app\LumenKernel::class
);

$app->singleton(
    \Illuminate\Contracts\Debug\ExceptionHandler::class,
    \Laravel\Lumen\Exceptions\Handler::class
);

return $app;