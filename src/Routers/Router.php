<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/24/17
 * Time: 12:06 PM
 */

namespace sonrac\WAMP\Routers;

/**
 * Class Router
 * Base router
 *
 * @package sonrac\WAMP\Routers
 */
abstract class Router
{
    /**
     * @var null|\sonrac\WAMP\GroupsConfig[]
     */
    protected $groups = null;

    /**
     * @inheritDoc
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
}
