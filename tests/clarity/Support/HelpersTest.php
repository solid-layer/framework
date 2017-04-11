<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Support;

/**
 * The 'helpers' test case.
 */
class HelpersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the facade helpers.
     *
     * @return void
     */
    public function testHelpersFacade()
    {
        $this->assertInstanceOf(\Clarity\Support\Auth\Auth::class, auth());
        $this->assertInstanceOf(\Phalcon\Config::class, config());
        $this->assertInstanceOf(\Phalcon\Mvc\Dispatcher::class, dispatcher());
        $this->assertInstanceOf(\Phalcon\Filter::class, filter());
        $this->assertInstanceOf(\Phalcon\Flash\Direct::class, flash()->direct());
        $this->assertInstanceOf(\Phalcon\Flash\Session::class, flash()->session());
        $this->assertInstanceOf(\League\Flysystem\Filesystem::class, flysystem());
        $this->assertInstanceOf(\League\Flysystem\MountManager::class, flysystem_manager());
        $this->assertInstanceOf(\Clarity\Support\Redirect\Redirect::class, redirect());
        $this->assertInstanceOf(\Clarity\Support\Phalcon\Http\Request::class, request());
        $this->assertInstanceOf(\Phalcon\Http\Response::class, response());
        $this->assertInstanceOf(\Phalcon\Mvc\Router::class, route());
        $this->assertInstanceOf(\Phalcon\Security::class, security());
        $this->assertInstanceOf(\Phalcon\Tag::class, tag());
        $this->assertInstanceOf(\Phalcon\Mvc\Url::class, url());
        $this->assertInstanceOf(\Phalcon\Mvc\View::class, view());

        # getting an error, will check later on
        $this->assertInstanceOf(\Monolog\Logger::class, logger());

        # adapter base functions

        // $this->assertInstanceOf(, cache());
        // $this->assertInstanceOf(, db());
        // $this->assertInstanceOf(, queue());
        // $this->assertInstanceOf(, session());

        $this->assertContains(
            url()->getBaseUri().'auth/login',
            route('showLoginForm')
        );

        $this->assertInstanceOf(
            \Phalcon\Mvc\View::class,
            view('welcome')
        );
    }

    /**
     * Test the slayer helpers.
     *
     * @return void
     */
    public function testHelpersSlayer()
    {
        # we are exactly getting the default
        $this->assertInstanceOf(
            \Phalcon\Di::class,
            di()
        );

        # we should get the the instance of application
        # similar with di()->get('application')
        $this->assertInstanceOf(
            \Phalcon\Mvc\Application::class,
            di('application')
        );

        # this is similar having
        # di()->set(<alias>, <callback>, <is_shared>) function
        $this->assertInstanceOf(
            \stdClass::class,
            $stdClass = di([
                'sampleAddingOfDi',
                function () {
                    $std = new \stdClass;
                    $std->my_var = true;

                    return $std;
                },
                true,
            ])
        );

        # when calling the di([..]),
        # it also returns this di()->get(<alias>)
        # we must check if the stdClass has $my_var
        $this->assertTrue($stdClass->my_var);
    }
}
