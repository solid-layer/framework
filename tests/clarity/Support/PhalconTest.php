<?php

namespace Clarity\Support;

class PhalconTest extends \PHPUnit_Framework_TestCase
{
    public function testHttpRequest()
    {
        $old = config()->toArray();

        # let's change the server host and port
        config([
            'app' => [
                'base_uri' => [
                    'main' => env('SERVE_HOST').':'.env('SERVE_PORT'),
                ],
            ],
        ]);

        $request = request()->module('main')->get('/auth/login');

        $this->assertEquals(200, $request->getStatusCode());

        # reset
        config($old);
    }

    public function testMvcUrl()
    {
        $old = config()->toArray();

        # check when using non module, since this will be executed
        # under cli, it should return 'localhost' for host and
        # http:// for the scheme
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

        # revert config
        config($old);

        # http check
        $this->assertEquals('http://', url()->getScheme($module));
        $this->assertEquals('slayer.app', url()->getHost($module));
        $this->assertEquals('http://slayer.app', url()->getFullUrl($module));
    }
}
