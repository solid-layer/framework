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
    /**
     * {@inheridoc}.
     */
    protected $alias = 'queue';

    /**
     * {@inheridoc}.
     */
    protected $shared = false;

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $adapter = config()->queue->{$this->getSelectedAdapter()}->toArray();

        $class = $adapter['class'];
        $config = $adapter['config'];

        return new BaseQueue(new $class($config));
    }

    /**
     * Get the selected queuing adapter.
     *
     * @return string
     */
    protected function getSelectedAdapter()
    {
        return config()->app->queue_adapter;
    }
}
