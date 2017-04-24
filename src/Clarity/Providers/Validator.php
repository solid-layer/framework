<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

use Clarity\Util;

/**
 * Get the 'validator' service provider.
 */
class Validator extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    protected $alias = 'validator';

    /**
     * {@inheridoc}.
     */
    protected $shared = true;

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        return new Util\Validator\Validator;
    }
}
