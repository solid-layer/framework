<?php
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
