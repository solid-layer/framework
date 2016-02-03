<?php
namespace Clarity\Facades;

class Auth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'auth';
    }
}
