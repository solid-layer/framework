<?php
/**
 * PhalconSlayer\Framework
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phalconslayer.readme.io
 */

/**
 * @package Clarity
 * @subpackage Clarity\Console\Server
 */
namespace Clarity\Console\Server;

use Clarity\Console\CLI;
use Clarity\Console\SlayerCommand;

class EnvCommand extends SlayerCommand
{
    protected $name = 'env';
    protected $description = 'Get current environment';

    public function slash()
    {
        $timeout = $this->getInput()->getOption('timeout');

        $this->info(
            "\n".'Your current environment ['.config()->environment.']'."\n"
            // .' | Timeout: '.$timeout
        );
    }
}
