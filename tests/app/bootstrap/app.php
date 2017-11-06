<?php
/**
 * Created by PhpStorm.
 *
 * @author Donii Sergii <doniysa@gmail.com>
 * Date: 10/23/17
 * Time: 4:18 PM
 */
require __DIR__.'/../../../vendor/autoload.php';

use sonrac\WAMP\WAMPServiceProvider;

$isLumen = class_exists('\Laravel\Lumen\Application');

/** @var \Laravel\Lumen\Application|\Illuminate\Foundation\Application $app */
$app = require $isLumen ? __DIR__.'/lumen.php' : __DIR__.'/laravel.php';

$app->register(WAMPServiceProvider::class);

$app->router->onOpen();

return $app;
