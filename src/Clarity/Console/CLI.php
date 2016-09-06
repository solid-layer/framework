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
use ReflectionClass;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * A cli class that mock the same cli commands.
 */
class CLI
{
    /**
     * Handles the brood default options/arguments.
     */
    public final static function ArgvInput()
    {
        # get the raw commands
        $raws = ['--env', '--timeout'];

        # get the options from Brood
        $options = [
            Brood::environmentOption(),
            Brood::timeoutOption(),
        ];

        $instances = [];
        $reflect = new ReflectionClass(InputOption::class);

        foreach ($options as $opt) {
            $instances[] = $reflect->newInstanceArgs($opt);
        }

        # still, listen to the php $_SERVER['argv']
        $cmd_input = new ArgvInput;

        # get the default brood options
        $brood_input = new ArgvInput(
            $raws,
            new InputDefinition($instances)
        );

        foreach ($raws as $raw) {
            if ($cmd_input->hasParameterOption([$raw])) {
                $val = $cmd_input->getParameterOption($raw);
                $val = is_numeric($val) ? (int) $val : $val;

                $brood_input->setOption(str_replace('-', '', $raw), $val);
            }
        }

        return $brood_input;
    }

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
        if (is_array($line)) {
            return static::bash($line);
        }

        $input = static::ArgvInput();
        $output = new ConsoleOutput;

        if ($input->hasOption('timeout')) {
            $timeout = $input->getOption('timeout');
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
     * Handles callback request, to have an input and output capability.
     *
     * @param $callback \Closure
     * @return void
     */
    public static function handleCallback(Closure $callback)
    {
        $output = new ConsoleOutput;

        $response = call_user_func_array(
            $callback,
            [static::ArgvInput(), $output]
        );

        if ($response) {
            static::process($response);
        }
    }

    /**
     * An ssh command builder.
     *
     * @param $server The server IP and Port
     * @param $scripts The array of scripts to be used
     * @param $execute Default to true if you want to automatically
     *                 run the script, if false, it will return as
     *                 an array
     * @return string
     */
    public static function ssh($server, $scripts = [], $execute = true)
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

        if ($execute === true) {
            return static::process($build);
        }

        return $build;
    }
}
