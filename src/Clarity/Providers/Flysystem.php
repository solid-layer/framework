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
    protected $defer = true;

    public function provides()
    {
        return ['flysystem_manager', 'flysystem'];
    }

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $this->app->singleton('flysystem_manager', function () {
            $flies = [];

            foreach (config('flysystem') as $prefix => $fly) {
                $instance = new $fly['class']($fly['config']->toArray());

                $flies[$prefix] = new Filesystem($instance->getAdapter());
            }

            return new MountManager($flies);
        });

        $this->app->singleton('flysystem', function ($app) {
            return $app->make('flysystem_manager')
                ->getFilesystem(config('app.flysystem'));
        });
    }
}
