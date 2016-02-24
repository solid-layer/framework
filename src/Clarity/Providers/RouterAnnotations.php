<?php
namespace Clarity\Providers;

use Phalcon\Mvc\Router\Annotations as BaseRouter;

class RouterAnnotations extends ServiceProvider
{
    protected $alias = 'router_annotations';
    protected $shared = true;

    public function register()
    {
        return new BaseRouter;
    }
}
