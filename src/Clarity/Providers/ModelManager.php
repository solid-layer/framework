<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

use Phalcon\Mvc\Model\Manager;

/**
 * Get the 'modelsManager' service provider.
 */
class ModelManager extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    protected $alias = 'modelsManager';

    /**
     * {@inheridoc}.
     */
    protected $shared = true;

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        return new Manager;
    }
}
