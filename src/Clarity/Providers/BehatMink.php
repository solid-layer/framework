<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

use Clarity\TestSuite\Behat\Mink\Mink;

/**
 * This provider instantiates the testing tool behat/mink, that by
 * default having the adapters to parse html requests.
 */
class BehatMink extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    protected $alias = 'behat_mink';

    /**
     * {@inheridoc}.
     */
    protected $shared = true;

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $adapters = config()->test_suite->behat->adapters->toArray();

        return new Mink($adapters);
    }
}
