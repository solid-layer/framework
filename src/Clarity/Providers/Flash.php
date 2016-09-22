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

use Phalcon\Flash\Direct as PhalconFlashDirect;

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
        return new PhalconFlashDirect([
            'error'   => 'alert alert-danger',
            'success' => 'alert alert-success',
            'notice'  => 'alert alert-info',
            'warning' => 'alert alert-warning',
        ]);
    }
}
