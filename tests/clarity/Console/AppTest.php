<?php

namespace Clarity\Console;

class AppTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        $test_module_index = 'public/test_module.php';
        if (file_exists($test_module_index)) {
            di()->get('flysystem')->delete($test_module_index);
        }

        $test_module = 'app/test_module';
        if (is_dir($test_module)) {
            di()->get('flysystem')->deleteDir($test_module);
        }
    }

    public function testAppRoute()
    {
        CLI::bash([
            'php brood app:module test_module',
        ]);

        $has_file = file_exists($path = config()->path->app.'TestModule/Routes.php');
        $this->assertTrue($has_file, 'check if ['.$path.'] were generated');

        $has_file = file_exists($path = config()->path->app.'TestModule/Routes/RouteGroup.php');
        $this->assertTrue($has_file, 'check if ['.$path.'] were generated');

        $has_file = file_exists($path = config()->path->app.'TestModule/Providers/RouterServiceProvider.php');
        $this->assertTrue($has_file, 'check if ['.$path.'] were generated');

        CLI::bash([
            'php brood app:route test test_module',
        ]);

        $has_file = file_exists(config()->path->app.'TestModule/Routes/TestRoutes.php');
        $this->assertTrue($has_file, 'check if route "test" were generated');

        CLI::bash([
            'php brood app:controller test test_module',
        ]);

        $has_file = file_exists(config()->path->app.'TestModule/Controllers/TestController.php');
        $this->assertTrue($has_file, 'check if controller "test" were generated');
    }
}
