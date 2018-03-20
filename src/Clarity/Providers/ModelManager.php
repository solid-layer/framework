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
    public function register()
    {
        $this->app->instance('modelsManager', new Manager, $singleton = true);
    }
}
