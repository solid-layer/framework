<?php
namespace Clarity;

use Dotenv\Dotenv;
use Phalcon\Config;
use Phalcon\Mvc\Application;
use Clarity\Facades\Facade;
use Phalcon\Di\FactoryDefault;
use Clarity\Services\Service\ServiceContainer;

trait KernelTrait
{
    protected function loadFactory()
    {
        $this->di = new FactoryDefault;

        $this->app = new Application($this->di);

        return $this;
    }

    protected function loadConfig()
    {
        # - let's create an empty config with just an empty
        # array, this is just for us to prepare the config

        $this->di->set('config', function() {
            return new Config([]);
        }, true);


        # - get the paths and merge the array values to the
        # empty config as we instantiated above

        $this->di->get('config')->merge( new Config(['path' => $this->path]) );


        # - iterate all the base config files and require
        # the files to return an array values

        $base_config_files = iterate_require(
            folder_files($this->path['config'])
        );


        # - iterate all the environment config files and
        # process the same thing as the base config files

        $env_config_files  = iterate_require(
            folder_files(
                url_trimmer(
                    $this->path['config'].'/'.env('APP_ENV', '')
                )
            )
        );


        # - merge the base config files and the environment
        # config files as one in the our DI 'config'

        config()->merge( new Config($base_config_files) );
        config()->merge( new Config($env_config_files) );
    }

    protected function loadTimeZone()
    {
        date_default_timezone_set(
            di()->get('config')->app->timezone
        );
    }

    protected function loadServices($after_module = false)
    {
        # - load our global facade class to handle singleton
        # like access

        Facade::setFacadeApplication($this->app);


        # - load all the service providers, providing our
        # native phalcon classes

        $container = new ServiceContainer;

        foreach (config()->app->services as $provider) {

            $instance = new $provider;

            if ( $instance->getAfterModule() == $after_module ) {
                $container->addServiceProvider($instance);
            }
        }

        $container->boot();
    }

}
