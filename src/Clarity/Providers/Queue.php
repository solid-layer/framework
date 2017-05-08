<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

use Clarity\Support\Queue\Queue as BaseQueue;

/**
 * This provider manages the available queue adapters and creates/instantiate in it.
 *
 * Activities like processing videos, resizing images or sending emails aren’t
 * suitable to be executed online or in real time because it may slow the
 * loading time of pages and severely impact the user experience.
 */
class Queue extends ServiceProvider
{
    protected $deffer = true;

    public function provides()
    {
        return ['queue.selected_adapter', 'queue'];
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton('queue.selected_adapter', function () {
            $selected_adapter = config()->app->queue_adapter;

            return config()->queue->{$selected_adapter};
        });

        $this->app->singleton('queue', function ($app) {
            $adapter = $app->make('queue.selected_adapter');

            $class = $adapter->class;
            $config = $adapter->config->toArray();

            return new BaseQueue(new $class($config));
        });
    }
}
