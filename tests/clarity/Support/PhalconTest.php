<?php
namespace Clarity\Support;

class PhalconTest extends \PHPUnit_Framework_TestCase
{
    public function testHttpMiddleware()
    {
    }

    public function testHttpRequest()
    {
        $request = request()->module('main')->get('/auth/login');

        $this->assertEquals(200, $request->getStatusCode());
    }
}
