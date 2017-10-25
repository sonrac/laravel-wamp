<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/24/17
 * Time: 11:15 AM
 */

namespace sonrac\WAMP\Contracts;

use sonrac\WAMP\Contracts\WAMPRouterInterface;

/**
 * Interface RPCRouterInterface
 * RCP router implements
 *
 * @package sonrac\WAMP\Contracts
 */
interface RPCRouterInterface extends WAMPRouterInterface
{
    /**
     * @param array   $config
     * @param string| $runner
     *
     * @return mixed
     */
    public function group(array $config, $runner);
}
