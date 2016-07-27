<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phalconslayer.readme.io
 */

/**
 */
namespace Clarity\Services\Service;

use Clarity\Providers\ServiceProvider;

class ServiceContainer
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

            if (is_object($register = $provider->callRegister())) {
                di()->set(
                    $provider->getAlias(),
                    $register,
                    $provider->getShared()
                );
            }

            return $provider;
        }, $this->providers);

        foreach ($providers_loaded as $provider) {
            $provider->boot();
        }
    }
}
