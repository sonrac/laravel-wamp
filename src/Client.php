<?php
/**
 * Created by PhpStorm.
 *
 * @author Donii Sergii <doniysa@gmail.com>
 * Date: 10/25/17
 * Time: 12:18 PM
 */

namespace sonrac\WAMP;

use Thruway\Peer\Client as PeerClient;

/**
 * Class Client
 * Client class.
 *
 * @author Donii Sergii <doniysa@gmail.com>
 */
class Client extends PeerClient
{
    protected $routePath = null;

    protected $session;

    /**
     * Session start event
     *
     * @param \Thruway\ClientSession                $session
     * @param \Thruway\Transport\TransportInterface $transport
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function onSessionStart($session, $transport)
    {
        $this->includeRoutes($session, $transport);
    }

    public function setRoutePath($path)
    {
        $this->routePath = $path;
    }

    /**
     * Include routes
     *
     * @param \Thruway\ClientSession                $session   Client session
     * @param \Thruway\Transport\TransportInterface $transport Transport provider
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function includeRoutes($session, $transport)
    {
        if (!is_dir($this->routePath) && !is_file($this->routePath)) {
            return;
        }

        $session = $this->session = $session;
        $client = $this;

        /** @scrutinizer ignore-call */
        app()->wampRouter->setClient($client);

        if (is_file($this->routePath)) {
            require $this->routePath;
            return;
        }

        if (is_dir($this->routePath)) {
            $files = scandir($this->routePath);

            foreach ($files as $file) {
                if ($file === '.' || $file === '..') {
                    continue;
                }

                if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                    require $this->routePath . DIRECTORY_SEPARATOR . $file;
                }
            }
        }
    }
}
