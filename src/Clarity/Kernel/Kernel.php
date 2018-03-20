<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Kernel;

/**
 * Acts like a manager that initializes all the configurations/environments and module.
 */
class Kernel
{
    use KernelTrait;

    /**
     * The dependency injection.
     *
     * @var \Phalcon\DiInterface
     */
    private $di;

    /**
     * The configured environment.
     *
     * @var string
     */
    private $env;

    /**
     * The path provided.
     *
     * @var mixed
     */
    private $paths;

    /**
     * Set the paths.
     *
     * @param mixed $paths
     * @return \Clarity\Kernel\Kernel
     */
    public function setPaths($paths)
    {
        $this->paths = $paths;

        if (is_cli()) {
            resolve('benchmark')->here('Setting Paths');
        }

        return $this;
    }

    /**
     * Set the environment.
     *
     * @param string $env
     * @return \Clarity\Kernel\Kernel
     */
    public function setEnvironment($env)
    {
        $this->env = $env;

        if (is_cli()) {
            resolve('benchmark')->here('Setting Environment');
        }

        return $this;
    }

    /**
     * Get the environment.
     *
     * @return string Current environment
     */
    public function getEnvironment()
    {
        return $this->env;
    }

    /**
     * Register modules.
     *
     * @return mixed
     */
    public function modules()
    {
        config(['modules' => $this->di->get('module')->all()]);

        $this->di->get('application')->registerModules(config()->modules->toArray());

        if (is_cli()) {
            resolve('benchmark')->here('Registering All Modules');
        }

        return $this;
    }

    /**
     * Render the system content.
     */
    public function render()
    {
        echo $this->di->get('application')->handle()->getContent();
    }

    /**
     * Here, you will be loading the system by defining the module.
     *
     * @param  string $module_name The module name
     * @return mixed
     */
    public function run($module_name)
    {
        $this->di->get('application')->setDefaultModule($module_name);

        $this->di->get($module_name)->afterModuleRun();

        return $this;
    }
}
