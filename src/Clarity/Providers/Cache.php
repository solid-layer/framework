<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

/**
 * This provider manages the cache drivers.
 */
class Cache extends ServiceProvider
{
    protected $defer = true;

    /**
     * Get the selected cache adapter.
     *
     * @return string
     */
    private function getSelectedAdapter()
    {
        return config()->app->cache_adapter;
    }

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $this->app->singleton('cache', function () {
            $adapter = config()->cache->adapters->{$this->getSelectedAdapter()};

            $backend = $adapter->backend;
            $frontend = $adapter->frontend;

            $front_cache = new $frontend([
                'lifetime' => $adapter->lifetime,
            ]);

            return new $backend($front_cache, $adapter->options->toArray());
        });
    }

    public function provides()
    {
        return ['cache'];
    }
}
