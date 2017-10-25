<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/24/17
 * Time: 11:15 AM
 */

namespace sonrac\WAMP\Contracts;

/**
 * Interface RPCRouterInterface
 * RCP router implements
 *
 * @package sonrac\WAMP\Contracts
 */
interface PubSubRouterInterface extends WAMPRouterInterface
{
    /**
     * @param array    $config Route config
     * @param \Closure $runner Callback
     *
     * @return mixed
     */
    public function group(array $config, \Closure $runner);
}
