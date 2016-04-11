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

use Clarity\Providers\Log;
use Clarity\Services\Service\ServiceContainer;

class Kernel
{
    use KernelTrait;

    private $di;
    private $env;
    private $path;
    private $modules;

    public function initialize()
    {
        $this->loadFactory();

        $this->loadConfig();

        $this->loadTimeZone();

        $this->loadServices();
    }

    /**
     * Set the path
     *
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Set the modules
     *
     * @param mixed $modules
     */
    public function setModules($modules)
    {
        $this->modules = $modules;

        return $this;
    }

    /**
     * Set the environment
     *
     * @param string $env
     */
    public function setEnvironment($env)
    {
        $this->env = $env;

        return $this;
    }

    public function getEnvironment()
    {
        return $this->env;
    }

    /**
     * Register modules
     *
     * @return mixed
     */
    public function modules()
    {
        config(['modules' => $this->modules]);

        di()->get('application')->registerModules(config()->modules->toArray());

        return $this;
    }

    /**
     * Render the system content
     */
    public function render()
    {
        echo di()->get('application')->handle()->getContent();
    }

    /**
     * Here, you will be loading the system by defining the module
     *
     * @param  string $module_name The module name
     * @return mixed
     */
    public function run($module_name)
    {
        di()->get('application')->setDefaultModule($module_name);

        $path = url_trimmer(config()->path->app.'/'.$module_name.'/routes.php');

        if ( file_exists($path) ) {
            require $path;
        }

        $this->loadServices($after_module = true);

        return $this;
    }
}
