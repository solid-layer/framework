<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Util\Benchmark;

/**
 * A simple benchmarking class.
 */
class Benchmark
{
    /**
     * @var float
     */
    private $start_time;

    /**
     * @var array
     */
    private $markings = [];

    /**
     * The constructor.
     *
     * @param float $start_time
     */
    public function __construct($start_time)
    {
        $this->start_time = $start_time;
    }

    /**
     * Do some calculations.
     *
     * @param string $name
     * @return void
     */
    public function here($name)
    {
        # get the current microtime in sec
        $now = microtime(true);

        # do some markings
        $this->markings[$name] = $this->format($now - $this->start_time);

        # refresh the start time
        $this->start_time = $now;

        return $this;
    }

    /**
     * Format the value into numeric without having E-#.
     *
     * @param float $value
     * @return float
     */
    protected function format($value)
    {
        return number_format($value, 12, '.', '');
    }

    /**
     * Get the markings.
     *
     * @return array
     */
    public function get()
    {
        return $this->markings;
    }
}
