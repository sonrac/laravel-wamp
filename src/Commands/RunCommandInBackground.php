<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\WAMP\Commands;

use Symfony\Component\Process\PhpExecutableFinder;

/**
 * Class RunCommandInBackground
 *
 * @package sonrac\WAMP\Commands
 *
 * @see     https://github.com/dmitry-ivanov/laravel-helper-functions
 */
class RunCommandInBackground
{
    protected $command = null;
    protected $before = null;
    protected $after = null;
    protected $phpBinary = null;

    /**
     * RunCommandInBackground constructor.
     *
     * @param string $command
     * @param null $before
     * @param null $after
     */
    public function __construct($command, $before = null, $after = null)
    {
        $this->command = $command;
        $this->before = $before;
        $this->after = $after;
        $this->phpBinary = (new PhpExecutableFinder())->find();
    }

    /**
     * Create new command
     *
     * @param string      $command
     * @param string|null $before
     * @param string|null $after
     *
     * @return \sonrac\WAMP\Commands\RunCommandInBackground
     */
    public static function factory($command, $before = null, $after = null)
    {
        return new self($command, $before, $after);
    }

    /**
     * Run command in background and return process pid
     *
     * @return int|null
     */
    public function runInBackground()
    {
        exec($this->composeForRunInBackground(), $out, $pid);

        return count($out) ? (int) $out[0] : null;
    }

    /**
     * Prepare command for run ib background
     *
     * @return string
     */
    protected function composeForRunInBackground()
    {
        return "({$this->composeForRun()}) > /dev/null 2>&1 & echo $!";
    }

    /**
     * Prepare command for run
     *
     * @return string
     */
    protected function composeForRun()
    {
        $parts = [];
        if (!empty($this->before)) {
            $parts[] = (string) $this->before;
        }
        $parts[] = 'cd ' . base_path();
        $parts[] = "{$this->phpBinary} {$this->getArtisan()} {$this->command}";
        if (!empty($this->after)) {
            $parts[] = (string) $this->after;
        }
        return implode(' && ', $parts);
    }

    /**
     * Get artisan
     *
     * @return string
     */
    protected function getArtisan()
    {
        return defined('ARTISAN_BINARY') ? ARTISAN_BINARY : 'artisan';
    }
}
