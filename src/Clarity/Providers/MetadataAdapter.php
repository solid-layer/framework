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
namespace Clarity\Providers;

use Phalcon\Mvc\Model\Metadata\Memory;

/**
 * This provider is required when querying fields using Phalcon Models.
 *
 * To speed up development Phalcon\Mvc\Model helps you to query fields and
 * constraints from tables related to models. To achieve this,
 * Phalcon\Mvc\Model\MetaData is available to manage and cache table meta-data.
 */
class MetadataAdapter extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    protected $alias = 'modelsMetadata';

    /**
     * {@inheridoc}.
     */
    protected $shared = false;

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        return new Memory;
    }
}
