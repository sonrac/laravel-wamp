<?php
/**
 * Created by PhpStorm.
 *
 * @author Donii Sergii <doniysa@gmail.com>
 * Date: 10/23/17
 * Time: 3:41 PM
 */

namespace sonrac\WAMP;

use Illuminate\Support\ServiceProvider;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;
use Thruway\Logging\Logger;
use Thruway\Transport\RawSocketClientTransportProvider;

/**
 * Class WAMPServiceProvider.
 */
class WAMPServiceProvider extends ServiceProvider
{
    /**
     * Register WAMP.
     */
    public function register()
    {
        $config = require __DIR__.'/../config/wamp.php';
        $file = base_path('config/wamp.php');
        if (class_exists('\Laravel\Lumen\Application')) {
            // Configure wamp config for lumen
            app()->configure('wamp');
            $config = config('wamp') ?? $config;
        } else {
            if (file_exists($file)) {
                // Get laravel config for WAMP
                $config = require $file;
            }
        }

        /*
         * Register facade alias
         */
        $this->app->alias('wamp', '\sonrac\WAMP\Facades\WAMP');

        /*
         * Register console command
         */
        $this->app->singleton('wamp.run', '\sonrac\WAMP\Commands\RunServer');

        $this->app->singleton('wampClient', function () use ($config) {
            return new Client($config['realm']);
        });

        /*
         * Register routers
         */
        foreach ([
                     'rpcRouter' => [
                         'sonrac\WAMP\Contracts\RPCRouterInterface',
                         'sonrac\WAMP\Routers\RPCRouter',
                     ],
                     'pubSubRouter' => [
                         'sonrac\WAMP\Contracts\PubSubRouterInterface',
                         'sonrac\WAMP\Routers\PubSubRouter',
                     ],
                     'wampRouter' => [
                         'sonrac\WAMP\Contracts\WAMPRouterInterface',
                         'sonrac\WAMP\Routers\Router',
                     ],
                 ] as $alias => $abstract) {
            $this->app->singleton($abstract[0], $abstract[1]);
            $this->app->alias($abstract[0], $alias);
        }

        $this->app->singleton('sonrac\WAMP\Contracts\ClientTransportServiceProvider', function () use ($config) {
            return new RawSocketClientTransportProvider($config['host'], $config['port']);
        });

        /*
         * Set logging
         */
        if (isset($config['pathLogFile']) && null !== $config['pathLogFile']) {
            $handler = (new StreamHandler($config['pathLogFile'], MonologLogger::DEBUG))
                ->setFormatter(new LineFormatter(null, null, true, true));

            $logger = new MonologLogger('wamp-server', [$handler]);

            Logger::set($logger);
        }
    }
}
