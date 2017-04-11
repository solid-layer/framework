<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

use Clarity\Support\Phalcon\Http\Request as BaseRequest;

/**
 * This provider manages the dispatcher requests.
 */
class Request extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    protected $alias = 'request';

    /**
     * {@inheridoc}.
     */
    protected $shared = false;

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        return new BaseRequest;
    }
}
