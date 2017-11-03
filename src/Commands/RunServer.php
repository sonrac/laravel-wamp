<?php
/**
 * Created by PhpStorm.
 *
 * @author Donii Sergii <doniysa@gmail.com>
 * Date: 10/24/17
 * Time: 10:33 AM
 */

namespace sonrac\WAMP\Commands;

use Illuminate\Console\Command;
use sonrac\WAMP\Exceptions\InvalidWampTransportProvider;

/**
 * Class RunServer
 * Run WAMP server command
 *
 * @package sonrac\WAMP\Commands
 */
class RunServer extends Command
{
    use WAMPCommandTrait;

    /**
     * Transport provider class
     *
     * @var string|\Thruway\Transport\RatchetTransportProvider|null
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $transportProvider = 'Thruway\Transport\RatchetTransportProvider';

    protected $name = 'wamp:run-server {--realm=?} {--host=?} {--port=?} {--tls?} {--transportProvider}
    {--no-loop?} {--debug?}';
    protected $signature = 'run:wamp-server
                                {--realm= : Specify WAMP realm to be used}
                                {--host= : Specify the router host}
                                {--port= : Specify the router port}
                                {--tls : Specify the router protocol as wss}
                                {--no-debug : Disable debug mode.}
                                {--no-loop : Disable loop runner}
                                {--transportProvider : Transport provider class}
                                ';
    protected $description = 'Run wamp server';

    /**
     * Wamp server
     *
     * @var \Thruway\Peer\ClientInterface|\sonrac\WAMP\Client
     */
    protected $WAMPServer = null;

    /**
     * Run server handle
     *
     * @throws \Exception
     */
    public function handle()
    {
        $this->parseOptions();
        $this->changeWampLogger();

        $this->WAMPServer = app()->wampRouter;

        $this->WAMPServer->addTransportProvider($this->getTransportProvider());

        $this->WAMPServer->start(!$this->runOnce);
    }

    /**
     * Run server handle
     *
     * @throws \Exception
     */
    public function fire()
    {
        return $this->handle();
    }

    /**
     * Merge config & input options
     */
    protected function parseOptions()
    {
        $this->parseBaseOptions();
        $this->transportProvider = $this->getOptionFromInput('transportProvider') ?? $this->getConfig('transportProvider',
                $this->transportProvider);
    }

    /**
     * Get WAMP server transport provider
     *
     * @return null|string|\Thruway\Transport\RatchetTransportProvider
     *
     * @throws InvalidWampTransportProvider
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function getTransportProvider()
    {
        if (is_object($this->transportProvider)) {
            return $this->transportProvider;
        }

        if (is_null($this->transportProvider) || empty($this->transportProvider)) {
            $this->transportProvider = 'Thruway\Transport\RatchetTransportProvider';
        }

        if (is_string($this->transportProvider)) {
            return $this->transportProvider = new $this->transportProvider($this->host, $this->port);
        }

        throw new InvalidWampTransportProvider();
    }
}
