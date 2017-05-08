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
        $this->providers[] = $provider;

        return $this;
    }

    /**
     * Register a binding in static way.
     * 
     * @param  [type]
     * @param  [type]
     * @return [type]
     */
    public static function registerBinding($di, $alias, $binding)
    {
        $di->set(
            $alias, 
            call_user_func_array($binding['callback'], [$binding['instance']]), 
            $binding['singleton']
        );
    }

    /**
     * Register normal bindings.
     * 
     * @param  array $bindings
     * @return void
     */
    public function registerNormalBindings($bindings = [])
    {
        foreach ($bindings as $alias => $binding) {
            static::registerBinding($this->_di, $alias, $binding);
        }
    }

    /**
     * Register deffered bindings.
     * 
     * @param  array $bindings
     * @return void
     */
    public function registerDefferedBindings($bindings = [])
    {
        $providers = [];

        if ($this->_di->has('deffered.providers')) {
            $providers = $this->_di->get('deffered.providers');
        }

        $providers = array_merge($providers, $bindings);

        $this->_di->set('deffered.providers', function () use ($providers) {
            return $providers;
        }, $singleton = true);
    }

    /**
     * Loads all services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->providers as $provider) {
            # check if module function exists
            if (method_exists($provider, 'module')) {
                $this->getDI()->get('module')->setModule(
                    $provider->getAlias(),
                    function ($di) use ($provider) {
                        call_user_func_array([$provider, 'module'], [$di]);
                    }
                );
            }

            # call the register function to load everything
            if ($register = $provider->callRegister()) {
                $this->_di->set(
                    $provider->getAlias(),
                    $register,
                    $provider->getShared()
                );
            }

            # register normal bindings
            $this->registerNormalBindings(
                $provider->getNormalBindings()
            );

            # register deffered bindings
            if ($provider->isDeffered()) {
                $this->registerDefferedBindings(
                    $provider->getDefferedBindings()
                );
            }
        }

        # this happens when some application services relies on other service,
        # iterate the loaded providers and call the boot() function
        foreach ($this->providers as $provider) {
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
