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
 * @subpackage Clarity\TestSuite\Behat\Mink\Adapters
 */
namespace Clarity\TestSuite\Behat\Mink\Adapters;

use ReflectionClass;
use Behat\Mink\Driver\GoutteDriver;

class Goutte implements DriverInterface
{
    private $driver;

    public function __construct($args)
    {
        $reflect = new ReflectionClass(GoutteDriver::class);
        $this->driver = $reflect->newInstanceArgs($args);
    }

    public function driver()
    {
        return $this->driver;
    }
}
