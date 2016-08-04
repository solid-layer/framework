<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phalconslayer.readme.io
 */

/**
 */
namespace Clarity\Console\Server;

use Clarity\Console\CLI;
use ClassPreloader\Factory;
use Clarity\Console\Brood;
use Symfony\Component\Console\Input\InputOption;
use ClassPreloader\Exceptions\VisitorExceptionInterface;

/**
 * A console command that optimized the whole system.
 */
class OptimizeCommand extends Brood
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'optimize';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Compile all the classes in to a single file.';

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $this->callComposerOptimizer();

        if (
            $this->input->getOption('force')
            // && !config()->app->debug
        ) {
            $this->info('Compiling classes...');
            $this->compileClasses();
        }
    }

    /**
     * Generate the compiled class file.
     *
     * @return void
     */
    protected function compileClasses()
    {
        $preloader = (new Factory)->create(['skip' => false]);

        $compile_path = config()->path->storage.'/slayer/compiled.php';

        $handle = $preloader->prepareOutput($compile_path);

        foreach ($this->getClassFiles() as $file) {
            try {
                fwrite(
                    $handle,
                    $preloader->getCode($file, false)."\n"
                );
            } catch (VisitorExceptionInterface $e) {
                //
            }
        }

        fclose($handle);

        $this->info('   Compiled at '.url_trimmer($compile_path));
    }

    private function filesKey($files)
    {
        foreach ($files as $idx => $path) {
            $files[$path] = $path;
            unset($files[$idx]);
        }

        return $files;
    }

    /**
     * Get the classes that should be combined and compiled.
     *
     * @return array
     */
    protected function getClassFiles()
    {
        $core = $this->filesKey(
            array_map('url_trimmer', require __DIR__.'/Optimize/config.php')
        );

        $files = array_merge(
            $core,
            $this->filesKey(
                array_map('url_trimmer', (array) config('compile.files', []))
            )
        );

        foreach ((array) config('compile.folders', []) as $folder) {
            $files = array_merge(
                $files,
                $this->filesKey(
                    array_map('url_trimmer', folder_files($folder, true))
                )
            );
        }

        foreach ((array) config('compile.providers', []) as $provider) {
            $files = array_merge(
                $files,
                $this->filesKey(
                    array_map('url_trimmer', forward_static_call([$provider, 'compiles']))
                )
            );
        }

        return array_map('url_trimmer',
            array_map('realpath', $files)
        );
    }

    /**
     * This calls the 'composer dumpautoload --optimize'.
     *
     * @return void
     */
    protected function callComposerOptimizer()
    {
        CLI::bash([
            'composer dumpautoload --optimize',
        ]);

        $compiled_file = config('path.root').'/storage/slayer/compiled.php';

        if (file_exists($compiled_file)) {
            $this->info('Removing previous compiled file...');
            unlink($compiled_file);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function options()
    {
        return [
            [
                'force',
                null,
                InputOption::VALUE_NONE,
                'To write classes inside compiled.php',
            ],
        ];
    }
}
