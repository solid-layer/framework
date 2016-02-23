<?php
namespace Clarity\Providers;

use Clarity\Support\Phalcon\Http\Request as BaseRequest;

class Request extends ServiceProvider
{
    protected $alias = 'request';
    protected $shared = false;

    public function register()
    {
        return new BaseRequest;
    }
}
