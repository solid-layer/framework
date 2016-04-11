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
 * @subpackage Clarity\Console\Clear
 */
namespace Clarity\Console\Clear;

use Clarity\Console\SlayerCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class LogsCommand extends SlayerCommand
{
    use ClearTrait;

    protected $name = 'clear:logs';
    protected $description = 'Clear the storage/logs folder';

    public function slash()
    {
        $this->clear(storage_path('logs'));
    }
}
