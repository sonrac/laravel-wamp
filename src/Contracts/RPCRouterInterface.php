<?php
/**
 * Created by PhpStorm.
 *
 * @author Donii Sergii <doniysa@gmail.com>
 * Date: 10/24/17
 * Time: 11:15 AM
 */

namespace sonrac\WAMP\Contracts;

/**
 * Interface RPCRouterInterface
 * RCP router implements.
 */
interface RPCRouterInterface extends WAMPRouterInterface
{
    /**
     * @param array   $config
     * @param string| $runner
     *
     * @return mixed
     */
    public function group(array $config, \Closure $runner);
}
