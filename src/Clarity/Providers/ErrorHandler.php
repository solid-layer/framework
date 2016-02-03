<?php
namespace Clarity\Providers;

class ErrorHandler extends ServiceProvider
{
    protected $alias = 'error_handler';
    protected $shared = false;

    public function register()
    {
        # - handle errors and exceptions

        $handler = config()->app->error_handler;

        (new $handler)->report();

        return $this;
    }
}