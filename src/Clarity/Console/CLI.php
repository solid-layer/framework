<?php
/**
 * PhalconSlayer\Framework Helpers.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

/**
 */
namespace Clarity\Console;

use Closure;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * A cli class that mock the same cli commands.
 */
class CLI
{
    /**
     * It executes all the requested commands.
     *
     * @param mixed $lines An array lists of all bash commands
     * @return string The output
     */
    public static function bash(array $lines)
    {
        foreach ($lines as $line) {
            static::process($line);
        }
    }

    /**
     * Single execution command.
     *
     * @param string $line The command to be executed
     * @return void
     */
    public static function process($line, $timeout = 60)
    {
        $input = new ArgvInput;
        $output = new ConsoleOutput;

        if ($input->hasParameterOption(['--timeout'])) {
            $timeout = (int) $input->getParameterOption('--timeout');
        }

        $output->writeln("<comment>".$line."</comment>");

        $proc = new Process($line);
        $proc->setTimeout($timeout);
        $proc->run(function ($type, $buffer) use ($output) {
            foreach (explode("\n", $buffer) as $buffer) {
                if (Process::OUT === $type) {
                    $output->writeln("<info>".$buffer."</info>");
                } else {
                    $output->writeln($buffer);
                }
            }
        });
    }

    /**
     * An ssh command builder.
     *
     * @param $server The server IP and Port
     * @param $scripts The array of scripts to be used
     * @return string
     */
    public static function ssh($server, $scripts = [])
    {
        if ($scripts instanceof Closure) {
            $scripts = call_user_func($scripts);
        }

        $scripts = implode("\n", $scripts);

        $delimiter = 'EOF-SLAYER-SCRIPT';

        $build = "ssh $server 'bash -se' << \\$delimiter".PHP_EOL
            .'set -e'.PHP_EOL
            .$scripts.PHP_EOL
            .$delimiter;

        return $build;
    }
}
