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

use Phalcon\Mvc\Router\Annotations as BaseRouter;

/**
 * This provider provides an alternative way to create routes by inserting
 * annotations inside controller's action
 */
class RouterAnnotations extends ServiceProvider
{
    /**
     * {@inheridoc}
     */
    protected $alias = 'router_annotations';

    /**
     * {@inheridoc}
     */
    /**
     * {@inheridoc}
     */
    protected $shared = true;

    /**
     * {@inheridoc}
     */
    public function register()
    {
        return new BaseRouter;
    }
}
