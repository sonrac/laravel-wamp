<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/23/17
 * Time: 4:18 PM
 */

$isLumen = !class_exists('\Laravel\Lumen\Application');

return require  ($isLumen ? require __DIR__ . '/lumen.php' : __DIR__ . '/laravel.php');