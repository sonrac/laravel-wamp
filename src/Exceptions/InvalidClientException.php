<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/24/17
 * Time: 2:59 PM
 */

namespace sonrac\WAMP\Exceptions;

use \Exception;

class InvalidClientException extends Exception
{
    /**
     * {@inheritdoc}
     */
    protected $message = 'Invalid WAMP client';

    /**
     * {@inheritdoc}
     */
    protected $code = 12001;
}
