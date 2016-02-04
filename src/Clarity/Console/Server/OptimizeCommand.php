<?php
namespace Clarity\Console\Server;

use Clarity\Console\CLI;
use Clarity\Console\SlayerCommand;

class OptimizeCommand extends SlayerCommand
{
    protected $name = 'optimize';
    protected $description = "Compile all the classes in to a single file.";

    public function slash()
    {
        $this->callComposerOptimizer();
        $this->callClassPreloader();
    }

    protected function callClassPreloader()
    {
        $output = CLI::bash([
            'php vendor/classpreloader/console/classpreloader.php compile ' .
            '--config="bootstrap/compiler.php" ' .
            '--output="' . config()->path->storage . '/slayer/compiled.php" ' .
            '--strip_comments=1',
        ]);

        $this->comment($output);
    }

    protected function callComposerOptimizer()
    {
        $output = CLI::bash([
            'composer dumpautoload --optimize',
        ]);

        $this->info('Removing previous compiled file...');

        $compiled_file = BASE_PATH . '/storage/slayer/compiled.php';
        if ( file_exists($compiled_file) ) {
            unlink($compiled_file);
        }

        $this->comment($output);
    }
}
