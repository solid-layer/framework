<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Services;

use Phalcon\DiInterface;
use Phalcon\Di\InjectionAwareInterface;

class Mapper implements InjectionAwareInterface
{
    /**
     * @var \Phalcon\DiInterface
     */
    protected $_di;

    /**
     * {@inheritdoc}
     */
    public function setDI(DiInterface $di)
    {
        $this->_di = $di;
    }

    /**
     * {@inheritdoc}
     */
    public function getDI()
    {
        return $this->_di;
    }

    /**
     * A default way to bind providers.
     *
     * @param string $alias
     * @param mixed|string $provider
     * @return void
     */
    public function bind($alias, $provider)
    {
        $this->_di->set(
            $alias,
            call_user_func($provider, $this),
            $shared = false
        );
    }

    /**
     * Shared or the so called singleton.
     *
     * @param string $alias
     * @param mixed $callback
     * @return void
     */
    public function singleton($alias, $callback)
    {
        $this->_di->set(
            $alias,
            call_user_func($callback, $this),
            $shared = true
        );
    }

    /**
     * Instance with subsequent calls.
     *
     * @param string $alias
     * @param mixed $instance
     * @param bool $singleton
     * @return void
     */
    public function instance($alias, $instance, $singleton = false)
    {
        $this->_di->set(
            $alias,
            function () use ($instance) {
                return $instance;
            },
            $singleton = false
        );
    }

    /**
     * Get the instance based on the alias.
     *
     * @param string $alias
     * @return mixed
     */
    public function make($alias)
    {
        return $this->_di->get($alias);
    }
}
