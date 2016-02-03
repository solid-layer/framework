<?php
namespace Clarity;

use Clarity\Providers\Log;
use Clarity\Services\Service\ServiceContainer;

class Kernel
{
    use KernelTrait;

    private $di;
    private $app;
    private $path;
    private $modules;

    public function initialize()
    {
        $this->loadFactory();

        $this->loadConfig();

        $this->loadTimeZone();

        $this->loadServices();

        $this->di->set('app', function() {
            return $this->app;
        });
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
     * Register modules
     *
     * @return mixed
     */
    public function modules()
    {
        $this->app->registerModules($this->modules);

        return $this;
    }

    /**
     * Render the system content
     */
    public function render()
    {
        echo $this->app->handle()->getContent();
    }

    /**
     * Here, you will be loading the system by defining the module
     *
     * @param  string $module_name The module name
     * @return mixed
     */
    public function run($module_name)
    {
        $this->app->setDefaultModule($module_name);

        $path = url_trimmer(config()->path->app.'/'.$module_name.'/routes.php');

        if ( file_exists($path) ) {
            require $path;
        }

        $this->loadServices($after_module = true);

        return $this;
    }
}
