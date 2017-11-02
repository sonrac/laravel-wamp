<?php
/**
 * Created by PhpStorm.
 * @author Donii Sergii <doniysa@gmail.com>
 * Date: 10/25/17
 * Time: 11:57 AM
 */

namespace sonrac\WAMP\Routers;

use Thruway\Peer\RouterInterface;

/**
 * Trait RouterTrait
 * Base router trait
 *
 * @package sonrac\WAMP\Routers
 */
trait RouterTrait
{
    /**
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
            'callback'   => $runner
        ];
    }

    /**
     * Set router
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function setRouter(RouterInterface $router) {
        $this->router = $router;
    }

}
