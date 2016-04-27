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

/**
 * This provider catches and reports all the exceptions/fatal/syntax error
 * which also provides an elegant User Interface in which you could easily
 * track the bug history
 */
class ErrorHandler extends ServiceProvider
{
    /**
     * {@inheridoc}
     */
    protected $alias = 'error_handler';

    /**
     * {@inheridoc}
     */
    protected $shared = false;

    /**
     * {@inheridoc}
     */
    public function register()
    {
        # handle errors and exceptions
        $handler = config()->app->error_handler;

        (new $handler)->report();

        return $this;
    }
}