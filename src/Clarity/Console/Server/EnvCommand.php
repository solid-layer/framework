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

/**
 * A console command that determines the current environment
 */
class EnvCommand extends SlayerCommand
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'env';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Get current environment';

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $timeout = $this->getInput()->getOption('timeout');

        $this->info(
            "\n".'Your current environment ['.config()->environment.']'."\n"
            // .' | Timeout: '.$timeout
        );
    }
}
