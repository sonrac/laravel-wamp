<?php

require_once __DIR__.'/BaseStartCommand.php';

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutput;
use sonrac\WAMP\Commands\RunServer;

/**
 * Class RunCommandTestCest
 * Run WAMP server command test.
 *
 * @author Donii Sergii <doniysa@gmail.com>
 */
class RunCommandTestCest extends BaseStartCommand
{
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

    /**
     * @inheritDoc
     */
    function getCommand(): \Illuminate\Console\Command
    {
        return new RunServer();
    }
}
