<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

/**
 */
namespace Clarity\Support\Redirect;

use Clarity\Support\WithMagicMethodTrait;

class Redirect
{
    use WithMagicMethodTrait;

    public function to($url)
    {
        di()->get('response')->redirect($url);

        return $this;
    }

    public function with($key, $value)
    {
        di()->get('flash')->session()->message($key, $value);

        return $this;
    }
}
