<?php
/**
 * Created by PhpStorm.
 *
 * @author Donii Sergii <doniysa@gmail.com>
 * Date: 10/24/17
 * Time: 11:13 AM
 */

namespace sonrac\WAMP\Abstracts;

use sonrac\WAMP\Contracts\WAMPRouterInterface;

/**
 * Interface WAMPMiddlewareInterface
 * WAMP middleware implements
 *
 * @package sonrac\WAMP
 */
interface WAMPMiddlewareInterface
{
    /**
     * Handle middleware
     *
     * @param \sonrac\WAMP\Contracts\WAMPRouterInterface $router Router
     * @param \Closure                                   $next   Next route
     */
    public function handle(WAMPRouterInterface $router, \Closure $next);
}
