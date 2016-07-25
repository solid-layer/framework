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
 * @subpackage Clarity\Console\Clear
 */
namespace Clarity\Console\Clear;

/**
 * A console command that clears the storage cache
 */
trait ClearTrait
{
    /**
     * Lists of ignored files
     *
     * @var mixed
     */
    private $ignored_files = [
        '.gitignore',
    ];

    /**
     * This recursively clears all files including folders, based on the $path
     * provided
     *
     * @param string $path The designated path to be cleared
     * @return void
     */
    public function clear($path)
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $path,
                \RecursiveDirectoryIterator::SKIP_DOTS
            ),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $file) {
            if (in_array($file->getFileName(), $this->ignored_files)) {
                continue;
            }

            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
    }
}
