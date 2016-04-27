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

use Clarity\Facades\Facade;
use Phalcon\Mvc\Application as BaseApplication;

/**
 * This provider handles the @see \Phalcon\Mvc\Application
 * and also having an option to add a module
 */
class Application extends ServiceProvider
{
    /**
     * {@inheridoc}
     */
    protected $alias = 'application';

    /**
     * {@inheridoc}
     */
    protected $shared = true;

    /**
     * {@inheridoc}
     */
    public function register()
    {
        $instance = new BaseApplication(di());

        Facade::setFacadeApplication($instance);

        return $instance;
    }
}
