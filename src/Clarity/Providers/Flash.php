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
    protected $alias = 'flash';

    /**
     * {@inheridoc}.
     */
    protected $shared = true;

    /**
     * {@inheridoc}.
     */
    public function boot()
    {
        return $this;
    }

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $elements = $this->elements;

        # this will be as di()->get('flash.direct');
        $this->subRegister('direct', function () use ($elements) {
            $flash = new PhalconFlashDirect($elements);

            # setAutoescape is only available for >= 2.1.x Phalcon Version
            if (method_exists($flash, 'setAutoescape')) {
                $flash->setAutoescape(false);
            }

            return $flash;
        }, true);

        # this will be as di()->get('flash.session');
        $this->subRegister('session', function () use ($elements) {
            $flash = new PhalconFlashSession($elements);

            # setAutoescape is only available for >= 2.1.x Phalcon Version
            if (method_exists($flash, 'setAutoescape')) {
                $flash->setAutoescape(false);
            }

            return $flash;
        }, true);

        # this will be as di()->get('flash');
        return $this;
    }

    /**
     * Get direct based flash.
     *
     * @return mixed \Phalcon\Flash\Direct
     */
    public function direct()
    {
        return di()->get('flash.direct');
    }

    /**
     * Get session based flash.
     *
     * @return mixed \Phalcon\Flash\Session
     */
    public function session()
    {
        return di()->get('flash.session');
    }
}
