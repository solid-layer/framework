<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\TestSuite\Behat\Mink;

use Behat\Mink\Session;
use InvalidArgumentException;

/**
 * The Behat Mink Handler.
 */
class Mink
{
    /**
     * @var mixed
     */
    private $driver;

    /**
     * @var mixed
     */
    private $session;

    /**
     * @var array
     */
    private $adapters;

    /**
     * Constructor.
     *
     * @param array $adapters
     */
    public function __construct($adapters = [])
    {
        $this->setAdapters($adapters);
    }

    /**
     * Set the adapters.
     *
     * @param array $adapters
     * @return mixed|\Clarity\TestSuite\Behat\Mink\Mink
     */
    public function setAdapters(array $adapters)
    {
        if (empty($adapters)) {
            $adapters = require __DIR__.'/config.php';
        }

        $this->adapters = $adapters;

        return $this;
    }

    /**
     * Get an adapter.
     *
     * @param string $name
     * @return mixed|\Behat\Mink\Session
     */
    public function get($name)
    {
        if (! isset($this->adapters[$name])) {
            throw new InvalidArgumentException("Adapter [$name] not found.");
        }

        $adapter = $this->adapters[$name];

        $class = $adapter['class'];
        $args = $adapter['args'];

        $instance = new $class($args);

        return new Session($instance->driver());
    }
}
