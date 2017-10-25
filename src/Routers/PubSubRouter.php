<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/24/17
 * Time: 11:05 AM
 */

namespace sonrac\WAMP\Routers;

use sonrac\WAMP\Contracts\PubSubRouterInterface;
use Thruway\Peer\Router as PeerRouter;

/**
 * Class PubSubRouter
 * Publisher/subscribers router
 *
 * @package sonrac\WAMP
 */
class PubSubRouter extends PeerRouter implements PubSubRouterInterface
{
    use RouterTrait;

    /**
     * @inheritDoc
     */
    public function dispatch()
    {

    }

}
