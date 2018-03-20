<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

/**
 * Test the resolver.
 */
class ResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test for service providers.
     *
     * @return void
     */
    public function testService()
    {
        $this->assertFalse(di()->has('mail'));

        resolve('mail');

        $this->assertTrue(di()->has('mail'));
    }
}
