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
        return getcwd();
    }

    /**
     * Get the namespace to use.
     *
     * @return string
     */
    protected function getNamespace()
    {
        return url_trimmer(
            realpath($this->getAppPath()).'/'.$this->getModuleName()
        );
    }

    /**
     * Get the module name.
     *
     * @return string
     */
    protected function getModuleName($namespace = true)
    {
        $name = $this->input->getArgument('name');

        if (! $namespace) {
            return $name;
        }

        return studly_case(str_slug($name, '_'));
    }

    /**
     * Get the base controller content stub.
     *
     * @return string
     */
    protected function getBaseControllerStub()
    {
        return file_get_contents(__DIR__.'/stubs/module/base_controller.stub');
    }

    /**
     * Get the base route content stub.
     *
     * @return string
     */
    protected function getBaseRouteStub()
    {
        return file_get_contents(__DIR__.'/stubs/module/base_route.stub');
    }

    /**
     * Get the base route provider content stub.
     *
     * @return string
     */
    protected function getBaseRouteProviderStub()
    {
        return file_get_contents(__DIR__.'/stubs/module/base_route_provider.stub');
    }

    /**
     * Get the base public index content stub.
     *
     * @return string
     */
    protected function getPublicStub()
    {
        return file_get_contents(__DIR__.'/stubs/module/index.stub');
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
        $raw_module = $this->getModuleName(false);
        $module = $this->getModuleName();

        $this->info('Crafting Module...');

        $controller_buff = $this->getContentByStub($this->getBaseControllerStub(), 'Controller');
        $routes_group_buff = $this->getContentByStub($this->getBaseRouteStub(), 'Routes');
        $routes_buff = $this->getContentByStub($this->getRoutesStub());
        $public_buff = stubify($this->getPublicStub(), ['module' => '\''.$module.'\'']);

        $base_route_provider_buff = $this->getContentByStub(
            $this->getBaseRouteProviderStub(),
            'Providers'
        );
        $base_route_provider_buff = stubify($base_route_provider_buff, [
            'raw_module' => $raw_module,
            'module' => $module,
        ]);

        # their possible path
        $base_controller = "$module/Controllers/Controller.php";
        $base_routes = "$module/Routes/RouteGroup.php";
        $routes_file = "$module/Routes.php";
        $public_file = $raw_module.'.php';
        $base_route_provider = "$module/Providers/RouteServiceProvider.php";

        # now save the stubbed content into the their path
        if ($app_filesystem->has($base_controller) === false) {
            $this->info('   Base Controller created!');
            $app_filesystem->put($base_controller, $controller_buff);
        } else {
            $this->error('   Base Controller already exists!');
        }

        if ($app_filesystem->has($base_routes) === false) {
            $app_filesystem->put($base_routes, $routes_group_buff);
            $this->info('   Route Group created!');
        } else {
            $this->error('   Route Group already exists!');
        }

        if ($app_filesystem->has($routes_file) === false) {
            $app_filesystem->put($routes_file, $routes_buff);
            $this->info('   Routes file created!');
        } else {
            $this->error('   Routes file already exists!');
        }

        if ($public_filesystem->has($public_file) === false) {
            $public_filesystem->put($public_file, $public_buff);
            $this->info('   Public file created!');
        } else {
            $this->error('   Public Index already exists!');
        }

        if ($app_filesystem->has($base_route_provider) === false) {
            $app_filesystem->put($base_route_provider, $base_route_provider_buff);
            $this->info('   Route Service created!');
        } else {
            $this->error('   Route Service already exists!');
        }

        $this->getOutput()->writeln(
            "\n".'   <comment>Append route service inside [config/app.php]: </comment>'.
            path_to_namespace(
                str_replace($this->getBasePath(), '', $this->getNamespace()).'/Providers/RouteServiceProvider'
            ).'::class'
        );
    }

    /**
     * Get the content with 'namespace' by stubifying the
     * provided content.
     *
     * @param $stub_content
     * @return string
     */
    private function getContentByStub($stub_content, $folder = null)
    {
        return stubify(
            $stub_content,
            [
                'namespace' => path_to_namespace(
                    # here, we must trim the $namespace by
                    # getting the base path to be our matching trimmer
                    str_replace($this->getBasePath(), '', $this->getNamespace().'/'.$folder)
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
