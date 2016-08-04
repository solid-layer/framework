<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

/**
 */
namespace Clarity\Console\Clear;

use Clarity\Console\Brood;

/**
 * A console command that clears the storage logs.
 */
class LogsCommand extends Brood
{
    use ClearTrait;

    /**
     * {@inheritdoc}
     */
    protected $name = 'clear:logs';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Clear the storage/logs folder';

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $this->clear(storage_path('logs'));
    }
}
