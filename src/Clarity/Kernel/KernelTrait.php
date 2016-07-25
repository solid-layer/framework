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
 * @subpackage Clarity\Kernel
 */

namespace Clarity\Kernel;

use Dotenv\Dotenv;
use Phalcon\Config;
use Phalcon\Di\FactoryDefault;
use Clarity\Services\Service\ServiceContainer;

/**
 * A class trait of @see (Clarity\Kernel\Kernel)
 */
trait KernelTrait
{
    /**
     * Instantiate a factory dependency injection
     *
     * @return \Clarity\Kernel\Kernel
     */
    protected function loadFactory()
    {
        $this->di = new FactoryDefault;

        return $this;
    }

    /**
     * Load the configurations
     *
     * @return void
     */
    protected function loadConfig()
    {
        # let's create an empty config with just an empty
        # array, this is just for us to prepare the config
        $this->di->set('config', function () {
            return new Config([]);
        }, true);


        # get the paths and merge the array values to the
        # empty config as we instantiated above
        config(['path' => $this->path]);


        # now merge the assigned environment
        config(['environment' => $this->getEnvironment()]);


        # iterate all the base config files and require
        # the files to return an array values
        $base_config_files = iterate_require(
            folder_files($this->path['config'])
        );


        # iterate all the environment config files and
        # process the same thing as the base config files
        $env_config_files = iterate_require(
            folder_files(
                url_trimmer(
                    $this->path['config'].'/'.$this->getEnvironment()
                )
            )
        );


        # merge the base config files and the environment
        # config files as one in the our DI 'config'
        config($base_config_files);
        config($env_config_files);
    }

    /**
     * Load the project timezone
     *
     * @return void
     */
    protected function loadTimeZone()
    {
        date_default_timezone_set(config()->app->timezone);
    }

    /**
     * Load the providers
     *
     * @param  boolean $after_module If you want to load services after calling
     *                               run() function
     * @return void
     */
    protected function loadServices($after_module = false)
    {
        # load all the service providers, providing our
        # native phalcon classes
        $container = new ServiceContainer;

        foreach (config()->app->services as $provider) {
            $instance = new $provider;

            if ($instance->getAfterModule() == $after_module) {
                $container->addServiceProvider($instance);
            }
        }

        $container->boot();
    }
}
