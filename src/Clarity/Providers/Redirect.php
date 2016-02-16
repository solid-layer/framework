<?php
namespace Clarity\Providers;

use Clarity\Support\Redirect\Redirect as BaseRedirect;

class Redirect extends ServiceProvider
{
    protected $alias = 'redirect';
    protected $shared = false;

    public function register()
    {
        return new BaseRedirect;
    }
}
