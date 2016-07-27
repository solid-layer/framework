<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phalconslayer.readme.io
 */
if (! function_exists('base_path')) {

    /**
     * Get the base path.
     *
     * @param string $extend_path To access file by providing extended path
     * @return string
     */
    function base_path($extend_path = null)
    {
        return url_trimmer(config()->path->root.'/'.$extend_path);
    }
}

if (! function_exists('app_path')) {

    /**
     * Get the app path.
     *
     * @param string $extend_path To access file by providing extended path
     * @return string
     */
    function app_path($extend_path = null)
    {
        return url_trimmer(config()->path->app.'/'.$extend_path);
    }
}

if (! function_exists('config_path')) {

    /**
     * Get the config path.
     *
     * @param string $extend_path To access file by providing extended path
     * @return string
     */
    function config_path($extend_path = null)
    {
        return url_trimmer(config()->path->config.'/'.$extend_path);
    }
}

if (! function_exists('database_path')) {

    /**
     * Get the database path.
     *
     * @param string $extend_path To access file by providing extended path
     * @return string
     */
    function database_path($extend_path = null)
    {
        return url_trimmer(config()->path->database.'/'.$extend_path);
    }
}

if (! function_exists('storage_path')) {

    /**
     * Get the storage path.
     *
     * @param string $extend_path To access file by providing extended path
     * @return string
     */
    function storage_path($extend_path = null)
    {
        return url_trimmer(config()->path->storage.'/'.$extend_path);
    }
}

if (! function_exists('public_path')) {

    /**
     * Get the public path.
     *
     * @param string $extend_path To access file by providing extended path
     * @return string
     */
    function public_path($extend_path = null)
    {
        return url_trimmer(config()->path->public.'/'.$extend_path);
    }
}

if (! function_exists('resources_path')) {

    /**
     * Get the resources path.
     *
     * @param string $extend_path To access file by providing extended path
     * @return string
     */
    function resources_path($extend_path = null)
    {
        return url_trimmer(config()->path->resources.'/'.$extend_path);
    }
}

if (! function_exists('sandbox_path')) {

    /**
     * Get the sandbox path.
     *
     * @param string $extend_path To access file by providing extended path
     * @return string
     */
    function sandbox_path($extend_path = null)
    {
        return url_trimmer(config()->path->sandbox.'/'.$extend_path);
    }
}

if (! function_exists('cp')) {

    /**
     * To copy a certain source to destination.
     *
     * @param string $source The source file/folder
     * @param string $dest The destination file/folder
     * @return void
     */
    function cp($source, $dest)
    {
        if (is_dir($dest) === false) {
            mkdir($dest, 0755, true);
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $source,
                \RecursiveDirectoryIterator::SKIP_DOTS
            ),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            # check if the item is directory
            if ($item->isDir()) {
                # check if there is existing directory
                # else create.

                $_temp_dir = $dest.'/'.$iterator->getSubPathName();

                if (is_dir($_temp_dir) === false) {
                    mkdir($dest.'/'.$iterator->getSubPathName(), true);
                }

                continue;
            }

            # it is a file
            copy($item, $dest.'/'.$iterator->getSubPathName());
        }
    }
}

if (! function_exists('folder_files')) {

    /**
     * Get all the files from assigned path.
     *
     * @param string $path The path to be iterated
     * @return mixed
     */
    function folder_files($path, $sub_dir = false)
    {
        if (file_exists($path) === false) {
            return [];
        }

        $iterator = new RecursiveDirectoryIterator(
            $path,
            RecursiveDirectoryIterator::SKIP_DOTS
        );

        $files = [];

        foreach ($iterator as $item) {
            if ($item->isDir()) {
                if ($sub_dir === true) {
                    $tmp_files = folder_files($item->getPathName(), true);
                    $files = array_merge($files, $tmp_files);
                }

                continue;
            }

            $files[] = $item->getPathName();
        }

        return $files;
    }
}
