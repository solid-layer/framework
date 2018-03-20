<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

use Phalcon\Security as BaseSecurity;

/**
 * Get the 'security' service provider.
 */
class Security extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $this->app->instance('security', new BaseSecurity, $singleton = true);
    }
}
