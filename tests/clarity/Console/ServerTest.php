<?php
namespace Clarity\Console;

use Clarity\Console\CLI;

class ServerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        $compiled_file = 'storage/slayer/compiled.php';

        if ( file_exists($compiled_file) ) {
            di()->get('flysystem')->delete($compiled_file);
        }
    }

    public function testOptimizeCommand()
    {
        CLI::bash([
            'php brood optimize --force',
        ]);

        $has_file = file_exists(config()->path->storage . 'slayer/compiled.php');
        $this->assertTrue($has_file, 'check if classes were generated and compiled');
    }
}
