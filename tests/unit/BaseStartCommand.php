<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii <doniysa@gmail.com>
 * Date: 11/7/17
 * Time: 5:28 PM
 */

/**
 * @class  BaseStartCommand
 * <summary>
 *
 * @author Donii Sergii <doniysa@gmail.com>
 */
abstract class BaseStartCommand
{
    /**
     * Pids file name
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $file;

    /**
     * Command.
     *
     * @var null|\sonrac\WAMP\Commands\RunServer|\Illuminate\Console\Command|\sonrac\WAMP\Commands\RegisterRoutes
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $command = null;

    protected $fileName = 'servers.pids';

    /**
     * Get command
     *
     * @return \Illuminate\Console\Command
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    abstract public function getCommand(): \Illuminate\Console\Command;

    public function _before(UnitTester $I)
    {
        $this->file = storage_path($this->fileName);
        if (file_exists($this->file)) {
            unlink($this->file);
        }

        $this->command = $this->getCommand();
        $this->command->setLaravel(app());
    }

    public function _after(UnitTester $I)
    {
        if (file_exists($this->file)) {
            $pids = explode(PHP_EOL, file_get_contents($this->file));
            foreach ($pids as $pid) {
                $pid = trim($pid);

                if (strlen($pid)) {
                    exec('kill -9 '.$pid);
                }
            }
        }
    }
}
