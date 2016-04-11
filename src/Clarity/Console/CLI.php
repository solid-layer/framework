<?php
/**
 * PhalconSlayer\Framework Helpers
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phalconslayer.readme.io
 */

/**
 * @package Clarity
 * @subpackage Clarity\Console\App
 */
namespace Clarity\Console;

use Symfony\Component\Process\Process;

class CLI
{
    public static function bash($lines)
    {
        foreach ($lines as $line) {
            $proc = new Process($line);

            $proc->run(function ($type, $buffer) {
                if (Process::ERR === $type) {
                    echo "\e[37m{$buffer}\e[37m";
                } else {
                    echo "\e[32m{$buffer}\e[37m";
                }
            });
        }
    }
}
