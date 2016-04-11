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

use Clarity\TestSuite\Behat\Mink\Mink;

class BehatMink extends ServiceProvider
{
    protected $alias = 'behat_mink';
    protected $shared = false;

    public function register()
    {
        $adapters = config()->test_suite->behat->adapters->toArray();

        return new Mink($adapters);
    }
}
