<?php
namespace Clarity\Providers;

use Phalcon\Http\Response as BaseResponse;

class Response extends ServiceProvider
{
    protected $alias = 'response';
    protected $shared = false;

    public function register()
    {
        return new BaseResponse;
    }
}
