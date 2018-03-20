<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\TestSuite\Behat\Mink\Adapters;

/**
 * A driver contract for behat mink.
 */
interface DriverInterface
{
    /**
     * Constructor.
     *
     * @param array $args
     */
    public function __construct($args);

    /**
     * Get the driver.
     *
     * @return mixed
     */
    public function driver();
}
