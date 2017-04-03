<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

use League\Flysystem\Filesystem;
use League\Flysystem\MountManager;

/**
 * This provider manages all available file system adapters such as local, aws
 * copy, ftp, rackspace and more.
 */
class Flysystem extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    protected $alias = 'flysystem';

    /**
     * {@inheridoc}.
     */
    protected $shared = true;

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $manager = $this->manager();

        di()->set('flysystem_manager', function () use ($manager) {
            return $manager;
        }, true);

        return $manager->getFilesystem(config()->app->flysystem);
    }

    /**
     * This manages all the available file system adapters.
     *
     * @return \League\Flysystem\MountManager
     */
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
