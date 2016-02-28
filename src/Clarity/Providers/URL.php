<?php
namespace Clarity\Providers;

use Clarity\Support\Phalcon\Mvc\URL as BaseURL;

class URL extends ServiceProvider
{
    protected $alias = 'url';
    protected $shared = false;
    protected $after_module = true;

    public function register()
    {
        return BaseURL::getInstance();
    }
}
