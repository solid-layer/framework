<?php
namespace Clarity\TestSuite\Behat\Mink\Adapters;

interface AdapterInterface
{
    public function __construct($parameters);

    public function driver();

    public function session();
}
