<?php

namespace Clarity\Support\Phalcon;

use Clarity\Facades\Route;
use Clarity\Support\Phalcon\Mvc\URL;
use Clarity\Support\Phalcon\Mvc\Router;

class MvcTest extends \PHPUnit_Framework_TestCase
{
    public function testUrl()
    {
        $old = config()->toArray();

        $url = new URL;

        # since we're loading the default 'main' module
        # located at root/autoload.php
        $this->assertEquals('http://', $url->getScheme());
        $this->assertEquals('slayer.app', $url->getHost());
        $this->assertEquals('http://slayer.app', $url->getFullUrl());

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
        $this->assertEquals('https://', $url->getScheme('acme'));
        $this->assertEquals('acme.app', $url->getHost('acme'));
        $this->assertEquals('https://acme.app', $url->getFullUrl('acme'));

        # revert config
        config($old);

        # http check
        $this->assertEquals('http://', $url->getScheme('main'));
        $this->assertEquals('slayer.app', $url->getHost('main'));
        $this->assertEquals('http://slayer.app', $url->getFullUrl('main'));


        # let's call the di 'route' to register these routes
        route()->add('/test', [
            'controller' => 'Something',
            'action' => 'someone',
        ])->setName('test');

        route()->add('/test/{id}', [
            'controller' => 'Something',
            'action' => 'someone',
        ])->setName('testWithId');

        route()->add('/test/{id}', [
            'controller' => 'Something',
            'action' => 'someone',
        ])->setName('testWithParamsAndRaw');

        # we need to call the url() helper to be able to call
        # the registered 'router'
        $simple_route = url()->route('test');
        $params_route = url()->route('testWithId', ['id' => 1]);
        $raw_route = url()->route('testWithParamsAndRaw', ['id' => 1], ['debug' => true]);

        $this->assertEquals($simple_route, 'http://slayer.app/test');
        $this->assertEquals($params_route, 'http://slayer.app/test/1');
        $this->assertEquals($raw_route, 'http://slayer.app/test/1?debug=1');
    }
}
