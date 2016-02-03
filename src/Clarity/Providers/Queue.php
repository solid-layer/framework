<?php
namespace Clarity\Providers;

class Queue extends ServiceProvider
{
    protected $alias  = 'queue';
    protected $shared = false;

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $adapter = config()->queue->{$this->getSelectedAdapter()}->toArray();

        $class = $adapter['class'];
        $config = $adapter['config'];

        return new $class($config);
    }

    protected function getSelectedAdapter()
    {
        return config()->app->queue_adapter;
    }
}
