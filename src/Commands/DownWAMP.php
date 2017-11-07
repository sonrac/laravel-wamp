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
    public function fire() {
        $clientsOnly = $this->option('client-only');
        $serversOnly = $this->option('server-only');

        if (!$serversOnly) {
            $this->stopInstances(storage_path('clients.pids'));
        }

        if (!$clientsOnly) {
            $this->stopInstances(storage_path('servers.pids'));
        }
    }

    /**
     * Handle command alias
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function handle() {
        $this->fire();
    }

    private function stopInstances($file) {
        if (file_exists($file)) {
            $content = explode(PHP_EOL, file_get_contents($file));

            if (count($content)) {
                foreach ($content as $pid) {
                    $pid = (int) trim($pid);

                    if ($pid > 0) {
                        exec('kill ' . $pid);
                    }
                }

                exec('rm ' . $file);
            }
        }

    }

}