<?php

namespace Clarity\Console;

class CLITest extends \PHPUnit_Framework_TestCase
{
    public function testBash()
    {
        $scripts = [
            'travis_ci_script_1' => function ($input, $output) {

                # I must be able to call a CLI or any classes here
                CLI::process('echo "Testing CLI::handleCallback()"');

                $output->writeln('<comment>testing writeln with comment style</comment>');
                $output->writeln('<error>testing writeln with error style</error>');

                # also when returning an array or string
                # it should be able to handle this scripts
                return ['echo "Script 1: returning array in callback"'];
            },
            'travis_ci_script_2' => 'echo "Script 2: using CLI::process(<string>)"',
            'travis_ci_script_3' => [
                'echo "Script 3: using CLI::bash(<array>)"',
            ],
            'travis_ci_script_4' => CLI::ssh('root@domain.com', ['ls'], $execute = false),
            'travis_ci_script_5' => function ($input, $output) {
                return 'echo "Script 5: returning string in callback"';
            },
        ];

        # a callback, returning array
        CLI::handleCallback($scripts['travis_ci_script_1']);

        # a string
        CLI::process($scripts['travis_ci_script_2']);

        # an array
        CLI::bash($scripts['travis_ci_script_3']);

        # a generated ssh script
        // CLI::process($scripts['travis_ci_script_4']);

        # a callback, returning string
        CLI::handleCallback($scripts['travis_ci_script_5']);

        # this must automatically be executed, the third
        # parameter is automatically assigned as true
        // CLI::ssh('root@domain.com', ['ls']);
    }
}
