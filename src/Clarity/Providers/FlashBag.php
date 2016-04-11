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

use Phalcon\Flash\Session as PhalconFlashSession;

class FlashBag extends ServiceProvider
{
    protected $alias = 'flash_bag';
    protected $shared = false;

    public function register()
    {
        $flash_session = new PhalconFlashSession([
            'error'   => 'alert alert-danger',
            'success' => 'alert alert-success',
            'notice'  => 'alert alert-info',
            'warning' => 'alert alert-warning',
        ]);

        return $flash_session;
    }
}
