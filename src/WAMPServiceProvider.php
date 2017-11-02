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
use Thruway\Logging\Logger;
use Monolog\Logger as MonologLogger;

/**
 * Class WAMPServiceProvider
 *
 * @package sonrac\WAMP
 */
class WAMPServiceProvider extends ServiceProvider
{
    /**
     * Register WAMP
     */
    public function register()
    {
        $config = require __DIR__ . '/../config/wamp.php';
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

        /**
         * Register facade alias
         */
        $this->app->alias('WAMP', '\sonrac\WAMP\Facades\WAMP');
        /**
         * Register main
         */
        $this->app->singleton('sonrac.wamp', '\sonrac\WAMP\WAMP');
        /**
         * Register console command
         */
        $this->app->singleton('sonrac.wamp.run', '\sonrac\WAMP\Commands\RunServer');

        /**
         * Register routers
         */
        foreach ([
                     'rpcRouter'    => [
                         'sonrac\WAMP\Contracts\RPCRouterInterface',
                         'sonrac\WAMP\Routers\RPCRouter',
                     ],
                     'pubSubRouter' => [
                         'sonrac\WAMP\Contracts\PubSubRouterInterface',
                         'sonrac\WAMP\Routers\PubSubRouter',
                     ],
                     'wampRouter'   => [
                         'sonrac\WAMP\Contracts\WAMPRouterInterface',
                         'sonrac\WAMP\Routers\Router',
                     ],
                 ] as $alias => $abstract) {

            $this->app->bind($abstract[0], $abstract[1]);
            $this->app->alias($abstract[0], $alias);
        }

        /**
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
