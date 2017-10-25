<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/23/17
 * Time: 3:41 PM
 */

namespace sonrac\WAMP;


use Illuminate\Support\ServiceProvider;
use Thruway\Logging\Logger;

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
        // Configure wamp config for lumen
        if (class_exists('\Laravel\Lumen\Application')) {
            app()->configure('wamp');
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
                         'sonrac\WAMP\Routers\RPCRouter'
                     ],
                     'pubSubRouter' => [
                         'sonrac\WAMP\Contracts\PubSubRouterInterface',
                         'sonrac\WAMP\Routers\PubSubRouter'
                     ],
                     'wampRouter'   => [
                         'sonrac\WAMP\Contracts\WAMPRouterInterface',
                         'sonrac\WAMP\Routers\Router'
                     ]
                 ] as $alias => $abstract) {

            $this->app->bind($abstract[0], $abstract[1]);
            $this->app->alias($abstract[0], $alias);
        }

        /**
         * Set logging
         */
//        if (null !== ($log = config('wamp.log'))) {
//            Logger::set(app($log));
//        }
    }
}
