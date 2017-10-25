<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/24/17
 * Time: 10:33 AM
 */

namespace sonrac\WAMP\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

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
    protected $host;

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
    protected $port;

    /**
     * Run in debug mode. If `in-background` option is disable, logging to storage_path('server-{pid}.log')
     *
     * @var bool
     */
    protected $debug = false;

    /**
     * Run command in background
     *
     * @var bool
     */
    protected $inBackground = false;

    protected $name = 'Run WAMP server';
    protected $description = 'Run wamp server';

    /**
     * {@inheritdoc}
     */
    protected function getOptions()
    {
        return [
            ['realm', null, InputOption::VALUE_OPTIONAL, 'Specify WAMP realm to be used'],
            ['host', null, InputOption::VALUE_OPTIONAL, 'Specify the router host'],
            ['port', null, InputOption::VALUE_OPTIONAL, 'Specify the router port'],
            ['tls', null, InputOption::VALUE_NONE, 'Specify the router protocol as wss'],
            ['path', null, InputOption::VALUE_OPTIONAL, 'Specify the router path component'],
            ['providers', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Register provider classes'],
            ['debug', null, InputOption::VALUE_NONE, 'Run in debug mode outputting all trasport messages.'],
            [
                'in-background',
                null,
                InputOption::VALUE_NONE | InputOption::VALUE_OPTIONAL,
                'Run in background mode with save process pid'
            ]
        ];
    }

    /**
     * Run server handle
     */
    protected function handle()
    {
        $this->parseOptions();
    }

    /**
     * Merge config & input options
     */
    protected function parseOptions() {
        $this->host = $this->getOptionFromInput('host') ?? $this->getConfig('host');
        $this->port = $this->getOptionFromInput('port') ?? $this->getConfig('port');
        $this->realm = $this->getOptionFromInput('realm') ?? $this->getConfig('realm');
        $this->providers = $this->getOptionFromInput('providers') ?? $this->getConfig('providers');
        $this->tls = $this->getOptionFromInput('tls') ?? $this->getConfig('tls');
        $this->debug = $this->getOptionFromInput('debug') ?? $this->debug;
        $this->inBackground = $this->getOptionFromInput('in-background') ?? $this->inBackground;
    }

    /**
     * Get option value from input
     *
     * @param string $optionName
     *
     * @return array|null|string
     */
    protected function getOptionFromInput(string $optionName) {
        if (!$this->hasOption($optionName)) {
            return null;
        }

        return $this->option($optionName);
    }

    /**
     * Get minion config
     *
     * @param string|null $optName Option name
     *
     * @return array|string|int|null
     */
    protected function getConfig($optName = null)
    {
        $options = config('minion') ?? [];

        if (null === $optName) {
            return $options ?? [];
        }

        return isset($options[$optName]) ? $options[$optName] : null;
    }
}
