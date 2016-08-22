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
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * A console command that generates a route template.
 */
class RouteCommand extends Brood
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'app:route';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Generate a new route group';

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
     * Get the module path.
     *
     * @return string
     */
    protected function getModulePath()
    {
        return url_trimmer($this->getAppPath().'/'.$this->getModuleName());
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
    protected function getNamespace($folder = 'Routes')
    {
        return url_trimmer(
            realpath($this->getAppPath()).'/'.$this->getModuleName().'/'.$folder
        );
    }

    /**
     * Get the route name.
     *
     * @param $is_path
     * @return string
     */
    protected function getRouteName($is_path = true)
    {
        $ret = '%s';

        if ($is_path) {
            $ret = 'Routes/%sRoutes.php';
        }

        return sprintf(
            $ret,
            studly_case(
                str_slug($this->input->getArgument('name'), '_')
            )
        );
    }

    /**
     * Get the module name.
     *
     * @return string
     */
    protected function getModuleName($namespace = true)
    {
        $module = $this->input->getArgument('module');

        if (! $namespace) {
            return $module;
        }

        return studly_case(str_slug($module, '_'));
    }

    /**
     * Get the route content stub.
     *
     * @return string
     */
    protected function getRouteStub()
    {
        return file_get_contents(__DIR__.'/stubs/route/route.stub');
    }

    /**
     * Get the functions content stub.
     *
     * @return string
     */
    protected function getFunctionsStub()
    {
        return file_get_contents(__DIR__.'/stubs/route/functions.stub');
    }

    /**
     * Get the route functions.
     *
     * @return string
     */
    protected function getRouteFunctions()
    {
        if ($this->input->getOption('emptify')) {
            return '';
        }

        return stubify(
            $this->getFunctionsStub(),
            [
                'routeName' => $this->getRouteName(false),
                'controllerNamespace' => path_to_namespace(
                    str_replace($this->getBasePath(), '', $this->getNamespace('Controllers'))
                ),
                'prefixRouteName' => strtolower($this->getInput()->getArgument('name')),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $app_filesystem = flysystem_manager($this->getAppPath());

        $raw_module = $this->getModuleName(false);
        $module = $this->getModuleName();

        # check if module exists, throw error if it doesn't exists
        if ($app_filesystem->has($module) === false) {
            $this->error("Module [$module] not found");

            return;
        }

        $this->info('Crafting Route Group...');

        $route = $this->getRouteName();
        # check route file if exists, throw error if exists
        if ($app_filesystem->has($module.'/'.$route)) {
            $this->error(
                "     Route [{$this->input->getArgument('name')}] ".
                "already exists in your Module [{$this->input->getArgument('module')}]"
            );

            return;
        }

        # get the route stub and stubify the {routeName}
        # based on argument route name
        $buff = stubify(
            $this->getRouteStub(),
            [
                'namespace' => path_to_namespace(
                    # here, we must trim the $namespace by
                    # getting the base path to be our matching trimmer
                    str_replace($this->getBasePath(), '', $this->getNamespace())
                ),
                'routeName' => $this->getRouteName(false),
                'routeFunctions' => $this->getRouteFunctions(),
            ]
        );

        # now write the content based on $route path
        $module_filesystem = flysystem_manager($this->getModulePath());
        $module_filesystem->put($route, $buff);

        $this->info('     '.$route.' created!');
    }

    /**
     * {@inheritdoc}
     */
    protected function arguments()
    {
        $arguments = [
            ['name', InputArgument::REQUIRED, 'The route name'],
            ['module', InputArgument::REQUIRED, 'The module to link on'],
        ];

        return $arguments;
    }

    /**
     * {@inheritdoc}
     */
    protected function options()
    {
        return [
            [
                'emptify',
                null,
                InputOption::VALUE_NONE,
                'Remove all pre-defined functions',
            ],
        ];
    }
}
