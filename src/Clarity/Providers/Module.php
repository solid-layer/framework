<?php
namespace Clarity\Providers;

use Phalcon\Config;
use Phalcon\Session\Bag as PhalconSessionBag;

class Module extends ServiceProvider
{
    protected $alias = 'module';
    protected $shared = true;

    public function register()
    {
        return $this;
    }

    public function setModules(array $modules)
    {
        foreach ($modules as $name => $closure) {
            $this->setModule($name, $closure);
        }

        return $this;
    }

    public function setModule($name, $closure)
    {
        $modules = [];
        $modules[$name] = $closure;

        config()->merge(new Config(['modules' => $modules]));

        return $this;
    }

    public function all()
    {
        return config()->modules->toArray();
    }
}
