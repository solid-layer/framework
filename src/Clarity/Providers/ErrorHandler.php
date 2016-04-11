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

class ErrorHandler extends ServiceProvider
{
    protected $alias = 'error_handler';
    protected $shared = false;

    public function register()
    {
        # - handle errors and exceptions

        $handler = config()->app->error_handler;

        (new $handler)->report();

        return $this;
    }
}