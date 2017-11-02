<?php
/**
 * Created by PhpStorm.
 *
 * @author Donii Sergii <doniysa@gmail.com>
 * Date: 10/25/17
 * Time: 11:56 AM
 */

namespace sonrac\WAMP\Routers;

use sonrac\WAMP\Contracts\WAMPRouterInterface;
use Thruway\Event\ConnectionOpenEvent;
use Thruway\Peer\Router as PeerRouter;

/**
 * Class Router
 * Router class
 *
 * <h2>Events list</h2>
 * <table class="table table-bordered table-stripped table-hover table-responsive">
 * <thead>
 * <tr>
 * <td>Event name</td>
 * <td>Constant name</td>
 * <td>Description</td>
 * <td>Method for subscribe (is static for class <i>sonrac\WAMP\Routers\Router</i>)</td>
 * </tr>
 * </thead>
 * <tbody>
 * <tr>
 * <td>connection_open</td>
 * <td><i>sonrac\WAMP\Routers\Router::EVENT_CONNECTION_OPEN</i></td>
 * <td>Connection opened</td>
 * <td><i>sonrac\WAMP\Routers\Router::onOpen</i></td>
 * </tr>
 * </tbody>
 * </table>
 *
 * <h2>Example events adding</h2>
 *
 * <code>
 * $app->router->onOpen()
 * </code>
 *
 * @package sonrac\WAMP\Routers
 */
class Router extends PeerRouter implements WAMPRouterInterface
{
    use RouterTrait;

    const EVENT_CONNECTION_OPEN = 'connection_open';
    const EVENT_CONNECTION_CLOSE = 'connection_close';
    const EVENT_ROUTER_START = 'router.start';
    const EVENT_ROUTER_STOP = 'router.stop';

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
     * Loop object
     *
     * @var null|\React\EventLoop\LoopInterface
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $loop;
    /**
     * Routes
     *
     * @var array
     */
    protected $routes = [];

    /**
     * Events
     *
     * @var array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected static $events = [
        self::EVENT_CONNECTION_OPEN  => ['', 10],
        self::EVENT_CONNECTION_CLOSE => ['', 10],
        self::EVENT_ROUTER_START     => ['', 10],
        self::EVENT_ROUTER_STOP      => ['', 10],
    ];

    /**
     * Router constructor.
     *
     * @param \sonrac\WAMP\Contracts\RPCRouterInterface    $RPCRouter    RPC router
     * @param \sonrac\WAMP\Contracts\PubSubRouterInterface $pubSubRouter Publisher/subscription router
     * @param \React\EventLoop\LoopInterface|null          $loop         Loop object
     */
    public function __construct(
        \sonrac\WAMP\Contracts\RPCRouterInterface $RPCRouter,
        \sonrac\WAMP\Contracts\PubSubRouterInterface $pubSubRouter,
        \React\EventLoop\LoopInterface $loop = null
    ) {
        $this->rpcRouter = $RPCRouter;
        $this->pubSubRouter = $pubSubRouter;
        $this->loop = $loop;

        parent::__construct($loop);
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return static::$events;
    }

    /**
     * {@inheritDoc}
     */
    public function dispatch()
    {
    }

    /**
     * Add route to RPC router
     *
     * @param string          $path     Route path
     * @param \Closure|string $callback Handler
     */
    public function addRPCRoute($path, $callback)
    {
        $this->routes[$path] = $callback;
    }

    /**
     * Add open event listener
     *
     * @param \Closure|string $callback
     *
     * @throws \Exception
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public static function onOpen($callback)
    {
        static::checkEventKeyExistsOrCreate(self::EVENT_CONNECTION_OPEN);

        if (is_string($callback)) {
            list($class, $method) = explode('&', $callback);

            $callback = function (ConnectionOpenEvent $event) use ($class, $method) {
                $class = app()->make($class);

                return $class->{$method}($event);
            };
        }

        if (!($callback instanceof \Closure)) {
            throw new \Exception('Invalid callback');
        }

        static::$events[self::EVENT_CONNECTION_OPEN][] = [$callback, 10];
    }

    /**
     * Check event exists in array or exists
     *
     * @param string $key     Key
     * @param mixed  $default Default value
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    private static function checkEventKeyExistsOrCreate($key, $default = null)
    {
        if (!isset(static::$events[$key])) {
            static::$events[$key] = $default ? [$default] : [];
        }
    }
}
