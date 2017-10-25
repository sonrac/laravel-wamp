<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/24/17
 * Time: 11:08 AM
 */

namespace sonrac\WAMP;

use sonrac\WAMP\Exceptions\InvalidWampTransportProvider;
use Thruway\Transport\TransportProviderInterface;

/**
 * Class WAMP
 *
 * @package sonrac\WAMP
 */
class WAMP
{
    /**
     * WAMP host
     *
     * @var string
     */
    protected $host;

    /**
     * WAMP realm
     *
     * @var string
     */
    protected $realm;

    /**
     * WAMP port
     *
     * @var string
     */
    protected $port;

    /**
     * WAMP path
     *
     * @var int|string
     */
    protected $path;

    /**
     * Debug mode is enabled
     *
     * @var bool
     */
    protected $debug = false;

    /**
     * In background run mode is enable
     *
     * @var bool
     */
    protected $inBackground = false;

    /**
     * Use WAMP security connection
     *
     * @var bool
     */
    protected $tls = false;

    /**
     * @var \Thruway\Transport\TransportInterface
     */
    protected $transportProvider = 'Thruway\Transport\RatchetTransportProvider';

    /**
     * WAMP constructor.
     *
     * @param string                                $host              WAMP host
     * @param string|int                            $port              WAMP port
     * @param string                                $path              WAMP path
     * @param string                                $realm             WAMP realm
     * @param bool                                  $tls               Wamp security enable
     * @param bool                                  $debug             WAMP debug is enabled
     * @param bool                                  $inBackground      WAMP in background mode.
     * @param \Thruway\Transport\TransportInterface $transportProvider Transport provider class
     *
     * @thrown InvalidWampTransportProvider
     */
    public function __construct(
        $host = null,
        $port = null,
        $path = null,
        $realm = null,
        $tls = false,
        $debug = false,
        $inBackground = false,
        $transportProvider = null
    ) {
        $this->host = $host ?? $this->getConfig('host');
        $this->port = $port ?? $this->getConfig('port');
        $this->realm = $realm ?? $this->getConfig('realm');
        $this->tls = $tls ?? $this->getConfig('tls');
        $this->debug = $debug ?? $this->getConfig('debug');
        $this->inBackground = $inBackground ?? $this->getConfig('inBackground');
        $this->path = $path ?? $this->getConfig('path');
        $this->transportProvider = $transportProvider ?? $this->getConfig('transportProvider');

        if (!class_exists($this->transportProvider) ||
            !((new \ReflectionClass($this->transportProvider))->implementsInterface(
                '\Thruway\Transport\TransportInterface'
            ))
        ) {
            throw new InvalidWampTransportProvider();
        }
    }

    /**
     * Get value from config
     *
     * @param string      $name     Option name
     * @param null|string $propName Property name
     *
     * @return mixed
     */
    protected function getConfig($name, $propName = null)
    {
        $propName = $propName ?? $name;
        $options = config('wamp');

        if (null === $options) {
            return $this->{$propName};
        }

        if (isset($options[$name])) {
            return $options[$name];
        }

        return $this->{$propName};
    }

    /**
     * Get transport provider
     *
     * @return \Thruway\Transport\TransportProviderInterface
     */
    protected function getTransportProvider(): TransportProviderInterface
    {
        return new $this->transportProvider();
    }
}
