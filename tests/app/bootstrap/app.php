<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/23/17
 * Time: 4:18 PM
 */

require __DIR__ . '/../../../vendor/autoload.php';

$isLumen = class_exists('\Laravel\Lumen\Application');

return require ($isLumen ? __DIR__ . '/lumen.php' : __DIR__ . '/laravel.php');