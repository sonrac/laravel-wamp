<?php
/**
 * Created by PhpStorm.
 *
 * @author Donii Sergii <doniysa@gmail.com>
 * Date: 10/25/17
 * Time: 11:57 AM
 */

namespace sonrac\WAMP\Routers;

use Thruway\ClientSession;
use Thruway\Peer\RouterInterface;

/**
 * Trait RouterTrait.
 * Base router trait.
 */
trait RouterTrait
{
    /**
     * Router groups.
     *
     * @var null|\sonrac\WAMP\GroupsConfigInterface[]
     */
    protected $groups = null;

    /**
     * Main router
     *
     * @var null|\Thruway\Peer\RouterInterface|\sonrac\WAMP\Routers\Router
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $router = null;

    /**
     * Group routes
     *
     * @param array    $config Group config
     * @param \Closure $runner Closure runner group
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function group(array $config, \Closure $runner)
    {
        $middleware = isset($config['middleware']) ? explode('|', $config['middleware']) : [];
        $namespace = isset($config['namespace']) ? $config['namespace'] : 'App\Controllers\WAMP';

        $this->groups[] = (object)[
            'middleware' => $middleware,
            'namespace'  => $namespace,
            'prefix'     => isset($config['prefix']) ? $config['prefix'] : '',
            'callback'   => $runner,
        ];
    }

    /**
     * Get route groups
     *
     * @return null|\sonrac\WAMP\GroupsConfigInterface[]
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function getGroups() {
        return $this->groups;
    }

    /**
     * Get router
     *
     * @return mixed|null|\sonrac\WAMP\Contracts\WAMPRouterInterface|\sonrac\WAMP\Routers\Router|\Thruway\Peer\RouterInterface
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function getRouter()
    {
        return $this->router ?? $this->router = app()->wampRouter;
    }

    /**
     * Set router.
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Get client session.
     *
     * @return \Thruway\ClientSession
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function getClientSession()
    {
        return $this->getRouter()->getClient()->getSession();
    }

    /**
     * Get client.
     *
     * @return \sonrac\WAMP\Client|\Thruway\Peer\ClientInterface
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function getClient()
    {
        return $this->getRouter()->getClient();
    }

    /**
     * Parse callback function
     *
     * @param string|\Closure $callback  Callback
     * @param null            $namespace Controller namespace
     *
     * @return \Closure
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function parseCallback($callback, $namespace = null)
    {
        if ($callback instanceof \Closure) {
            return $callback;
        }

        $namespace = $namespace ? $namespace . '\\' : '';

        $callback = explode('&', $callback);
        $self = $this;
        return function (ClientSession $clientSession) use ($callback, $namespace, $self) {
            if (count($callback) === 1) {
                return $this->{$callback[0]}($clientSession, $self->getClient());
            }

            $class = app()->make($namespace . $callback[0]);

            return $class->{$callback[1]}($clientSession, $self->getClient());
        };
    }
}
