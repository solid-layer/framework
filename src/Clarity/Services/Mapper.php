<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Services;

use RuntimeException;
use Phalcon\DiInterface;
use Phalcon\Di\InjectionAwareInterface;

trait Mapper
{
    /**
     * @var array
     */
    private $bindings = [];

    /**
     * @var array
     */
    private $deferred = [];

    /**
     * Get all bindings.
     * 
     * @return array
     */
    public function getNormalBindings()
    {
        return $this->bindings;
    }

    /**
     * Get all deferred bindings.
     * 
     * @return array
     */
    public function getDeferredBindings()
    {
        return $this->deferred;
    }

    /**
     * Get the binding property to use.
     * 
     * @return string
     */
    protected function getBindingPropertyToUse()
    {
        if ($this->isDeferred()) {
            return 'deferred';
        }

        return 'bindings';
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
        $this->{$this->getBindingPropertyToUse()}[$alias] = [
            'callback' => $provider,
            'instance' => $this,
            'singleton' => false,
        ];
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
        $this->{$this->getBindingPropertyToUse()}[$alias] = [
            'callback' => $callback,
            'instance' => $this,
            'singleton' => true,
        ];
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
        $this->{$this->getBindingPropertyToUse()}[$alias] = [
            'callback' => function () use ($instance) {
                return $instance;
            },
            'instance' => $this,
            'singleton' => $singleton,
        ];
    }

    /**
     * Get the instance based on the alias.
     *
     * @param string $alias
     * @return mixed
     */
    public function make($alias)
    {
        if (! $this->_di->has($alias)) {
            static::resolveBinding($this->_di, $alias);
        }

        return $this->_di->get($alias);
    }

    /**
     * Resolve a provider in static way.
     *
     * @param string $alias
     * @return mixed
     */
    public static function resolveBinding($di, $alias)
    {
        if (! $di->has('deferred.providers')) {
            throw new RuntimeException('Service [deferred.providers] not found.');
        }

        # get all deferred providers
        $providers = $di->get('deferred.providers');

        # get the first alias that provides
        # so we could pre-load other keys
        if (! isset($providers[$alias]['instance'])) {
            throw new RuntimeException('Method [provides] not found on provider ['.$alias.']');
        }

        $aliases_to_load = ($providers[$alias]['instance'])->provides();

        foreach ($aliases_to_load as $alias) {
            $binding = $providers[$alias];

            \Clarity\Services\Container::registerBinding(
                $di,
                $alias,
                $binding
            );
        }
    }

    /**
     * Resolve a provider.
     *
     * @param string $alias
     * @return mixed
     */
    public function resolve($alias)
    {
        return static::resolveBinding($this->_di, $alias);
    }

    /**
     * Apply an alias in static way
     *
     * @param string $class
     * @param string $alias
     * @return void
     */
    public static function classAlias($class, $alias)
    {
        class_alias($class, $alias);
    }

    /**
     * Apply an alias.
     *
     * @param string $class
     * @param string $alias
     * @return void
     */
    public function alias($class, $alias)
    {
        static::classAlias($class, $alias);
    }
}
