<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii <doniysa@gmail.com>
 * Date: 11/3/17
 * Time: 6:08 PM
 */

namespace sonrac\WAMP\Commands;

use Thruway\Logging\ConsoleLogger;
use Thruway\Logging\Logger;

/**
 * @trait WAMPCommandTrait
 *
 * @author Donii Sergii <doniysa@gmail.com>
 */
trait WAMPCommandTrait
{
    /**
     * WAMP router host.
     *
     * @var string
     */
    protected $host = '127.0.0.1';

    /**
     * Wamp realm to used.
     *
     * @var string
     */
    protected $realm = 'realm';

    /**
     * WAMP router port.
     *
     * @var int
     */
    protected $port = '9090';

    /**
     * Run in debug mode. Echo output to console.
     *
     * @var bool
     */
    protected $noDebug = false;

    /**
     * Run in loop or once.
     *
     * @var bool
     */
    protected $runOnce = false;

    /**
     * Specify the router protocol as wss.
     *
     * @var bool
     */
    protected $tls = false;

    /**
     * WAMP routes path.
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $routePath = null;

    /**
     * Transport provider class.
     *
     * @var string|\Thruway\Transport\RatchetTransportProvider|null
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $transportProvider = 'Thruway\Transport\RatchetTransportProvider';

    /**
     * Run in background.
     *
     * @var bool
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $runInBackground = false;

    /**
     * No loop runner
     *
     * @var bool
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $noLoop = false;

    /**
     * Get option value from input.
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
     * Get minion config.
     *
     * @param string|null $optName Option name
     * @param mixed       $default Default value
     *
     * @return array|string|int|null
     */
    protected function getConfig($optName = null, $default = null)
    {
        $options = config('wamp') ?? [];

        if (null === $optName) {
            return $options ?? [];
        }

        return isset($options[$optName]) ? $options[$optName] : $default;
    }

    /**
     * Get logger class for wamp
     *
     * @return \Psr\Log\LoggerInterface
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    abstract protected function getLogger();

    /**
     * Change WAMP logger
     *
     * @param string $fileName
     *
     * @return void
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function changeWampLogger($fileName = 'wamp-server.log')
    {
        if (!$this->noDebug) {
            return;
        }

        Logger::set($this->getLogger());
    }

    /**
     * Parse base options
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function parseBaseOptions()
    {
        $this->host = $this->getOptionFromInput('host') ?? $this->getConfig('host', $this->host);
        $this->port = $this->getOptionFromInput('port') ?? $this->getConfig('port', $this->port);
        $this->realm = $this->getOptionFromInput('realm') ?? $this->getConfig('realm', $this->realm);
        $this->tls = $this->getOptionFromInput('tls') ?? $this->getConfig('tls', $this->tls);
        $this->transportProvider = $this->getOptionFromInput('transport-provider') ?? $this->getConfig('transportProvider',
                $this->transportProvider);
        $this->runInBackground = $this->getOptionFromInput('in-background') ?? false;

        $this->noDebug = $this->getOptionFromInput('no-debug') ?? $this->noDebug;
        $this->runOnce = $this->getOptionFromInput('no-loop') ?? $this->runOnce;

        $this->routePath = $this->getOptionFromInput('route-path') ?? $this->getConfig('routePath', $this->routePath);
        $this->routePath = is_string($this->routePath) ? realpath($this->routePath) : null;

        if (!$this->noDebug) {
            Logger::set(new ConsoleLogger());
        }
    }

    /**
     * Parse input options
     *
     * @return mixed
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    abstract protected function parseOptions();

    /**
     * Get transport provider
     *
     * @return mixed
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    abstract protected function getTransportProvider();

    /**
     * Add pid process
     *
     * @param int    $pid      Process pid
     * @param string $fileName Filename
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function addPidToLog($pid, $fileName = 'server.pids')
    {
        $fileName = storage_path($fileName);
        if (!file_exists(storage_path($fileName))) {
            file_put_contents($fileName, $pid);

            return;
        }

        $content = file_get_contents($fileName);

        file_put_contents($fileName, $content.PHP_EOL.$pid);
    }
}
