<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/24/17
 * Time: 11:14 AM
 */

namespace sonrac\WAMP\Contracts;

use Thruway\Peer\RouterInterface as BaseWAMPRouterInterface;

/**
 * Interface RouterInterface
 * RouterInterface interface
 *
 * @package sonrac\WAMP
 */
interface WAMPRouterInterface extends BaseWAMPRouterInterface
{
    /**
     * Dispatch route
     */
    public function dispatch();
}
