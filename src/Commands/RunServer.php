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
    protected $signature = 'wamp:run-server {--host=?} {--debud} {--in-background}';
    protected $description = 'Run wamp server
                                {}';

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

    }
}
