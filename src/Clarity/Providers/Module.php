<?php
/**
 * PhalconSlayer\Framework
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phalconslayer.readme.io
 */

/**
 * @package Clarity
 * @subpackage Clarity\Providers
 */
namespace Clarity\Providers;

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

        config(['modules' => $modules]);

        return $this;
    }

    public function all()
    {
        return config()->modules->toArray();
    }
}
