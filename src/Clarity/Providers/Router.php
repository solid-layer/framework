<?php
namespace Clarity\Providers;

use Clarity\Support\Phalcon\Mvc\Router as BaseRouter;

class Router extends ServiceProvider
{
    protected $alias  = 'router';
    protected $shared = true;

    public function register()
    {
        $router = new BaseRouter(false);

        $router->removeExtraSlashes(true);

        return $router;
    }
}
