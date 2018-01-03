<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\WAMP\tests\app;


/**
 * Class WAMPController
 *
 * @package sonrac\WAMP\tests\app
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class WAMPController
{

    /**
     * Index action
     *
     * @return array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function getUserInfo() {
        return [
            'test' => 'test'
        ];
    }
}