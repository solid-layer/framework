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

class ViewsCommand extends SlayerCommand
{
    use ClearTrait;

    protected $name = 'clear:views';
    protected $description = 'Clear the storage/views folder';

    public function slash()
    {
        $this->clear(
            url_trimmer(storage_path('views'))
        );
    }
}
