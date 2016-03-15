<?php
namespace Clarity\TestSuite\Behat\Mink\Adapters;

use Behat\Mink\Session;
use Behat\Mink\Driver\GoutteDriver;

class Goutte extends Adapter implements DriverInteface
{
    private $driver;

    public function __construct($parameters)
    {
        $this->driver = call_user_func(new GoutteDriver, $parameters);
    }

    public function driver()
    {
        return $this->driver;
    }
}
