<?php

use \Clarity\TestSuite\Behat\Mink\Adapters;

return [
    'adapters' => [

        'goutte' => [
            'class'      => Adapters\Goutte::class,
            'parameters' => [],
        ],

        // 'browserkit' => [
        //     'class'      => Adapters\BrowserKit::class,
        //     'parameters' => [],
        // ],

        // 'selenium2' => [
        //     'class'      => Adapters\Selenium2::class,
        //     'parameters' => ['firefox'],
        // ],

        // 'zombie' => [
        //     'class'      => Adapters\Zombie::class,
        //     'parameters' => [
        //         new \Behat\Mink\Driver\NodeJS\Server\ZombieServer(
        //             // $host,
        //             // $port,
        //             // $nodeBin,
        //             // $script
        //         )
        //     ],

        // ],

        // 'sahi' => [
        //     'class'      => Adapters\Sahi::class,
        //     'parameters' => ['firefox'],
        // ],
    ],
];
