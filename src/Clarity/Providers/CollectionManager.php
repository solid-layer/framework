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

/**
 * This provider controls the initialization of models, keeping record
 * of relations between the different models of the application.
 */
class CollectionManager extends ServiceProvider
{
    /**
     * {@inheridoc}
     */
    protected $alias = 'collectionManager';

    /**
     * {@inheridoc}
     */
    protected $shared = true;

    /**
     * {@inheridoc}
     */
    public function register()
    {
        return new BaseCollectionManager;
    }
}
