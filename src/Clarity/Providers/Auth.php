<?php
namespace Clarity\Providers;

use Clarity\Support\Auth\Auth as BaseAuth;

class Auth extends ServiceProvider
{
    protected $alias = 'auth';
    protected $shared = false;

    public function register()
    {
        return new BaseAuth;
    }
}
