<?php
namespace Clarity\Providers;

use Clarity\Support\Auth\Auth as SlayerAuth;

class Auth extends ServiceProvider
{
    protected $alias  = 'auth';
    protected $shared = false;

    public function register()
    {
        return new SlayerAuth;
    }
}
