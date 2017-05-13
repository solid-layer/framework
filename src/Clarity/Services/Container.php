<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Services;

use Clarity\Providers\ServiceProvider;
use Phalcon\DiInterface;
use Phalcon\Di\InjectionAwareInterface;

/**
 * The service container.
 */
class Container implements InjectionAwareInterface
{
    /**
     * @var \Phalcon\DiInterface
     */
    protected $_di;

    /**
     * @var array
     */
    private $providers = [];

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
     * Add a service provider.
     *
     * @param mixed|\Clarity\Providers\ServiceProvider $provider
     * @return mixed|\Clarity\Services
     */
    public function addServiceProvider(ServiceProvider $provider)
    {
        $this->providers[get_class($provider)] = $provider;

        return $this;
    }

    /**
     * Refresh a service provider.
     *
     * @param  array $classes
     * @return mixed|\Clarity\Services
     */
    public function refreshServiceProvider($classes = [])
    {
        $providers = array_map(function ($class) {
            return $this->providers[$class];
        }, $classes);

        $this->handle($providers);

        return $this;
    }

    /**
     * Register a binding in static way.
     *
     * @param  \Clarity\Support\Phalcon\Di $di
     * @param  string $alias
     * @param  array $binding
     * @param  \Clarity\Services\Mapper $mapper
     * @return void
     */
    public static function registerBinding($di, $alias, $binding, $mapper)
    {
        $di->set(
            $alias,
            call_user_func_array($binding['callback'], [$mapper]),
            $binding['singleton']
        );
    }

    /**
     * Register normal bindings.
     *
     * @param  array $bindings
     * @return void
     */
    public function registerNormalBindings($app)
    {
        foreach ($app->getNormalBindings() as $alias => $binding) {
            static::registerBinding($this->_di, $alias, $binding, $app);
        }
    }

    /**
     * Register deferred bindings.
     *
     * @param  array $bindings
     * @return void
     */
    public function registerDeferredBindings($app)
    {
        $providers = [];

        if ($this->_di->has('deferred.providers')) {
            $providers = $this->_di->get('deferred.providers');
        }

        $providers = array_merge($providers, $app->getDeferredBindings());

        $this->_di->set('deferred.providers', function () use ($providers) {
            return $providers;
        }, $singleton = true);
    }

    /**
     * Loads all services.
     *
     * @return void
     */
    public function handle($providers = [])
    {
        if (is_cli()) {
            resolve('benchmark')->label('Loading Service Providers');
            resolve('benchmark')->reset();
        }

        if (empty($providers)) {
            $providers = $this->providers;
        }

        foreach ($providers as $provider) {
            # call the register function to load everything
            if ($register = $provider->callRegister()) {
                $this->_di->set(
                    $provider->getAlias(),
                    $register,
                    $provider->getShared()
                );
            }

            # register deferred bindings
            if ($provider->app->isDeferred()) {
                $this->registerDeferredBindings($provider->app);
            } else {
                # register normal bindings
                $this->registerNormalBindings($provider->app);
            }

            if (is_cli()) {
                resolve('benchmark')->here('   - '.get_class($provider));
            }
        }

        # this happens when some application services relies on other service,
        # iterate the loaded providers and call the boot() function
        foreach ($providers as $provider) {
            $boot = $provider->boot();

            if ($boot && ! $this->_di->has($provider->getAlias())) {
                $this->_di->set(
                    $provider->getAlias(),
                    $boot,
                    $provider->getShared()
                );
            }
        }
    }
}
