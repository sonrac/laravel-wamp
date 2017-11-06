<?php
/**
 * Created by PhpStorm.
 *
 * @author Donii Sergii <doniysa@gmail.com>
 * Date: 10/25/17
 * Time: 11:57 AM
 */

namespace sonrac\WAMP\Routers;

/**
 * Trait RouterTrait
 * Base router trait.
 */
trait RouterTrait
{
    /**
     * @var null|\sonrac\WAMP\GroupsConfigInterface[]
     */
    protected $groups = null;

    /**
     * {@inheritdoc}
     */
    public function group(array $config, \Closure $runner)
    {
        $middleware = isset($config['middleware']) ? explode('|', $config['middleware']) : [];
        $namespace = isset($config['namespace']) ? $config['namespace'] : 'App\Controllers\WAMP';

        $this->groups[] = (object) [
            'middleware' => $middleware,
            'namespace'  => $namespace,
            'prefix'     => isset($config['prefix']) ? $config['prefix'] : '',
            'callback'   => $runner,
        ];
    }
}
