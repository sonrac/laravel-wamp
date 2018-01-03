<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii <doniysa@gmail.com>
 * Date: 11/7/17
 * Time: 3:39 PM
 */

namespace sonrac\WAMP\Commands;

use Illuminate\Console\Command;

/**
 * @class  DownWAMP
 * Down WAMP servers & clients command.
 *
 * @author Donii Sergii <doniysa@gmail.com>
 */
class DownWAMP extends Command
{
    const SERVER_PID_FILE = 'servers.pids';
    const CLIENT_PID_FILE = 'clients.pids';

    /**
     * {@inheritdoc}
     */
    protected $signature = 'wamp:stop {--server-only} {--client-only}';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Stop all background running server & clients
                                {--server-only : Stop only running server instances}
                                {--client-only : Stop only running client instances}
    ';

    /**
     * Handle command
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function fire()
    {
        $clientsOnly = $this->option('client-only');
        $serversOnly = $this->option('server-only');

        if (!$serversOnly) {
            $this->stopInstances(storage_path(self::CLIENT_PID_FILE));
        }

        if (!$clientsOnly) {
            $this->stopInstances(storage_path(self::SERVER_PID_FILE));
        }
    }

    /**
     * Handle command alias
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function handle()
    {
        $this->fire();
    }

    /**
     * Stop all process by pids from file $file
     *
     * @param string $filename
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    private function stopInstances($filename)
    {
        if (file_exists($filename)) {
            $content = explode(PHP_EOL, file_get_contents($filename));

            if (count($content)) {
                foreach ($content as $pid) {
                    $pid = (int) trim($pid);

                    posix_kill($pid, 9);
                }
            }
            unlink($filename);
        }
    }
}
