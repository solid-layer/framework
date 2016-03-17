<?php
namespace Clarity\TestSuite\Behat\Mink;

use Behat\Mink\Session;
use InvalidArgumentException;

class Mink
{
    private $driver;
    private $session;
    private $adapters;

    public function __construct($adapters = [])
    {
        $this->setAdapters($adapters);
    }

    public function setAdapters(array $adapters)
    {
        if (empty($adapters)) {
            $adapters = require __DIR__.'/config.php';
        }

        $this->adapters = $adapters;

        return $this;
    }

    public function get($name)
    {
        if (!isset($this->adapters[$name])) {
            throw new InvalidArgumentException("Adapter [$name] not found.");
        }

        $adapter = $this->adapters[$name];

        $class = $adapter['class'];
        $args = $adapter['args'];

        $instance = new $class($args);

        return new Session($instance->driver());
    }
}
