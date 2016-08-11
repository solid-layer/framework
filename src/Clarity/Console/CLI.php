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
    public static function bash(array $lines, $prefix = null, $suffix = null)
    {
        foreach ($lines as $line) {
            static::process($line, $prefix, $suffix);
        }
    }

    public static function process($line, $prefix = null, $suffix = null)
    {
        $proc = new Process($line);

        $proc->run(function ($type, $buffer) use ($line, $prefix, $suffix) {

            foreach (explode("\n", $buffer) as $buffer) {
                $buffer = $prefix.$buffer.$suffix;

                if (Process::ERR === $type) {
                    static::errorMessage($buffer);
                } else {
                    static::infoMessage($buffer);
                }
            }
        });
    }

    public static function errorMessage($buffer)
    {
        echo "\e[31m{$buffer}\e[37m\n";
    }

    public static function infoMessage($buffer)
    {
        echo "\e[32m{$buffer}\e[37m\n";
    }

    public static function logMessage($buffer)
    {
        echo "\e[37m{$buffer}\e[37m\n";
    }

    public static function ssh($server, Closure $callback)
    {
        $scripts = call_user_func($callback);
        $scripts = implode("\n", $scripts);

        $delimiter = 'EOF-SLAYER-SCRIPT';

        $build = "ssh $server 'bash -se' << \\$delimiter".PHP_EOL
            .'set -e'.PHP_EOL
            .$scripts.PHP_EOL
            .$delimiter;

        return function () use ($server, $scripts, $build) {
            static::logMessage('Connecting to '.$server.' through ssh ...');
            static::logMessage($scripts);
            static::process($build, '['.$server.']: ');
        };
    }
}
