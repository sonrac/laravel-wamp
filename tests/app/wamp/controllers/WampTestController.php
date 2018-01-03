<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\WAMP\tests\app\wamp\controllers;

use sonrac\WAMP\Abstracts\WAMPControllerInterface;

/**
 * Class WampTestController
 *
 * @package tests\wamp\controllers\WampTestController
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class WampTestController implements WAMPControllerInterface
{
    /**
     * Send test message
     *
     * @return array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function testMessage()
    {
        return [
            'message' => 'message',
        ];
    }
}
