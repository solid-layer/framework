<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

use Exception;
use Clarity\Services\ServiceMagicMethods;
use Clarity\Exceptions\ServiceAliasNotFoundException;
use Phalcon\DiInterface;
use Phalcon\Di\InjectionAwareInterface;

/**
 * This is the abstract provider that could manage class extenders.
 */
abstract class ServiceProvider implements InjectionAwareInterface
{
    use \Clarity\Services\Mapper;
    use ServiceMagicMethods;

    /**
     * @var bool
     */
    protected $deffer = false;

    /**
     * @var \Clarity\Services\Mapper
     */
    protected $app;

    /**
     * @var \Phalcon\DiInterface
     */
    protected $_di;

    /**
     * The provider's alias.
     * @var null
     */
    protected $alias = null;

    /**
     * Shared if you want to make your provider as singleton.
     * @var bool
     */
    protected $shared = false;

    /**
     * The lists pushishable stack.
     * @var array
     */
    protected $publish_stack = [];

    /**
     * This determines if the provider will be called after the module call.
     * @var bool
     */
    protected $after_module = false;

    /**
     * {@inheritdoc}
     */
    public function setDI(DiInterface $di)
    {
        $this->app = $this;
        $this->_di = $di;
    }

    /**
     * {@inheritdoc}
     */
    public function getDI()
    {
        return $this->_di;
    }

    /**
     * Check if service provider is deffered.
     *
     * @return bool
     */
    public function isDeffered()
    {
        return $this->deffer;
    }

    /**
     * Get the provider if it is a shared or not.
     *
     * @return bool
     */
    public function getShared()
    {
        return $this->shared;
    }

    /**
     * Get the service alias when accessing to $this->getDI()->get(<alias>).
     *
     * @return string
     */
    public function getAlias()
    {
        if (strlen($this->alias) == 0) {
            throw new ServiceAliasNotFoundException(
                'protected $alias not found on service "'.get_class($this).'"'
            );
        }

        return $this->alias;
    }

    /**
     * To determine if this service must be called after module.
     *
     * @return bool
     */
    public function isAfterModule()
    {
        return $this->after_module;
    }

    /**
     * Call the register() function who extends this class
     * by default, register() will return a false result.
     *
     * @return mixed
     */
    public function callRegister()
    {
        $register = $this->register();

        if ($register === false) {
            throw new Exception(
                'register method not found on service "'.get_class($this).'"'
            );
        }

        return $register;
    }

    /**
     * The process after all di are loaded.
     *
     * @return bool
     */
    public function boot()
    {
        return false;
    }

    /**
     * Registered process based on DI scope.
     *
     * @return mixed
     */
    abstract public function register();

    /**
     * Register a sub provider.
     *
     * @return
     */
    protected function subRegister($sub_name, $callback, $shared = false)
    {
        $name = $this->getAlias().'.'.$sub_name;

        $this->getDI()->set($name, $callback, $shared);
    }

    /**
     * Folders or Files to be copied from going to application path.
     *
     * @param  mixed  $paths The array paths to be copied from and to
     * @param  string $tag   The tag name to be triggered upon running command
     *
     * @return void
     */
    public function publish(array $paths, $tag = null)
    {
        if ($tag) {
            $this->publish_stack[$tag] = $paths;
        } else {
            $this->publish_stack[] = $paths;
        }
    }

    /**
     * Get published stacks based on tag.
     *
     * @param string $tag The tag name to be triggered upon running command
     *
     * @return mixed Stack of all publish keys
     */
    public function getToBePublished($tag = null)
    {
        if ($tag) {
            if (! isset($this->publish_stack[$tag])) {
                throw new Exception('Tag not found.');
            }

            return [
                $tag => $this->publish_stack[$tag],
            ];
        }

        return $this->publish_stack;
    }
}
