<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/24/17
 * Time: 10:25 AM
 */

namespace sonrac\WAMP\Routers;

use sonrac\WAMP\Contracts\RPCRouterInterface;

/**
 * Class RPCRouterInterface
 * WAMP RPC router
 *
 * @package sonrac\WAMP
 */
class RPCRouter extends Router implements RPCRouterInterface
{
    /**
     * @inheritDoc
     */
    public function dispatch()
    {
    }

}
