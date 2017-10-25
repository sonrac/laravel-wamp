<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/25/17
 * Time: 11:56 AM
 */

namespace sonrac\WAMP\Routers;

use sonrac\WAMP\Contracts\WAMPRouterInterface;
use Thruway\Peer\Router as PeerRouter;
/**
 * Class Router
 *
 * @package sonrac\WAMP\Routers
 */
class Router extends PeerRouter implements WAMPRouterInterface
{
    use RouterTrait;

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

    protected $loop;
    /**
     * Routes
     *
     * @var array
     */
    protected $routes = [];

    /**
     * Router constructor.
     *
     * @param \sonrac\WAMP\Contracts\RPCRouterInterface    $RPCRouter
     * @param \sonrac\WAMP\Contracts\PubSubRouterInterface $pubSubRouter
     * @param \React\EventLoop\LoopInterface|null          $loop
     */
    public function __construct(
        \sonrac\WAMP\Contracts\RPCRouterInterface $RPCRouter,
        \sonrac\WAMP\Contracts\PubSubRouterInterface $pubSubRouter,
        \React\EventLoop\LoopInterface $loop = null
    ) {
        $this->rpcRouter = $RPCRouter;
        $this->pubSubRouter = $pubSubRouter;

        parent::__construct($loop);
    }

    /**
     * @inheritDoc
     */
    public function dispatch()
    {

    }

    /**
     * @param string          $path     Route path
     * @param \Closure|string $callback Handler
     */
    public function addRoute($path, $callback)
    {
        $this->routes[$path] = $callback;
    }

}
