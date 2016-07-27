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

use Clarity\Support\Redirect\Redirect as BaseRedirect;

/**
 * This provider manages the redirection of a page or dispatched request.
 */
class Redirect extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    protected $alias = 'redirect';

    /**
     * {@inheridoc}.
     */
    protected $shared = false;

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        return new BaseRedirect;
    }
}
