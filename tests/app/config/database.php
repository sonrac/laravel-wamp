<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/25/17
 * Time: 11:16 AM
 */

return [
    'default' => 'sqlite',
    'connections' => [
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => __DIR__ . '/../../_output/database.sqlite',
            'prefix'   => env('DB_PREFIX', ''),
        ]
    ]
];
