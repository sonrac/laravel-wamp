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
     * {@inheritdoc}
     */
    public function dispatch()
    {
    }
}
