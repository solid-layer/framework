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

    /**
     * This handles the session file
     *
     * @param  mixed $config
     * @return void
     */
    protected function handleSessionFile($config)
    {
        if (is_cli()) {
            return;
        }

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
