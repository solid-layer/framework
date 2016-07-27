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
namespace Clarity\Support\Phalcon\Mvc;

use Phalcon\Mvc\Router as BaseRouter;

class Router extends BaseRouter
{
    public function __construct($bool)
    {
        parent::__construct($bool);
    }
}
