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

use Phalcon\Flash\Session as PhalconFlashSession;

/**
 * Flash messages are used to notify the user about the state of actions he/she
 * made or simply show information to the users.
 * These kinds of messages can be generated using this component.
 */
class FlashBag extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    protected $alias = 'flash_bag';

    /**
     * {@inheridoc}.
     */
    protected $shared = false;

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $flash = new PhalconFlashSession([
            'error'   => 'alert alert-danger',
            'success' => 'alert alert-success',
            'notice'  => 'alert alert-info',
            'warning' => 'alert alert-warning',
        ]);

        if (method_exists($flash, 'setAutoescape')) {
            $flash->setAutoescape(false);
        }

        return $flash;
    }
}
