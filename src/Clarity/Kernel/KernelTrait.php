<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Kernel;

use Phalcon\Di;
use Phalcon\Config;
use Clarity\Services\Container;

/**
 * The Kernel Trait.
 *
 * @see \Clarity\Kernel\Kernel
 * @property \Phalcon\DiInterface $di
 */
trait KernelTrait
{
    /**
     * Instantiate a factory dependency injection.
     *
     * @return $this
     */
    public function loadFactory()
    {
        $this->di = new Di;

        return $this;
    }

    /**
     * Load the configurations.
     *
     * @return $this
     */
    public function loadConfig()
    {
        # let's create an empty config with just an empty
        # array, this is just for us to prepare the config
        $this->di->setShared('config', function () {
            return new Config([]);
        });

        # get the paths and merge the array values to the
        # empty config as we instantiated above
        config(['path' => $this->paths]);

        # now merge the assigned environment
        config(['environment' => $this->getEnvironment()]);

        # iterate all the base config files and require
        # the files to return an array values
        $base_config_files = iterate_require(
            folder_files($this->paths['config'])
        );

        # iterate all the environment config files and
        # process the same thing as the base config files
        $env_config_files = iterate_require(
            folder_files(
                url_trimmer(
                    $this->paths['config'].'/'.$this->getEnvironment()
                )
            )
        );

        # merge the base config files and the environment
        # config files as one in the our DI 'config'
        config($base_config_files);
        config($env_config_files);

        return $this;
    }

    /**
     * Load the project timezone.
     *
     * @return $this
     */
    public function loadTimeZone()
    {
        date_default_timezone_set(config()->app->timezone);

        return $this;
    }

    /**
     * Load the providers.
     *
     * @param  bool $after_module If you want to load services after calling
     *                               run() function
     * @return $this
     */
    public function loadServices($after_module = false, $services = [])
    {
        # load all the service providers, providing our
        # native phalcon classes
        $container = new Container;

        if (empty($services)) {
            $services = config()->app->services;
        }

        foreach ($services as $service) {
            $instance = new $service;

            if ($instance->getAfterModule() === $after_module) {
                $container->addServiceProvider($instance);
            }
        }

        $container->boot();

        return $this;
    }
}
