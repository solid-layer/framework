<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phalconslayer.readme.io
 */

/**
 */
namespace Clarity\Console\Clear;

use Clarity\Console\Brood;

/**
 * A console command that clears the storage cache.
 */
class CacheCommand extends Brood
{
    use ClearTrait;

    /**
     * {@inheritdoc}
     */
    protected $name = 'clear:cache';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Clear the storage/cache folder';

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $this->clear(storage_path('cache'));
    }
}
