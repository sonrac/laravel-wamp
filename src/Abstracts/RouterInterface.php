<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/24/17
 * Time: 11:14 AM
 */

namespace sonrac\WAMP\Abstracts;

/**
 * Interface RouterInterface
 * RouterInterface interface
 *
 * @package sonrac\WAMP
 */
interface RouterInterface
{
    /**
     * Dispatch route
     */
    public function dispatch();
}
