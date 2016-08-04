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
namespace Clarity\Console\App;

use Clarity\Console\Brood;
use Symfony\Component\Console\Input\InputArgument;

/**
 * A console command that generate a set of module.
 */
class ModuleCommand extends Brood
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'app:module';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Generate a new module';

    /**
     * Get the application path.
     *
     * @return string
     */
    protected function getAppPath()
    {
        return config()->path->app;
    }

    /**
     * Get the public path.
     *
     * @return string
     */
    protected function getPublicPath()
    {
        return config()->path->public;
    }

    /**
     * Get the base path.
     *
     * @return string
     */
    protected function getBasePath()
    {
        return realpath('');
    }

    /**
     * Get the namespace to use.
     *
     * @return string
     */
    protected function getNamespace()
    {
        return url_trimmer(
            $this->getAppPath().'/'.$this->getModuleName().'\\Controllers'
        );
    }

    /**
     * Get the module name.
     *
     * @return string
     */
    protected function getModuleName()
    {
        return $this->input->getArgument('name');
    }

    /**
     * Get the base controller content stub.
     *
     * @return string
     */
    protected function getBaseControllerStub()
    {
        return file_get_contents(__DIR__.'/stubs/baseController.stub');
    }

    /**
     * Get the base route content stub.
     *
     * @return string
     */
    protected function getBaseRouteStub()
    {
        return file_get_contents(__DIR__.'/stubs/baseRoute.stub');
    }

    /**
     * Get the base public index content stub.
     *
     * @return string
     */
    protected function getPublicStub()
    {
        return file_get_contents(__DIR__.'/stubs/publicIndex.stub');
    }

    /**
     * Get the routes content stub.
     *
     * @return string
     */
    protected function getRoutesStub()
    {
        return "<?php\n";
    }

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $app_filesystem = flysystem_manager($this->getAppPath());
        $public_filesystem = flysystem_manager($this->getPublicPath());

        # get the module name
        $module = $this->getModuleName();

        $this->info('Crafting Module...');

        $controller_buff = $this->getContentByStub($this->getBaseControllerStub());
        $router_buff = $this->getContentByStub($this->getBaseRouteStub());
        $routes_buff = $this->getContentByStub($this->getRoutesStub());
        $public_buff = stubify($this->getPublicStub(), ['module' => '\''.$module.'\'']);

        # their possible path
        $base_controller = "$module/controllers/Controller.php";
        $base_router = "$module/routes/RouteGroup.php";
        $routes_file = "$module/routes.php";
        $public_file = $module.'.php';

        # now save the stubbed content into the their path
        if ($app_filesystem->has($base_controller) === false) {
            $this->info('   Base Controller created!');
            $app_filesystem->put($base_controller, $controller_buff);
        } else {
            $this->error('   Base Controller already exists!');
        }

        if ($app_filesystem->has($base_router) === false) {
            $this->info('   Router Group created!');
            $app_filesystem->put($base_router, $router_buff);
        } else {
            $this->error('   Route Group already exists!');
        }

        if ($app_filesystem->has($routes_file) === false) {
            $this->info('   Routes file created!');
            $app_filesystem->put($routes_file, $routes_buff);
        } else {
            $this->error('   Routes file already exists!');
        }

        if ($public_filesystem->has($public_file) === false) {
            $this->info('   Public Index created!');
            $public_filesystem->put($public_file, $public_buff);
        } else {
            $this->error('   Public Index already exists!');
        }

        $this->callDumpAutoload();
    }

    /**
     * Get the content with 'namespace' by stubifying the
     * provided content.
     *
     * @param $stub_content
     * @return string
     */
    private function getContentByStub($stub_content)
    {
        return stubify(
            $stub_content,
            [
                'namespace' => path_to_namespace(
                    # here, we must trim the $namespace by
                    # getting the base path to be our matching trimmer
                    str_replace($this->getBasePath(), '', $this->getNamespace())
                ),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function arguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The module name'],
        ];
    }
}
