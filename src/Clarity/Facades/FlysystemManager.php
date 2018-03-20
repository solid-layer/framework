<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Facades;

/**
 * This is the facade calling the alias 'flysystem_manager'.
 *
 * @see League\Flysystem\MountManager for available methods
 *
 * @method mountFilesystems(array $filesystems)
 * @method mountFilesystem($prefix, League\Flysystem\FilesystemInterface $filesystem)
 * @method getFilesystem(string $adapter)
 * @method filterPrefix(array $arguments)
 * @method listContents($directory = '', $recursive = false)
 * @method copy($from, $to)
 * @method listWith(array $keys = [], $directory = '', $recursive = false)
 * @method move($from, $to)
 * @method invokePluginOnFilesystem($method, $arguments, $prefix)
 */
class FlysystemManager extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'flysystem_manager';
    }
}
