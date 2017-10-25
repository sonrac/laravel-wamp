<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/24/17
 * Time: 11:05 AM
 */

namespace sonrac\WAMP\Routers;

use sonrac\WAMP\Contracts\PubSubRouterInterface;

/**
 * Class PubSubRouter
 * Publisher/subscribers router
 *
 * @package sonrac\WAMP
 */
class PubSubRouter implements PubSubRouterInterface
{
    use RouterTrait;

    /**
     * @inheritDoc
     */
    public function dispatch()
    {

    }

}
