<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii <doniysa@gmail.com>
 * Date: 11/3/17
 * Time: 5:58 PM
 */

namespace sonrac\WAMP\Commands;

use Illuminate\Console\Command;


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
     * WAMP routes path
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $routePath = null;


    /**
     * {@inheritdoc}
     */
    protected $name = 'wamp:register-routes';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Register wamp routes';

    /**
     * {@inheritdoc}
     */
    protected $signature = 'run:wamp-server
                                {--realm= : Specify WAMP realm to be used}
                                {--host= : Specify the router host}
                                {--port= : Specify the router port}
                                {--path= : Specify the router path component}
                                {--no-debug : Disable debug mode.}
                                {--no-loop : Disable loop runner}
                                {--transportProvider : Transport provider class}';

    /**
     * Register wamp routes
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function fire()
    {
        $this->changeWampLogger();
        $this->parseOptions();
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
     * {@inheritDoc}
     */
    protected function parseOptions()
    {
        $this->parseBaseOptions();
    }
}