<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

use Phalcon\Flash\Direct as PhalconFlashDirect;
use Phalcon\Flash\Session as PhalconFlashSession;

/**
 * This component helps to separate session data into “namespaces”.
 * Working by this way you can easily create groups of session variables into the application.
 */
class Flash extends ServiceProvider
{
    // protected $defer = true;

    // public function provides()
    // {
    //     return ['flash.direct', 'flash.session', 'flash'];
    // }

    /**
     * The elements.
     *
     * @var array
     */
    protected $elements = [
        // 'error'   => 'alert alert-danger',
        // 'success' => 'alert alert-success',
        // 'notice'  => 'alert alert-info',
        // 'warning' => 'alert alert-warning',
    ];

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        # this will be as $this->getDI()->get('flash.direct');
        $this->app->singleton('flash.direct', function () {
            $flash = new PhalconFlashDirect($this->elements);

            # setAutoescape is only available for >= 2.1.x Phalcon Version
            if (method_exists($flash, 'setAutoescape')) {
                $flash->setAutoescape(false);
            }

            return $flash;
        });

        # this will be as $this->getDI()->get('flash.session');
        $this->app->singleton('flash.session', function () {
            $flash = new PhalconFlashSession($this->elements);

            # setAutoescape is only available for >= 2.1.x Phalcon Version
            if (method_exists($flash, 'setAutoescape')) {
                $flash->setAutoescape(false);
            }

            return $flash;
        });

        $this->app->instance('flash', $this, $singleton = true);
    }

    /**
     * Get direct based flash.
     *
     * @return mixed \Phalcon\Flash\Direct
     */
    public function direct()
    {
        return $this->app->make('flash.direct');
    }

    /**
     * Get session based flash.
     *
     * @return mixed \Phalcon\Flash\Session
     */
    public function session()
    {
        return $this->app->make('flash.session');
    }
}
