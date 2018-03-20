<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */
use \Clarity\TestSuite\Behat\Mink\Adapters;

return [
    'goutte' => [
        'class' => Clarity\TestSuite\Behat\Mink\Adapters\Goutte::class,
        'args'  => [],
    ],

    // 'browserkit' => [
    //     'class' => Adapters\BrowserKit::class,
    //     'args'  => [],
    // ],

    // 'selenium2' => [
    //     'class' => Adapters\Selenium2::class,
    //     'args'  => ['firefox'],
    // ],

    // 'zombie' => [
    //     'class' => Adapters\Zombie::class,
    //     'args'  => [
    //         new \Behat\Mink\Driver\NodeJS\Server\ZombieServer(
    //             // $host,
    //             // $port,
    //             // $nodeBin,
    //             // $script
    //         )
    //     ],

    // ],

    // 'sahi' => [
    //     'class' => Adapters\Sahi::class,
    //     'args'  => ['firefox'],
    // ],
];
