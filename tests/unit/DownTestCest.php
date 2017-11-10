<?php

use sonrac\WAMP\Commands\DownWAMP;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutput;

class DownTestCest
{
    public function _before(UnitTester $I)
    {
    }

    public function _after(UnitTester $I)
    {
    }

    // tests
    public function testDownClients(UnitTester $tester)
    {
        $inputDefinition = new InputDefinition([
            new InputOption(
                '--client-only',
                '-c',
                InputOption::VALUE_NONE | InputOption::VALUE_OPTIONAL
            ),
        ]);
        $input = new ArgvInput([
            '',
            '--client-only',
        ], $inputDefinition);
        $output = new ConsoleOutput();

        $command = new DownWAMP();
        $command->setLaravel(app());
        $command->run($input, $output);

        $tester->assertFalse(file_exists(storage_path(DownWAMP::CLIENT_PID_FILE)));
    }

    // tests
    public function testDownServers(UnitTester $tester)
    {
        $inputDefinition = new InputDefinition([
            new InputOption(
                '--server-only',
                '-s',
                InputOption::VALUE_NONE | InputOption::VALUE_OPTIONAL
            ),
        ]);
        $input = new ArgvInput([
            '',
            '--server-only',
        ], $inputDefinition);
        $output = new ConsoleOutput();

        $command = new DownWAMP();
        $command->setLaravel(app());
        $command->run($input, $output);

        $tester->assertFalse(storage_path(DownWAMP::SERVER_PID_FILE));
    }
}
