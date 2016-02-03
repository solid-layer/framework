<?php
namespace Clarity\Providers;

use Clarity\Support\Phalcon\Mvc\Router as PhalconRouter;

class Router extends ServiceProvider
{
    protected $alias  = 'router';
    protected $shared = true;

    public function register()
    {
        $router = new PhalconRouter(false);

        $router->removeExtraSlashes(true);

        return $router;
    }
}
