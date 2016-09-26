<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

/**
 */
namespace Clarity\Providers;

/**
 * This provider manages all class aliases.
 */
class Aliaser extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    protected $alias = 'aliaser';

    /**
     * {@inheridoc}.
     */
    protected $shared = true;

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        foreach (config()->app->aliases as $alias => $class) {
            if (! class_exists($alias)) {
                $this->append($alias, $class);
            }
        }

        return $this;
    }

    /**
     * Attach the alias and the full class.
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
