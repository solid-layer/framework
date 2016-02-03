<?php
namespace Clarity\Providers;

use Clarity\Support\Redirect\Redirect as SupportRedirect;

class Redirect extends ServiceProvider
{
    protected $alias  = 'redirect';
    protected $shared = false;

    public function register()
    {
        return new SupportRedirect;
    }
}
