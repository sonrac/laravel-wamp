<?php
/**
 * Created by PhpStorm.
 *
 * @author Donii Sergii <doniysa@gmail.com>
 * Date: 10/24/17
 * Time: 10:32 AM
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Router Realm
    |--------------------------------------------------------------------------
    |
    | The realm that the router should use.
    |
    */
    'realm' => 'minion',

    /*
    |--------------------------------------------------------------------------
    | Router Host
    |--------------------------------------------------------------------------
    |
    | The IP or hostname that the router should run under.
    |
    */
    'host' => '127.0.0.1',

    /*
    |--------------------------------------------------------------------------
    | Router Port
    |--------------------------------------------------------------------------
    |
    | The port that should be used by the router.
    |
    */
    'port' => 9090,

    /*
    |--------------------------------------------------------------------------
    | Auto-registered Providers
    |--------------------------------------------------------------------------
    |
    | The providers listed here will be automatically registered on the
    | session start of the router, in return their role is to register RPCs,
    | subscribe and publish to topics and pretty much whatever an Internal Client does.
    |
    */
    'providers' => [
    ],

    'debug' => false,

    /*
    |--------------------------------------------------------------------------
    | Transport Layer Security
    |--------------------------------------------------------------------------
    |
    | Toggle between ws/wss protocol
    |
    */
    'tls' => false,

    /*
    |--------------------------------------------------------------------------
    | URL path component
    |--------------------------------------------------------------------------
    |
    | Will be appended to the transport URL as the path component
    |
    */
    'path' => '/ws',

    /*
    |--------------------------------------------------------------------------
    | Log component
    |--------------------------------------------------------------------------
    |
    | Custom log for WAMP server & client
    |
    */
    'pathLogFile' => storage_path('logs/wamp.log'),

    /*
    |--------------------------------------------------------------------------
    | Transport provider class
    |--------------------------------------------------------------------------
    |
    | Transport provider class for WAMP server. By default is
    | \Thruway\Transport\ClientTransportProviderInterface
    |
    */
    'transportProvider' => null,

    /*
    |--------------------------------------------------------------------------
    | WAMP routers path
    |--------------------------------------------------------------------------
    |
    | Path to entry point
    |
    */
    'routePath' => null,
];
