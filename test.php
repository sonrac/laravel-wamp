<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/20/17
 * Time: 5:28 PM
 */
require __DIR__.'/vendor/autoload.php';

use Vinelab\Minion\Minion;
use Vinelab\Minion\Client;

// Get a minion instance
$m = new Minion;
$c = new Client('realm', []);

$add = function ($x, $y) { return $x + $y; };

// Register a closure provider
$m->register(function (Client $client) use ($add) {

    // register
    $client->register('add', $add);

    // subscribe
    $client->subscribe('some.topic', function ($data) {
        // do things with data
        $data->key;
        $data->other_key;
        var_dump(123);
    });

    // publish
    $client->publish('i.am.here', ['name' => 'mr.minion']);
    $client->publish('some.topic', ['name' => 'mr.minion']);
});

$c->publish('some.topic', ['name' => 'mr.minion']);