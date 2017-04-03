<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\TestSuite\Behat\Mink\Adapters;

use ReflectionClass;
use Behat\Mink\Driver\GoutteDriver;

/**
 * The goutte driver for behat mink.
 */
class Goutte implements DriverInterface
{
    /**
     * @var mixe|\Behat\Mink\Driver\GoutteDriver
     */
    private $driver;

    /**
     * {@inheritdoc}
     */
    public function __construct($args)
    {
        $reflect = new ReflectionClass(GoutteDriver::class);
        $this->driver = $reflect->newInstanceArgs($args);
    }

    /**
     * Get the driver.
     *
     * @return mixed|\Behat\Mink\Driver\GoutteDriver
     */
    public function driver()
    {
        return $this->driver;
    }
}
