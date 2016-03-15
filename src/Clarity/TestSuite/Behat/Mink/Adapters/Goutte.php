<?php
namespace Clarity\TestSuite\Behat\Mink\Adapters;

use Behat\Mink\Session;
use Behat\Mink\Driver\GoutteDriver;

class Goutte extends Adapter implements AdapterInteface
{
    private $driver;
    private $session;

    public function __construct($parameters)
    {
        $this->driver = call_user_func(new GoutteDriver, $parameters);
        $this->session = new Session($this->driver);
    }

    public function driver()
    {
        return $this->driver;
    }

    public function session()
    {
        return $this->session;
    }
}
