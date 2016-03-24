<?php
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

    public function boot()
    {
        $providers_loaded = array_map(function ($provider) {
            di()->set(
                $provider->getAlias(),
                $provider->callRegister(),
                $provider->getShared()
            );

            return $provider;
        }, $this->providers);

        foreach ($providers_loaded as $provider) {
            $provider->boot();
        }
    }
}
