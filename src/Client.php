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
    /**
     * Path to WAMP routes
     *
     * @var string|null
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $routePath = null;

    /**
     * Retry connection on close or no
     *
     * @var bool
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $connectionRetry = true;

    /**
     * Realm
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $realm;

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
        var_dump(231);
        $this->includeRoutes($session, $transport);
    }

    /**
     * {@inheritdoc}
     */
    public function start($startLoop = true)
    {
        parent::start($startLoop);
    }

    /**
     * {@inheritdoc}
     */
    public function onClose($reason, $retry = true)
    {
        $this->connectionRetry = $retry;

        parent::onClose($reason);
    }

    /**
     * {@inheritdoc}
     */
    public function retryConnection()
    {
        if (!$this->connectionRetry) {
            return;
        }

        return parent::retryConnection();
    }

    public function setRoutePath($path)
    {
        $this->routePath = $path;
    }

    /**
     * Set attribute connectionRetry
     *
     * @return bool
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function isConnectionRetry(): bool
    {
        return $this->connectionRetry;
    }

    /**
     * Set connection retry
     *
     * @param bool $connectionRetry
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function setConnectionRetry(bool $connectionRetry)
    {
        $this->connectionRetry = $connectionRetry;
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

        /* @scrutinizer ignore-call */
        app()->wampRouter->setClient($client);

        if (is_file($this->routePath)) {
            require $this->routePath;
            app()->wampRouter->parseGroups();
            return;
        }

        if (is_dir($this->routePath)) {
            $files = scandir($this->routePath);

            foreach ($files as $file) {
                if ($file === '.' || $file === '..') {
                    continue;
                }

                if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                    require $this->routePath.DIRECTORY_SEPARATOR.$file;
                }
            }
        }
        app()->wampRouter->parseGroups();
    }
}
