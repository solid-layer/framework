<?php
namespace Clarity\Providers;

use Exception;
use Clarity\Services\ServiceMagicMethods;
use Clarity\Exceptions\ServiceAliasNotFoundException;

class ServiceProvider
{
    use ServiceMagicMethods;

    protected $alias = null;
    protected $shared = false;
    protected $publishStack = [];
    protected $after_module = false;

    /**
     * Get the provider if it is a shared or not
     *
     * @return boolean
     */
    public function getShared()
    {
        return $this->shared;
    }

    /**
     * Get the service alias when accessing to di()->get(<alias>)
     *
     * @return string
     */
    public function getAlias()
    {
        if (strlen($this->alias) == 0) {
            throw new ServiceAliasNotFoundException(
                'protected $alias not found on service "' . get_class($this) . '"'
            );
        }

        return $this->alias;
    }

    /**
     * To determine if this service must be called after module
     *
     * @return bool
     */
    public function getAfterModule()
    {
        return $this->after_module;
    }

    /**
     * Call the register() function who extends this class
     * by default, register() will return a false result
     *
     * @return mixed
     */
    public function callRegister()
    {
        $register = $this->register();

        if ($register === false) {
            throw new Exception(
                'register method not found on service "' . get_class($this) . '"'
            );
        }

        return $register;
    }

    /**
     * The process after all di are loaded
     *
     * @return bool
     */
    public function boot()
    {
        return false;
    }

    /**
     * Registered process based on DI scope
     *
     * @return bool
     */
    public function register()
    {
        return false;
    }

    /**
     * Folders or Files to be copied from going to application path
     *
     * @param  mixed  $paths The array paths to be copied from and to
     * @param  string $tag   The tag name to be triggered upon running command
     */
    public function publish(array $paths, $tag = null)
    {
        if ( $tag ) {
            $this->publishStack[ $tag ] = $paths;
        } else {
            $this->publishStack[] = $paths;
        }
    }

    /**
     * Get published stacks based on tag
     *
     * @param  string $tag The tag name to be triggered upon running command
     *
     * @return mixed       Stack of all publish keys
     */
    public function getToBePublished($tag = null)
    {
        if ( $tag ) {

            if ( ! isset($this->publishStack[$tag]) ) {
                throw new Exception('Tag not found.');
            }

            return [
                $tag => $this->publishStack[$tag]
            ];
        }

        return $this->publishStack;
    }
}
