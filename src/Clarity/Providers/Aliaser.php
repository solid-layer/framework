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

                $this->append($alias, $class);
            }
        }

        return $this;
    }

    /**
     * Attach the alias clas
     *
     * @param  string $alias
     * @param  string $class
     * @return mixed
     */
    public function append($alias, $class)
    {
        class_alias($class, $alias);

        return $this;
    }
}
