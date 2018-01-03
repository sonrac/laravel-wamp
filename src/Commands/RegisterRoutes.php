<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii <doniysa@gmail.com>
 * Date: 11/3/17
 * Time: 5:58 PM
 */

namespace sonrac\WAMP\Commands;

use Illuminate\Console\Command;
use sonrac\WAMP\Client;
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
                {--no-loop?} {--no-debug?} {--route-path=?}';

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
                                {--route-path= : Path to routes config}
                                {--tls : Specify the router protocol as wss}
                                {--in-background : Run client in background}
                                {--transport-provider= : Transport provider class}';

    /**
     * Register wamp routes
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function fire()
    {
        $this->transportProvider = '\Thruway\Transport\PawlTransportProvider';

        $this->parseOptions();
        $this->changeWampLogger();

        if (!$this->runInBackground) {
            if ($this->realm) {
                config('wamp.realm', $this->realm);
                app()->wampClient = new Client($this->realm);
                if ($this->routePath) {
                    app()->wampClient->setRoutePath($this->routePath);
                }
            }

            $client = app()->wampClient;
            $client->addTransportProvider($this->getTransportProvider());
            $client->start(!$this->runOnce);
        } else {
            $command = $this->getName().($this->port ? ' --port='.$this->port : '').
                ($this->host ? ' --host='.$this->host : '').
                ($this->realm ? ' --realm='.$this->realm : '');

            if ($this->transportProvider) {
                $command .= ' --transport-provider='.str_replace('\\', '\\\\', $this->transportProvider);
            }

            if ($this->noDebug) {
                $command .= ' --no-debug';
            }

            if ($this->tls) {
                $command .= ' --tls';
            }

            if ($this->routePath) {
                $command .= ' --route-path='.$this->routePath;
            }

            if ($this->noLoop) {
                $command .= ' --no-loop';
            }
            $this->addPidToLog(RunCommandInBackground::factory($command)->runInBackground(), DownWAMP::CLIENT_PID_FILE);
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
        return ($this->tls ? 'wss://' : 'ws://').$this->host.':'.$this->port;
    }

    /**
     * {@inheritdoc}
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function getLogger()
    {
        return app('wamp.client.logger');
    }
}
