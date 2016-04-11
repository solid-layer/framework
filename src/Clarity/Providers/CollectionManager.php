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
 * @subpackage Clarity\Providers
 */
namespace Clarity\Providers;

use Phalcon\Mvc\Collection\Manager as BaseCollectionManager;

class CollectionManager extends ServiceProvider
{
    protected $alias = 'collectionManager';
    protected $shared = true;

    public function register()
    {
        return new BaseCollectionManager;
    }
}
