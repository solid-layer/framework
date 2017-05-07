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
 * This provider handles the available session adapters, wherein it manages
 * the user's activity or browser's unique session id.
 */
class Session extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $this->app->singleton('session.selected_adapter', function () {
            $selected_adapter = config()->app->session_adapter;

            return config()->session->{$selected_adapter};
        });

        $this->app->singleton('session', function ($app) {
            $adapter = $app->make('session.selected_adapter')->toArray();

            $options = [];
            $class = $adapter['class'];

            if (isset($adapter['options'])) {
                $options = $adapter['options'];
            }

            $session = new $class($options);
            $session->setName(config()->app->session);
            $session->start();

            return $session;
        });
    }
}
