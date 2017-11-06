<?php
/**
 * Created by PhpStorm.
 *
 * @author Donii Sergii <doniysa@gmail.com>
 * Date: 10/24/17
 * Time: 11:05 AM
 */

namespace sonrac\WAMP\Routers;

use sonrac\WAMP\Contracts\PubSubRouterInterface;

/**
 * Class PubSubRouter
 * Publisher/subscribers router.
 */
class PubSubRouter implements PubSubRouterInterface
{
    use RouterTrait;

    /**
     * @param string          $path      Route path
     * @param \Closure|string $callback  Callback
     * @param string          $eventName Event name in dispatcher
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function addRoute($path, $callback, $eventName)
    {
    }
}
