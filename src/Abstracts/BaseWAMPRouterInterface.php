<?php
/**
 * Created by PhpStorm.
 *
 * @author Donii Sergii <doniysa@gmail.com>
 * Date: 10/25/17
 * Time: 2:15 PM
 */

namespace sonrac\WAMP\Abstracts;

/**
 * Interface BaseWAMPRouterInterface
 * Base WAMP router implements.
 */
interface BaseWAMPRouterInterface
{
    /**
     * @param array    $config Route config
     * @param \Closure $runner Callback
     *
     * @return mixed
     */
    public function group(array $config, \Closure $runner);
}
