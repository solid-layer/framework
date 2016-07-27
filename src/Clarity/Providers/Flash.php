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

use Phalcon\Session\Bag as PhalconSessionBag;

/**
 * This component helps to separate session data into “namespaces”.
 * Working by this way you can easily create groups of session variables into the application.
 */
class Flash extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    protected $alias = 'flash';

    /**
     * {@inheridoc}.
     */
    protected $shared = true;

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        return new PhalconSessionBag('flash');
    }
}
