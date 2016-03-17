<?php
namespace Clarity\Facades;

class BehatMink extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'behat_mink';
    }
}
