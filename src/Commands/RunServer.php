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
    /**
     * WAMP router host
     *
     * @var string
     */
    protected $host = '127.0.0.1';

    /**
     * Wamp realm to used
     *
     * @var string
     */
    protected $realm;

    /**
     * Providers list
     *
     * @var array
     */
    protected $providers = [];

    /**
     * WAMP router port
     *
     * @var int
     */
    protected $port = '9090';

    /**
     * Run in debug mode. If `in-background` option is disable, logging to storage_path('server-{pid}.log')
     *
     * @var bool
     */
    protected $noDebug = false;

    /**
     * Run in loop or once
     *
     * @var bool
     */
    protected $runOnce = false;

    /**
     * Specify the router protocol as wss
     *
     * @var bool
     */
    protected $tls = false;

    /**
     * @var null|string
     */
    protected $path = null;

    /**
     * Transport provider class
     *
     * @var string|\Thruway\Transport\RatchetTransportProvider|null
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $transportProvider = 'Thruway\Transport\RatchetTransportProvider';

    protected $name = 'run:wamp-server {--realm=?} {--host=?} {--port=?} {--tls?} {--path=?} {--providers=*?} {--transportProvider}
    {--no-loop?} {--debug?}';
    protected $signature = 'run:wamp-server
                                {--realm= : Specify WAMP realm to be used}
                                {--host= : Specify the router host}
                                {--port= : Specify the router port}
                                {--tls : Specify the router protocol as wss}
                                {--path= : Specify the router path component}
                                {--providers=* : Register provider classes},
                                {--no-debug : Disable debug mode.}
                                {--no-loop : Disable loop runner}
                                {--transportProvider : Transport provider class}
                                ';
    protected $description = 'Run wamp server';

    /**
     * Wamp server
     *
     * @var null|\sonrac\WAMP\Routers\Router
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

        $this->WAMPServer = app()->wampRouter;
        $transportProvider = $this->getTransportProvider();

        $this->WAMPServer->addTransportProvider($transportProvider);

        $this->WAMPServer->start(!$this->runOnce);
    }

    /**
     * Merge config & input options
     */
    protected function parseOptions()
    {
        $this->host = $this->getOptionFromInput('host') ?? $this->getConfig('host', $this->host);
        $this->port = $this->getOptionFromInput('port') ?? $this->getConfig('port', $this->port);
        $this->path = $this->getOptionFromInput('path') ?? $this->getConfig('path', $this->path);
        $this->realm = $this->getOptionFromInput('realm') ?? $this->getConfig('realm', $this->realm);
        $this->providers = $this->getOptionFromInput('providers') ?? $this->getConfig('providers', $this->providers);
        $this->tls = $this->getOptionFromInput('tls') ?? $this->getConfig('tls', $this->tls);
        $this->transportProvider = $this->getOptionFromInput('transportProvider') ?? $this->getConfig('transportProvider',
                $this->transportProvider);

        $this->noDebug = $this->getOptionFromInput('no-debug') ?? $this->noDebug;
        $this->runOnce = $this->getOptionFromInput('no-loop') ?? $this->runOnce;
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

    /**
     * Get option value from input
     *
     * @param string $optionName
     *
     * @return array|null|string
     */
    protected function getOptionFromInput(string $optionName, $default = null)
    {
        if (null === $this->input->getOption($optionName)) {
            return $default;
        }

        return $this->option($optionName);
    }

    /**
     * Get minion config
     *
     * @param string|null $optName Option name
     * @param mixed       $default Default value
     *
     * @return array|string|int|null
     */
    protected function getConfig($optName = null, $default = null)
    {
        $options = config('minion') ?? [];

        if (null === $optName) {
            return $options ?? [];
        }

        return isset($options[$optName]) ? $options[$optName] : $default;
    }
}
