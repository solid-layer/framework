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
     * @var mixed
     */
    private $di;

    /**
     * The configured environment.
     *
     * @var string
     */
    private $env;

    /**
     * The path/paths provided.
     *
     * @var mixed
     */
    private $path;

    /**
     * The modules pre-inserted.
     *
     * @var mixed
     */
    private $modules;

    /**
     * Set the path.
     *
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Set the modules.
     *
     * @param mixed $modules
     */
    public function setModules($modules)
    {
        $this->modules = $modules;

        return $this;
    }

    /**
     * Set the environment.
     *
     * @param string $env
     */
    public function setEnvironment($env)
    {
        $this->env = $env;

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
        config(['modules' => $this->modules]);

        di('application')->registerModules(config()->modules->toArray());

        return $this;
    }

    /**
     * Render the system content.
     */
    public function render()
    {
        echo di('application')->handle()->getContent();
    }

    /**
     * Here, you will be loading the system by defining the module.
     *
     * @param  string $module_name The module name
     * @return mixed
     */
    public function run($module_name)
    {
        di('application')->setDefaultModule($module_name);

        $path = url_trimmer(config()->path->app.'/'.$module_name.'/routes.php');

        if (file_exists($path)) {
            require $path;
        }

        $this->loadServices($after_module = true);

        return $this;
    }
}
