<?php

namespace Clarity\Support;

use Clarity\Support\Curl\RESTful;

class CurlTest extends \PHPUnit_Framework_TestCase
{
    public function testRestful()
    {
        $rest = new RESTful('http://'.env('SERVE_HOST').':'.env('SERVE_PORT'));

        $ret = $rest->getClient()->get('/auth/login');

        $this->assertEquals(200, $ret->getStatusCode());
    }
}
