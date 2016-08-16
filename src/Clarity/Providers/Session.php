<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

/**
 */
namespace Clarity\Providers;

/**
 * This provider handles the available session adapters, wherein it manages
 * the user's activity or browser's unique session id.
 */
class Session extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    protected $alias = 'session';

    /**
     * {@inheridoc}.
     */
    protected $shared = false;

    /**
     * Get the selected session adapter.
     *
     * @return string
     */
    protected function getSelectedAdapter()
    {
        return config()->app->session_adapter;
    }

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $adapter = config()->session->{$this->getSelectedAdapter()}->toArray();

        $options = [];
        $class = $adapter['class'];

        if (isset($adapter['options'])) {
            $options = $adapter['options'];
        }

        $session = new $class($options);
        $session->setName(config()->app->session);
        $session->start();

        return $session;
    }
}
