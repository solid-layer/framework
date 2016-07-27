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
namespace Clarity\Providers;

use Phalcon\Http\Response as BaseResponse;

/**
 * This provider manages the response or headers to be passed in.
 */
class Response extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    protected $alias = 'response';

    /**
     * {@inheridoc}.
     */
    /**
     * {@inheridoc}.
     */
    protected $shared = false;

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        return new BaseResponse;
    }
}
