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

use Clarity\Support\Phalcon\Mvc\URL as BaseURL;

/**
 * This provider instantiates the @see \Clarity\Support\Phalcon\Mvc\URL.
 */
class URL extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    protected $alias = 'url';

    /**
     * {@inheridoc}.
     */
    protected $shared = true;

    /**
     * {@inheridoc}.
     */
    protected $after_module = true;

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        return BaseURL::getInstance();
    }
}
