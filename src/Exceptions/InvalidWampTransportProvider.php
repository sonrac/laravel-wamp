<?php
/**
 * Created by PhpStorm.
 *
 * @author Donii Sergii <doniysa@gmail.com>
 * Date: 10/24/17
 * Time: 2:51 PM
 */

namespace sonrac\WAMP\Exceptions;

use Exception;

class InvalidWampTransportProvider extends Exception
{
    /**
     * {@inheritdoc}
     */
    protected $message = 'Invalid transport service provider';

    /**
     * {@inheritdoc}
     */
    protected $code = 12000;
}
