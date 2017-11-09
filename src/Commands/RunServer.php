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
use sonrac\WAMP\Routers\Router;
use Thruway\Logging\Logger;

/**
 * Class RunServer
 * Run WAMP server command.
 */
class RunServer extends Command
{
    use WAMPCommandTrait;
    /**
     * WAMP router host.
     *
     * @var string
     */
    protected $host = '127.0.0.1';

    /**
     * {@inheritdoc}
     */
    protected $name = 'wamp:run-server {--realm=?} {--host=?} {--port=?} {--tls?} {--transport-provider=?}
    {--no-loop?} {--no-debug?} {--in-background?} {--client-transport-provider=?} {--route-path=?}';

    /**
     * {@inheritdoc}
     */
    protected $signature = 'wamp:run-server
                                {--realm= : Specify WAMP realm to be used}
                                {--host= : Specify the router host}
                                {--port= : Specify the router port}
                                {--tls : Specify the router protocol as wss}
                                {--no-debug : Disable debug mode.}
                                {--no-loop : Disable loop runner}
                                {--transport-provider : Transport provider class}
                                {--route-path= : Path to routes config}
                                {--client-transport-provider= : Client transport provider class}
                                {--in-background : Run task in background}
                                ';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Run wamp server';

    /**
     * Wamp server.
     *
     * @var \Thruway\Peer\ClientInterface|\sonrac\WAMP\Client
     */
    protected $WAMPServer = null;

    /**
     * Client transport provider class.
     *
     * @var null|string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $clientTransportProvider = null;

    /**
     * Run server handle.
     *
     * @throws \Exception
     */
    public function handle()
    {
        $this->parseOptions();
        $this->changeWampLogger();

        if (!$this->runInBackground) {
            $this->WAMPServer = app()->wampRouter;
            $transportProvider = $this->getTransportProvider();
            $this->WAMPServer->registerModule($transportProvider);
            $this->WAMPServer->start(!$this->runOnce);
        } else {
            $serverCommand = ' ' . $this->getName() . $this->getCommandLineOptions();

            if ($this->clientTransportProvider) {
                $serverCommand .= ' --client-transport-provider=' . $this->clientTransportProvider;
            }

            $this->addPidToLog(RunCommandInBackground::factory($serverCommand)->runInBackground(), 'servers.pids');
        }
    }

    /**
     * Get commandline options for background command
     *
     * @return string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function getCommandLineOptions()
    {
        $command = ' --port=' . $this->port .
            ' --host=' . $this->host .
            ' --realm=' . $this->realm;

        if ($this->clientTransportProvider) {
            $command .= ' --transport-provider=' . $this->clientTransportProvider;
        }

        if ($this->noDebug) {
            $command .= ' --no-debug';
        }

        if ($this->tls) {
            $command .= ' --tls';
        }

        if ($this->routePath) {
            $command .= ' --route-path=' . $this->routePath;
        }

        if ($this->noLoop) {
            $command .= ' --no-loop';
        }

        return $command;
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
     * Merge config & input options.
     */
    protected function parseOptions()
    {
        $this->clientTransportProvider = $this->getOptionFromInput('client-transport-provider');
        $this->parseBaseOptions();
    }

    /**
     * Get WAMP server transport provider.
     *
     * @return null|string|\Thruway\Transport\RatchetTransportProvider
     *
     * @throws \sonrac\WAMP\Exceptions\InvalidWampTransportProvider
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
