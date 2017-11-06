<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace tests\wamp\controllers\WampTestController;

use sonrac\WAMP\Abstracts\WAMPControllerInterface;
use sonrac\WAMP\Client;
use Thruway\ClientSession;

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
     * @param \Thruway\Session $session
     *
     * @return array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function testMessage(ClientSession $session, Client $client) {
        return [
            'message' => 'message'
        ];
    }
}