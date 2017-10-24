<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/24/17
 * Time: 11:13 AM
 */

namespace sonrac\WAMP\Abstracts;

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
     * @param RouterInterface $router Router
     * @param \Closure        $next   Next route
     */
    public function handle(RouterInterface $router, \Closure $next);
}
