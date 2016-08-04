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
    public static function bash(array $lines)
    {
        foreach ($lines as $line) {
            $proc = new Process($line);

            $proc->run(function ($type, $buffer) {
                if (Process::ERR === $type) {
                    echo "\e[37m{$buffer}\e[37m\n";
                } else {
                    echo "\e[32m{$buffer}\e[37m\n";
                }
            });
        }
    }
}
