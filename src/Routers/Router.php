<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/25/17
 * Time: 11:56 AM
 */

namespace sonrac\WAMP\Routers;

use sonrac\WAMP\Contracts\WAMPRouterInterface;

/**
 * Class Router
 *
 * @package sonrac\WAMP\Routers
 */
class Router extends BaseRouter implements WAMPRouterInterface
{
    /**
     * RPC router
     *
     * @var \sonrac\WAMP\Contracts\RPCRouterInterface
     */
    protected $rpcRouter;

    /**
     * Publisher/subscription router
     *
     * @var \sonrac\WAMP\Contracts\PubSubRouterInterface
     */
    protected $pubSubRouter;

    /**
     * @inheritDoc
     */
    public function __construct(
        \sonrac\WAMP\Contracts\RPCRouterInterface $RPCRouter,
        \sonrac\WAMP\Contracts\PubSubRouterInterface $pubSubRouter
    ) {
        $this->rpcRouter = $RPCRouter;
        $this->pubSubRouter = $pubSubRouter;
    }

    /**
     * @inheritDoc
     */
    public function dispatch()
    {
        // TODO: Implement dispatch() method.
    }

}
