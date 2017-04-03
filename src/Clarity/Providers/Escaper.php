<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

use Phalcon\Escaper as BaseEscaper;

/**
 * Get the 'escaper' service provider.
 */
class Escaper extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    protected $alias = 'escaper';

    /**
     * {@inheridoc}.
     */
    protected $shared = true;

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        return new BaseEscaper;
    }
}
