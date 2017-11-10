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
     * Add subscriber.
     *
     * @param string          $path     Route path
     * @param \Closure|string $callback Callback
     *
     * @return \React\Promise\Promise
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function addRoute($path, $callback)
    {
        $data = $this->prepareCallback($callback);

        return $this->getClientSession()->subscribe($data['prefix'].$path, $data['callback']);
    }
}
