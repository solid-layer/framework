<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

use Clarity\Support\Auth\Auth as BaseAuth;

/**
 * This provider handles the general authentication.
 */
class Auth extends ServiceProvider
{
	protected $deffer = true;

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $this->app->instance('auth', new BaseAuth, $singleton = true);
    }

    public function provides()
    {
    	return ['auth'];
    }
}
