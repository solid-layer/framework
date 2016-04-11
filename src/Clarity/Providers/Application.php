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

class Application extends ServiceProvider
{
    protected $alias = 'application';
    protected $shared = true;

    public function register()
    {
        $instance = new BaseApplication(di());

        Facade::setFacadeApplication($instance);

        return $instance;
    }
}
