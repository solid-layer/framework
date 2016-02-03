<?php
namespace Clarity\Providers;

class Session extends ServiceProvider
{
    protected $alias  = 'session';
    protected $shared = false;

    protected function getSelectedAdapter()
    {
        return config()->app->session_adapter;
    }

    public function register()
    {
        $adapter = config()->session->{$this->getSelectedAdapter()}->toArray();

        $config = [];
        $class = $adapter['class'];

        if ( isset($adapter['config']) ) {
            $config = $adapter['config'];
        }

        $session = new $class($config);
        session_name(config()->app->session);
        $session->start();

        return $session;
    }
}
