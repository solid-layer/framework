<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Console;

/**
 * The 'app' test case.
 */
class AppTest extends \PHPUnit_Framework_TestCase
{
    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        $test_module_index = 'public/test_module.php';
        if (file_exists($test_module_index)) {
            di()->get('flysystem')->delete($test_module_index);
        }

        $test_module = 'app/TestModule';
        if (is_dir($test_module)) {
            di()->get('flysystem')->deleteDir($test_module);
        }
    }

    /**
     * Test the application route.
     *
     * @return void
     */
    public function testAppRoute()
    {
        CLI::bash([
            'php brood app:module test_module',
        ]);

        $has_file = file_exists($file = config()->path->app.'TestModule/Routes.php');
        $this->assertTrue($has_file, 'check if ['.$file.'] were generated');

        $has_file = file_exists($file = config()->path->app.'TestModule/Routes/RouteGroup.php');
        $this->assertTrue($has_file, 'check if ['.$file.'] were generated');

        $file_contents = file_get_contents($file);
        $this->assertContains('namespace App\\TestModule\\Routes;', $file_contents);
        $this->assertContains('use Phalcon\Mvc\Router\Group as BaseRouteGroup;', $file_contents);
        $this->assertContains('class RouteGroup extends BaseRouteGroup', $file_contents);

        $has_file = file_exists($file = config()->path->app.'TestModule/Providers/RouterServiceProvider.php');
        $this->assertTrue($has_file, 'check if ['.$file.'] were generated');

        $file_contents = file_get_contents($file);
        $this->assertContains('namespace App\\TestModule\\Providers;', $file_contents);
        $this->assertContains('use Phalcon\Di\FactoryDefault;', $file_contents);
        $this->assertContains('use Clarity\Providers\ServiceProvider;', $file_contents);
        $this->assertContains('use Clarity\Contracts\Providers\ModuleInterface;', $file_contents);
        $this->assertContains('class RouterServiceProvider extends ServiceProvider implements ModuleInterface', $file_contents);
        $this->assertContains('public function module(FactoryDefault $di)', $file_contents);
        $this->assertContains('->setDefaultNamespace(\'App\TestModule\Controllers\');', $file_contents);
        $this->assertContains('public function afterModuleRun()', $file_contents);
        $this->assertContains('require_once realpath(__DIR__.\'/../\').\'/Routes.php\';', $file_contents);

        CLI::bash([
            'php brood app:route test test_module',
        ]);

        $has_file = file_exists($file = config()->path->app.'TestModule/Routes/TestRoutes.php');
        $this->assertTrue($has_file, 'check if ['.$file.'] were generated');

        $file_contents = file_get_contents($file);
        $this->assertContains('namespace App\\TestModule\\Routes;', $file_contents);
        $this->assertContains('class TestRoutes extends RouteGroup', $file_contents);

        CLI::bash([
            'php brood app:controller test test_module',
        ]);

        $has_file = file_exists($file = config()->path->app.'TestModule/Controllers/TestController.php');
        $this->assertTrue($has_file, 'check if ['.$file.'] were generated');

        $file_contents = file_get_contents($file);
        $this->assertContains('namespace App\\TestModule\\Controllers;', $file_contents);
        $this->assertContains('class TestController extends Controller', $file_contents);
    }
}
