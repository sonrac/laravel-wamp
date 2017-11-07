<?php

require_once __DIR__.'/BaseStartCommand.php';

use sonrac\WAMP\Commands\RegisterRoutes;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutput;

class RoutesRunCest extends BaseStartCommand
{
    protected $fileName = 'clients.pids';

    /**
     * @inheritDoc
     */
    function getCommand(): \Illuminate\Console\Command
    {
        return new RegisterRoutes();
    }

    // tests
    public function testRunInBackground(UnitTester $tester)
    {
        $inputDefinition = new InputDefinition([
            new InputOption(
                '--in-background',
                '-i',
                InputOption::VALUE_NONE | InputOption::VALUE_OPTIONAL,
                'Run in background'
            )
        ]);
        $input = new ArgvInput([
            '',
            '--in-background'
        ], $inputDefinition);
        $output = new ConsoleOutput();

        $this->command->run($input, $output);

        $tester->assertFileExists($this->file);
    }
}
