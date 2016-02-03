<?php
namespace Clarity\Support\Phalcon\Mvc;

use Phalcon\Config;
use League\Tactician\CommandBus;
use Clarity\Support\Http\Middleware\Kernel;

class Controller extends \Phalcon\Mvc\Controller
{
    public function middleware($alias, $options = [])
    {
        $middlewares = [];

        if ( di()->has('middlewares') ) {
            $middlewares = di()->get('middlewares')->toArray();
        }

        $middlewares[] = $alias;

        di()->set('middlewares', function () use ($middlewares) {

            return new Config($middlewares);
        }, true);
    }

    public function beforeExecuteRoute()
    {
        if ( method_exists($this, 'initialize') ) {
            $this->initialize();
        }

        if ( di()->has('middlewares') === false ) {
            return;
        }

        $middlewares = di()->get('middlewares')->toArray();

        $kernel = new Kernel;
        $kernel->initialize();

        $instances = [];

        foreach ($middlewares as $mid) {
            $class = $kernel->getClass($mid);

            $instances[] = new $class;
        }

        $command_bus = new CommandBus($instances);
        $command_bus->handle($this);
    }
}
