<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Console\Server;

use Clarity\Console\Brood;
use Symfony\Component\Console\Input\InputOption;

/**
 * A console command that serves a module.
 */
class BenchmarkCommand extends Brood
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'benchmark';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Check the system benchmarking calls.';

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $table = $this->table(
            ['Name', 'Time (sec)', 'Percentage'],
            $this->getBenchmarks()
        );

        $table->render();
    }

    public function getBenchmarks()
    {
        $markings = resolve('benchmark')->get();

        $ret = [];

        $total_sec = 0;

        foreach ($markings as $name => $sec) {
            $total_sec += $sec;

            $ret[] = [
                $name,
                $sec,
                0,
            ];
        }

        $ret[] = [
            'TOTAL',
            $total_sec,
            null
        ];

        return $ret;
    }

    /**
     * {@inheritdoc}
     */
    protected function options()
    {
        return [];
    }
}
