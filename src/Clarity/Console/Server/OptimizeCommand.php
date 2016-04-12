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
 * @subpackage Clarity\Console\Server
 */
namespace Clarity\Console\Server;

use Clarity\Console\CLI;
use Clarity\Console\SlayerCommand;

/**
 * A console command that optimized the whole system
 */
class OptimizeCommand extends SlayerCommand
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'optimize';

    /**
     * {@inheritdoc}
     */
    protected $description = "Compile all the classes in to a single file.";

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $this->callComposerOptimizer();
        $this->callClassPreloader();
    }

    /**
     * This calls the class preloader to combine class files
     *
     * @return void
     */
    protected function callClassPreloader()
    {
        CLI::bash([
            'php vendor/classpreloader/console/classpreloader.php compile ' .
            '--config="bootstrap/compiler.php" ' .
            '--output="' . config()->path->storage . '/slayer/compiled.php" ' .
            '--strip_comments=1',
        ]);
    }

    /**
     * This calls the 'composer dumpautoload --optimize'
     *
     * @return void
     */
    protected function callComposerOptimizer()
    {
        CLI::bash([
            'composer dumpautoload --optimize',
        ]);

        $this->info('Removing previous compiled file...');

        $compiled_file = BASE_PATH . '/storage/slayer/compiled.php';
        if ( file_exists($compiled_file) ) {
            unlink($compiled_file);
        }
    }
}
