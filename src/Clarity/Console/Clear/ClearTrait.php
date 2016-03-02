<?php
namespace Clarity\Console\Clear;

trait ClearTrait
{
    private $ignored_files = [
        '.gitignore',
    ];

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

            if ( $file->isDir() ) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
    }
}
