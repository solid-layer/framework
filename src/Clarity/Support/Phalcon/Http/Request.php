<?php
namespace Clarity\Support\Phalcon\Http;

use Clarity\Support\Curl\RESTful;
use Phalcon\Http\Request as BaseRequest;

class Request extends BaseRequest
{
    public function module($name)
    {
        return new RESTful(url()->getFullUrl($name));
    }
}
