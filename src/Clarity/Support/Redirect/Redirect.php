<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Support\Redirect;

use Clarity\Support\WithMagicMethodTrait;

/***
 * Class Redirect
 * @package Clarity\Support\Redirect
 *
 * @method withError(string $message) write error flash message
 * @method withSuccess(string $message) write success flash message
 */
class Redirect
{
    use WithMagicMethodTrait;

    /**
     * Redirect based on the provided url.
     *
     * @param string $url
     * @return mixed|\Clarity\Support\Redirect\Redirect
     */
    public function to($url)
    {
        di()->get('response')->redirect($url);

        return $this;
    }

    /**
     * Passing a query param.
     *
     * @param string $key
     * @param string $value
     * @return mixed|\Clarity\Support\Redirect\Redirect
     */
    public function with($key, $value)
    {
        di()->get('flash')->session()->message($key, $value);

        return $this;
    }
}
