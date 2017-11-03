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
use Thruway\Peer\ClientInterface;
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

    /**
     * Connection open event name
     *
     * @type string
     * @const
     */
    const EVENT_CONNECTION_OPEN = 'connection_open';

    /**
     * Connection close event name
     *
     * @type string
     * @const
     */
    const EVENT_CONNECTION_CLOSE = 'connection_close';

    /**
     * Router start event name
     *
     * @type string
     * @const
     */
    const EVENT_ROUTER_START = 'router.start';

    /**
     * Router stop event name
     *
     * @type string
     * @const
     */
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
     * Peer client
     *
     * @var \Thruway\Peer\ClientInterface|\sonrac\WAMP\Client
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $client = null;

    /**
     * Events
     *
     * @var array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected static $events = [
        self::EVENT_CONNECTION_OPEN  => [['handleConnectionOpen', 10]],
        self::EVENT_CONNECTION_CLOSE => [['handleConnectionClose', 10]],
        self::EVENT_ROUTER_START     => [['handleRouterStart', 10]],
        self::EVENT_ROUTER_STOP      => [['handleRouterStop', 10]],
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
     * Register all events, subscribers, publisher & procedures
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function register() {

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
        $this->getClient()->getSession()->subscribe($path, $callback);
    }

    /**
     * Add procedure
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function addRoute($name, $procedure) {
        $this->getClient()->getSession()->register($name, $procedure);
    }

    /**
     * Add open event listener
     *
     * @param \Closure|string $callback Callback
     * @param int             $priority Callback priority
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function onConnectionOpen($callback, $priority = 0)
    {
        $this->addEvent($callback, self::EVENT_CONNECTION_OPEN, $priority);
    }

    /**
     * Add stop router event listener
     *
     * @param \Closure|string $callback Callback
     * @param int             $priority Callback priority
     *
     * @throws \Exception
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function onRouterStop($callback, $priority = 0)
    {
        $this->addEvent($callback, self::EVENT_ROUTER_STOP, $priority);
    }

    /**
     * Add connection close event listener
     *
     * @param \Closure|string $callback Callback
     * @param int             $priority Callback priority
     *
     * @throws \Exception
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function onConnectionClose($callback, $priority = 0)
    {
        $this->addEvent($callback, self::EVENT_CONNECTION_CLOSE, $priority);
    }

    /**
     * Handle start router
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public static function handleRouterStart()
    {

    }

    /**
     * Handle start router
     */
    public static function handleRouterStop()
    {

    }

    /**
     * Add open event listener
     *
     * @param \Closure|string $callback Callback
     * @param int             $priority Callback priority
     *
     * @throws \Exception
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function onRouterStart($callback, $priority = 0)
    {
        $this->addEvent($callback, self::EVENT_ROUTER_START, $priority);
    }

    /**
     * Add event
     *
     * @param \Closure|string $callback  Callback
     * @param string          $eventName Event name
     * @param int             $priority  Priority
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function addEvent($callback, $eventName, $priority)
    {
        static::checkEventKeyExistsOrCreate($eventName);

        if (is_string($callback)) {
            list($class, $method) = explode('&', $callback);

            $callback = function (ConnectionOpenEvent $event) use ($class, $method) {
                return $class::{$method}($event);
            };
        }

        $this->getEventDispatcher()->addListener($eventName, $callback, $priority);
    }

    /**
     * Set client
     *
     * @param \Thruway\Peer\ClientInterface $client Client
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function setClient(ClientInterface $client) {
        $this->client = $client;
        $this->client->start();
    }

    /**
     * Get client
     *
     * @return \Thruway\Peer\ClientInterface|\sonrac\WAMP\Client
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function getClient() {
        return $this->client;
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
