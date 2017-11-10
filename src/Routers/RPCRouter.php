<?php
/**
 * Created by PhpStorm.
 *
 * @author Donii Sergii <doniysa@gmail.com>
 * Date: 10/24/17
 * Time: 10:25 AM
 */

namespace sonrac\WAMP\Routers;

use sonrac\WAMP\Contracts\RPCRouterInterface;

/**
 * Class RPCRouterInterface
 * WAMP RPC router.
 */
class RPCRouter implements RPCRouterInterface
{
    use RouterTrait;

    /**
     * Add new procedure.
     *
     * @param string          $path
     * @param string|\Closure $callback
     *
     * @return \React\Promise\Promise
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function addRoute($path, $callback)
    {
        $data = $this->prepareCallback($callback);
        return $this->getClientSession()->register($data['prefix'].$path, $data['callback']);
    }
}
