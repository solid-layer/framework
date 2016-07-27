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
}
