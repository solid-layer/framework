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
 * @subpackage Clarity\Providers
 */
namespace Clarity\Providers;

use League\Flysystem\Filesystem;
use League\Flysystem\MountManager;

class Flysystem extends ServiceProvider
{
    protected $alias = 'flysystem';
    protected $shared = true;

    public function register()
    {
        $manager = $this->manager();

        di()->set('flysystem_manager', function() use ($manager) {
            return $manager;
        }, true);

        return $manager->getFilesystem(config()->app->flysystem);
    }

    protected function manager()
    {
        $flies = [];

        foreach (config()->flysystem as $prefix => $fly) {
            $instance = new $fly['class']($fly['config']->toArray());

            $flies[$prefix] = new Filesystem($instance->getAdapter());
        }

        return new MountManager($flies);
    }
}
