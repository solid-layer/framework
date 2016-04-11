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

use Clarity\Support\Phalcon\Mvc\Router as BaseRouter;

class Router extends ServiceProvider
{
    protected $alias  = 'router';
    protected $shared = true;

    public function register()
    {
        $router = new BaseRouter(false);

        $router->removeExtraSlashes(true);

        // $router->setUriSource(BaseRouter::URI_SOURCE_GET_URL); // default
        $router->setUriSource(BaseRouter::URI_SOURCE_SERVER_REQUEST_URI);

        return $router;
    }
}
