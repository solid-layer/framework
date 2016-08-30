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

        # since we're loading the default 'main' module
        # located at root/autoload.php
        $this->assertEquals('http://', url()->getScheme());
        $this->assertEquals('slayer.app', url()->getHost());
        $this->assertEquals('http://slayer.app', url()->getFullUrl());

        # https check
        config([
            'app' => [
                'ssl' => [
                    'acme' => true,
                ],
                'base_uri' => [
                    'acme' => 'acme.app',
                ],
            ]
        ]);
        $this->assertEquals('https://', url()->getScheme('acme'));
        $this->assertEquals('acme.app', url()->getHost('acme'));
        $this->assertEquals('https://acme.app', url()->getFullUrl('acme'));

        # revert config
        config($old);

        # http check
        $this->assertEquals('http://', url()->getScheme('main'));
        $this->assertEquals('slayer.app', url()->getHost('main'));
        $this->assertEquals('http://slayer.app', url()->getFullUrl('main'));
    }
}
