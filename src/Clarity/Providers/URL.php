<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

use Clarity\Support\Phalcon\Mvc\URL as BaseURL;

/**
 * This provider instantiates the @see \Clarity\Support\Phalcon\Mvc\URL.
 */
class URL extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * Get all this service provider provides.
     *
     * @return array
     */
    public function provides()
    {
        return ['url'];
    }

    /**
     * {@inheridoc}.
     */
    public function boot()
    {
        $url = resolve('url');
        $url->setDI($this->getDI());
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        if ($this->getDI()->has('url')) {
            $this->getDI()->remove('url');
        }

        $this->app->singleton('url', function () {
            return new BaseURL();
        });
    }
}
