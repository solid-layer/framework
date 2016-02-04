<?php
namespace Clarity\Support\Phalcon\Mvc;

use Phalcon\Config;
use League\Tactician\CommandBus;
use Clarity\Support\Http\Middleware\Kernel;
use Phalcon\Mvc\Controller as BaseController;

class Controller extends BaseController
{
    public function middleware($alias, $options = [])
    {
        $middlewares = [];

        if ( di()->has('assigned_middlewares') ) {
            $middlewares = di()->get('assigned_middlewares')->toArray();
        }

        $middlewares[] = $alias;

        di()->set('assigned_middlewares', function () use ($middlewares) {

            return new Config($middlewares);
        }, true);
    }

    public function beforeExecuteRoute()
    {
        if ( method_exists($this, 'initialize') ) {
            $this->initialize();
        }

        if ( di()->has('assigned_middlewares') === false ) {
            return;
        }

        $assigned_m = di()->get('assigned_middlewares')->toArray();

        $kernel = new Kernel(config()->app->middlewares);

        $instances = [];

        foreach ($assigned_m as $mid) {
            $class = $kernel->get($mid);

            $instances[] = new $class;
        }

        $command_bus = new CommandBus($instances);
        $command_bus->handle($this);
    }
}
