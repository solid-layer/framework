<?php
namespace Clarity\Providers;

use Clarity\Facades\Facade;
use Phalcon\Mvc\Application as BaseApplication;

class Application extends ServiceProvider
{
    protected $alias = 'application';
    protected $shared = true;

    public function register()
    {
        $instance = new BaseApplication(di());

        Facade::setFacadeApplication($instance);

        return $instance;
    }
}
