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

class SessionCommand extends SlayerCommand
{
    use ClearTrait;

    protected $name = 'clear:session';
    protected $description = 'Clear the storage/session folder';

    public function slash()
    {
        $this->clear(storage_path('session'));
    }
}
