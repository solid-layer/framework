<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

use Phalcon\Filter as BaseFilter;

/**
 * This provider handles the filter component of Phalcon Framework.
 *
 * Sanitizing is the process which removes specific characters from a value,
 * that are not required or desired by the user or application.
 * By sanitizing input we ensure that application integrity will be intact.
 */
class Filter extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $this->app->instance('filter', new BaseFilter, $singleton = true);
    }
}
