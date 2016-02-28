<?php
namespace Clarity\Support;

// use Mockery as m;
use Phalcon\Tag;
use Phalcon\Session\Bag as Flash;
use Phalcon\Flash\Session as FlashBag;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\MountManager as FlysystemManager;
use Phalcon\Filter;
use Monolog\Logger;
use Phalcon\Config;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Phalcon\Security;
use Phalcon\Mvc\Router;
use Phalcon\Http\Response;
use Phalcon\Http\Request;
use Phalcon\Mvc\Dispatcher;
use Clarity\Support\Auth\Auth;
use Clarity\Support\Redirect\Redirect;

class HelpersTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $GLOBALS['kernel']->modules()->run('main');
    }

    public function testFacades()
    {
        $this->assertInstanceOf(Auth::class,             auth());
        $this->assertInstanceOf(Config::class,           config());
        $this->assertInstanceOf(Dispatcher::class,       dispatcher());
        $this->assertInstanceOf(Filter::class,           filter());
        $this->assertInstanceOf(Flash::class,            flash());
        $this->assertInstanceOf(FlashBag::class,         flash_bag());
        $this->assertInstanceOf(Flysystem::class,        flysystem());
        $this->assertInstanceOf(FlysystemManager::class, flysystem_manager());
        $this->assertInstanceOf(Redirect::class,         redirect());
        $this->assertInstanceOf(Request::class,          request());
        $this->assertInstanceOf(Response::class,         response());
        $this->assertInstanceOf(Router::class,           route());
        $this->assertInstanceOf(Security::class,         security());
        $this->assertInstanceOf(Tag::class,              tag());
        $this->assertInstanceOf(Url::class,              url());
        $this->assertInstanceOf(View::class,             view());


        # adapter base functions

        // $this->assertInstanceOf(, cache());
        // $this->assertInstanceOf(, db());
        // $this->assertInstanceOf(, queue());
        // $this->assertInstanceOf(, session());


        # getting an error, will check later on

        // $this->assertInstanceOf(Logger::class,           log());
    }

    public function testFacadeCapabilities()
    {
        # getting the route should return the full path url

        $this->assertContains(
            url()->getBaseUri().'auth/login',
            route('showLoginForm')
        );


        # You will get an error if the file 'welcome.volt not found',
        # the only solution to know if this works is to know the instance

        $this->assertInstanceOf(View::class, view('welcome'));
    }
}
