<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/23/17
 * Time: 3:41 PM
 */

namespace sonrac\WAMP;


use Illuminate\Support\ServiceProvider;

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
        app()->configure('minion');
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
                         'sonrac\WAMP\Contracts\RpcRouterInterface',
                         'sonrac\WAMP\Routers\RPCRouter'
                     ],
                     'pubSubRouter' => [
                         'sonrac\WAMP\Contracts\PubSubRouterInterface',
                         'sonrac\WAMP\Routers\PubSubRouter'
                     ]
                 ] as $alias => $abstract) {

            $this->app->singleton($abstract[0], $abstract[1]);
            $this->app->singleton($alias, function () use ($abstract) {
                return app()->make($abstract[0]);
            });
        }

    }
}
