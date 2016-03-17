<?php
namespace Clarity\Providers;

use Phalcon\Session\Adapter\Files as SessionFile;

class Session extends ServiceProvider
{
    protected $alias = 'session';
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

        switch ($adapter['class']) {
            case SessionFile::class:
                $this->handleSessionFile($adapter['config']);
            break;
        }

        $session->start();

        return $session;
    }

    protected function handleSessionFile($config)
    {
        $session_path = url_trimmer(config()->path->storage.'/session');

        session_save_path($session_path);

        session_set_cookie_params(
            $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            $config['httponly']
        );
    }
}
