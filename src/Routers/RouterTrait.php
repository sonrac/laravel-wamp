<?php
/**
 * Created by PhpStorm.
 *
 * @author Donii Sergii <doniysa@gmail.com>
 * Date: 10/25/17
 * Time: 11:57 AM
 */

namespace sonrac\WAMP\Routers;

use Thruway\Peer\RouterInterface;

/**
 * Trait RouterTrait.
 * Base router trait.
 */
trait RouterTrait
{
    /**
     * Controllers list
     *
     * @var \sonrac\WAMP\Abstracts\WAMPControllerInterface[]
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $controllers;

    /**
     * Main router
     *
     * @var null|\Thruway\Peer\RouterInterface|\sonrac\WAMP\Routers\Router
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $router = null;

    /**
     * Route path prefix.
     *
     * @var string|null
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    private $prefix = null;

    /**
     * Controller namespace.
     *
     * @var string|null
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    private $groupControllerNamespace = null;

    /**
     * Middleware list.
     *
     * @var null|array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    private $middleware = null;

    /**
     * Group routes.
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

        $this->groups[] = [
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
    public function getGroups()
    {
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
    public function parseCallback($callback, $namespace = null)
    {
        if ($callback instanceof \Closure) {
            return $callback;
        }

        $namespace = $namespace ? $namespace.'\\' : '';

        $callback = explode('@', $callback);

        return function () use ($callback, $namespace) {
            if (count($callback) === 1) {
                return app()->call([$this, $callback[0]], func_get_args());
            }

            if (isset($this->controllers[$callback[0]])) {
                return call_user_func_array([$this->controllers[$callback[0]], $callback[1]], func_get_args());
            }

            $namespace = rtrim($namespace, '\\');

            $className = class_exists($callback[0]) ? $callback[0] : $namespace.'\\'.$callback[0];

            $this->controllers[$callback[0]] = app()->make($className);

            return app()->call([$this->controllers[$callback[0]], $callback[1]], func_get_args());
        };
    }

    /**
     * get controller namespace for group
     *
     * @return null|string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function getGroupControllerNamespace()
    {
        return $this->groupControllerNamespace;
    }

    /**
     * {@inheritdoc}
     */
    public function parseGroups()
    {
        if (!is_array($this->groups) || !count($this->groups)) {
            return;
        }
        gc_enable();
        $callbacks = [];
        foreach ($this->groups as $group) {
            $this->prefix = $group['prefix'];
            $this->groupControllerNamespace = $group['namespace'];
            $this->middleware = $group['middleware'];
            $callbacks[] = $group['callback']($this->getClientSession(), $this->getClient());
        }

        $this->groups = null;
        unset($this->groups);
        $this->groups = [];

        $this->prefix = null;
        $this->groupControllerNamespace = null;

        gc_collect_cycles();
        gc_disable();

        return $callbacks;
    }

    /**
     * Prepare path.
     *
     * @param \Closure|string $callback Callback
     *
     * @return array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function prepareCallback($callback)
    {
        $namespace = $this->groupControllerNamespace ?? $this->getRouter()->getGroupControllerNamespace();
        $namespace = $namespace ?? $this->getRouter()->getControllerNamespace();

        return [
            'prefix'     => $this->prefix,
            'namespace'  => $namespace,
            'callback'   => $this->parseCallback($callback, $namespace),
            'middleware' => $this->middleware,
        ];
    }
}
