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
namespace Clarity\Services;

use Clarity\Providers\ServiceProvider;

class Container
{
    private $providers;

    public function addServiceProvider(ServiceProvider $provider)
    {
        $this->providers[] = $provider;

        return $this;
    }

    /**
     * Loads all services.
     *
     * return void
     */
    public function boot()
    {
        $providers_loaded = array_map(function ($provider) {

            # check if module function exists
            if (method_exists($provider, 'module')) {
                di('module')->setModule(
                    $provider->getAlias(),
                    function ($di) use ($provider) {
                        call_user_func_array([$provider, 'module'], [$di]);
                    }
                );
            }

            # callRegister should return an empty or an object or array
            # then we could manually update the register
            if ($register = $provider->callRegister()) {
                di()->set(
                    $provider->getAlias(),
                    $register,
                    $provider->getShared()
                );
            }

            return $provider;
        }, $this->providers);

        # this happens when some application services relies on other service,
        # iterate the loaded providers and call the boot() function
        foreach ($providers_loaded as $provider) {
            $boot = $provider->boot();

            if ($boot && ! di()->has($provider->getAlias())) {
                di()->set(
                    $provider->getAlias(),
                    $boot,
                    $provider->getShared()
                );
            }
        }
    }
}
