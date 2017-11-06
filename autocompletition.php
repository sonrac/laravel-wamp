<?php

/**
 * Autocompletition for lumen/laravel applicaton with wamp.
 */

namespace Laravel\Lumen {

    /**
     * Class Application
     * Lumen application.
     *
     * @property \sonrac\WAMP\Contracts\RPCRouterInterface|\sonrac\WAMP\Routers\RPCRouter       $rpcRouter
     * @property \sonrac\WAMP\Contracts\PubSubRouterInterface|\sonrac\WAMP\Routers\PubSubRouter $pubSubRouter
     * @property \sonrac\WAMP\Contracts\WAMPRouterInterface|\sonrac\WAMP\Routers\Router         $wampRouter
     *           WAMP complex router
     * @property \sonrac\WAMP\Client                                                            $wampClient
     *           Wamp client
     */
    class Application extends \Illuminate\Container\Container
    {
    }
}

namespace Illuminate\Foundation {

    /**
     * Class Application
     * Laravel Application.
     *
     * @property \sonrac\WAMP\Contracts\RPCRouterInterface|\sonrac\WAMP\Contracts\RPCRouterInterface $rpcRouter
     * @property \sonrac\WAMP\Contracts\PubSubRouterInterface|\sonrac\WAMP\Routers\PubSubRouter      $pubSubRouter
     * @property \sonrac\WAMP\WAMP                                                                   $wamp       WAMP
     *           main extractor
     * @property \sonrac\WAMP\Contracts\WAMPRouterInterface|\sonrac\WAMP\Routers\Router              $wampRouter WAMP
     *           complex router
     */
    class Application extends \Illuminate\Container\Container
    {
    }
}

namespace sonrac\WAMP {

    use Thruway\ClientSession;

    /**
     * Interface GroupsConfigInterface.
     *
     * @property array  $middleware Middleware list
     * @property string $prefix     Route prefix
     * @property string $namespace  Controllers namespace
     * @method void|\sonrac\WAMP\GroupsConfigInterface callback(ClientSession $clientSession, Client $client) Groups
     *         runner
     */
    interface GroupsConfigInterface
    {
    }
}
