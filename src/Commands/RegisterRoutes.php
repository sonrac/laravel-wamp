<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii <doniysa@gmail.com>
 * Date: 11/3/17
 * Time: 5:58 PM
 */

namespace sonrac\WAMP\Commands;

use Illuminate\Console\Command;
use sonrac\WAMP\Exceptions\InvalidWampTransportProvider;

/**
 * @class  RegisterRoutes
 * <summary>
 *
 * @author Donii Sergii <doniysa@gmail.com>
 */
class RegisterRoutes extends Command
{
    use WAMPCommandTrait;

    /**
     * {@inheritdoc}
     */
    protected $name = 'wamp:register-routes {--realm=?} {--host=?} {--port=?} {--tls?} {--transport-provider=?}
                {--no-loop?} {--debug?} {--route=path=?}';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Register wamp routes';

    /**
     * {@inheritdoc}
     */
    protected $signature = 'wamp:register-routes
                                {--realm= : Specify WAMP realm to be used}
                                {--host= : Specify the router host}
                                {--port= : Specify the router port}
                                {--path= : Specify the router path component}
                                {--no-debug : Disable debug mode.}
                                {--no-loop : Disable loop runner}
                                {--route-path=? : Path to routes config}
                                {--tls : Specify the router protocol as wss}
                                {--in-background : Run client in background}
                                {--transport-provider=? : Transport provider class}';

    /**
     * Register wamp routes
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function fire()
    {
        $this->changeWampLogger();
        $this->parseOptions();

        if (!$this->runInBackground) {
            $client = app()->wampClient;

            $client->addTransportProvider($this->getTransportProvider());
            $client->setRoutePath($this->routePath);
            $client->start();
        } else {
            $command = ' --port=' . $this->port .
                ' --host=' . $this->host .
                ' --realm=' . $this->realm;

            if ($this->transportProvider) {
                $command .= ' --transport-provider=' . $this->transportProvider;
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
            $this->addPidToLog(RunCommandInBackground::factory($command)->runInBackground(), 'clients.pids');
        }
    }

    /**
     * Register wamp routes
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function handle()
    {
        return $this->fire();
    }

    /**
     * {@inheritdoc}
     */
    protected function parseOptions()
    {
        $this->parseBaseOptions();
    }

    /**
     * Get WAMP client transport provider
     *
     * @return null|string|\Thruway\Transport\ClientTransportProviderInterface
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
            $this->transportProvider = '\Thruway\Transport\PawlTransportProvider';
        }

        if (is_string($this->transportProvider)) {
            return $this->transportProvider = new $this->transportProvider($this->getTransportURI());
        }

        throw new InvalidWampTransportProvider();
    }

    /**
     * Get transport url
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function getTransportURI()
    {
        return ($this->tls ? 'wss://' : 'ws://') . $this->host . ':' . $this->port;
    }
}
