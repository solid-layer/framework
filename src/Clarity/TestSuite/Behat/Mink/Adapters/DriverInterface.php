<?php
namespace Clarity\TestSuite\Behat\Mink\Adapters;

interface DriverInterface
{
    public function __construct($args);

    public function driver();
}
