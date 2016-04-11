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

class Queue extends ServiceProvider
{
    protected $alias = 'queue';
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
