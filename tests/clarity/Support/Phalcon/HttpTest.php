<?php

namespace Clarity\Support\Phalcon;

class HttpTest extends \PHPUnit_Framework_TestCase
{
    public function testRequest()
    {
        $main = config('app.base_uri.main');

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

        # roll back
        config([
            'app' => [
                'base_uri' => [
                    'main' => $main,
                ],
            ],
        ]);
    }
}
