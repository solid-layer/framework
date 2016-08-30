<?php

namespace Clarity\Support;

class PhalconTest extends \PHPUnit_Framework_TestCase
{
    public function testHttpMiddleware()
    {
    }

    public function testHttpRequest()
    {
        config([
            'app' => [
                'base_uri' => [
                    'main' => env('SERVE_HOST').':'.env('SERVE_PORT'),
                ],
            ],
        ]);

        $request = request()->module('main')->get('/auth/login');

        $this->assertEquals(200, $request->getStatusCode());
    }

    public function testMvcUrl()
    {
        $this->assertEquals('localhost', url()->getHost());
        $this->assertEquals('http://', url()->getScheme());
        $this->assertEquals('http://localhost', url()->getFullUrl());

        $module = 'main';

        # https check
        config([
            'app' => [
                'ssl' => [
                    'main' => true,
                ],
            ]
        ]);
        $this->assertEquals('https://', url()->getScheme($module));
        $this->assertEquals('slayer.app', url()->getHost($module));
        $this->assertEquals('https://slayer.app', url()->getFullUrl($module));

        # http check
        config([
            'app' => [
                'ssl' => [
                    'main' => false,
                ],
            ]
        ]);
        $this->assertEquals('http://', url()->getScheme($module));
        $this->assertEquals('slayer.app', url()->getHost($module));
        $this->assertEquals('http://slayer.app', url()->getFullUrl($module));
    }
}
