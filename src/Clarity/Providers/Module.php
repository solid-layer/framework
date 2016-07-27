<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phalconslayer.readme.io
 */

/**
 */
namespace Clarity\Providers;

/**
 * This provider manage all registered and injected modules.
 */
class Module extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    protected $alias = 'module';

    /**
     * {@inheridoc}.
     */
    protected $shared = true;

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        return $this;
    }

    /**
     * This sets a batch of modules.
     *
     * @param mixed $modules
     * @return \Clarity\Providers\Module Returns itself
     */
    public function setModules(array $modules)
    {
        foreach ($modules as $name => $closure) {
            $this->setModule($name, $closure);
        }

        return $this;
    }

    /**
     * This set a single module.
     *
     * @param string $name
     * @param \Closure $closure
     * @return \Clarity\Providers\Module Returns itself
     */
    public function setModule($name, $closure)
    {
        $modules = [];
        $modules[$name] = $closure;

        config(['modules' => $modules]);

        return $this;
    }

    /**
     * This returns all the available modules.
     *
     * Which converted into an array format
     *
     * @return mixed
     */
    public function all()
    {
        return config()->modules->toArray();
    }
}
