<?php
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
