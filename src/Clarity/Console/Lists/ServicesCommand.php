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
namespace Clarity\Console\Lists;

use Clarity\Console\Brood;

/**
 *
 */
class ServicesCommand extends Brood
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'list:services';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Get registered services';

    /**
     * Format the service.
     *
     * @return array
     */
    protected function formattedService($route)
    {
        $paths = $route->getPaths();

        return [
            'method'        => $route->getHttpMethods() ?: '*any*',
            'path'          => $route->getPattern(),
            'controller'    => $paths['controller'],
            'action'        => $paths['action'],
            'assigned_name' => $route->getName(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $services = [];

        foreach (di()->getServices() as $idx => $service) {
            $services[$idx]['name'] = $service->getName();
            $services[$idx]['shared'] = $service->isShared() ? 'Yes' : 'No';
            $services[$idx]['class'] = null;

            if ($service->isResolved()) {
                $services[$idx]['class'] = get_class($service->getDefinition());
            } elseif ($service->resolve()) {
                $services[$idx]['class'] = get_class($service->resolve());
            }
        }

        sort($services);

        $table = $this->table(
            ['Name', 'Shared', 'Class'],
            $services
        );

        $table->render();
    }
}
