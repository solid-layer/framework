<?php
/**
 * PhalconSlayer\Framework
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phalconslayer.readme.io
 */

/**
 * @package Clarity
 * @subpackage Clarity\Providers
 */
namespace Clarity\Providers;

class Cache extends ServiceProvider
{
    protected $alias = 'cache';
    protected $shared = false;

    private function getSelectedAdapter()
    {
        return config()->app->cache_adapter;
    }

    public function register()
    {
        $adapter = config()->cache->adapters->{$this->getSelectedAdapter()};

        $backend  = $adapter->backend;
        $frontend = $adapter->frontend;

        $front_cache = new $frontend([
            'lifetime' => $adapter->lifetime,
        ]);

        return new $backend($front_cache, $adapter->options->toArray());
    }
}
