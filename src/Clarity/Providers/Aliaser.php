<?php
namespace Clarity\Providers;

class Aliaser extends ServiceProvider
{
    protected $alias = 'aliaser';
    protected $shared = false;

    public function register()
    {
        foreach (config()->app->aliases as $alias => $class) {

            if ( !class_exists($alias) ) {

                class_alias($class, $alias);
            }
        }

        return $this;
    }
}
