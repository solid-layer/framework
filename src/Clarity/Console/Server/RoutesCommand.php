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
namespace Clarity\Console\Server;

use Clarity\Console\Brood;
use Clarity\Kernel\Kernel;
use Clarity\Facades\Route;

/**
 * A console command to show lists of registered routes.
 */
class RoutesCommand extends Brood
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'routes';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Get registered routes';

    /**
     * Format the route
     *
     * @return array
     */
    protected function formattedRoute($route)
    {
        $paths = $route->getPaths();

        return [
            'verb' => $route->getHttpMethods() ?: '*any*',
            'pattern' => $route->getPattern(),
            'controller' => $paths['controller'].':'.$paths['action'],
            'name' => $route->getName(),
        ];
    }

    /**
     * Dig in the routes provided in the modules
     *
     * @return array
     */
    protected function extractRoutes($routes)
    {
        $tmp = [];
        $counter = 1;

        foreach ($routes as $route) {
            $tmp[] = $this->formattedRoute($route);

            if (count($routes) !== $counter++) {
                $tmp[] = null;
            }
        }

        return $tmp;
    }

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        foreach (di('module')->all() as $module_name => $module) {
            $path = Kernel::buildRoute($module_name);

            if (file_exists($path)) {
                require_once $path;
            }
        }

        $table = $this->table(
            ['Verb', 'Pattern', 'Path', 'Name'],
            $this->extractRoutes(Route::getRoutes())
        );

        $table->render();
    }
}
