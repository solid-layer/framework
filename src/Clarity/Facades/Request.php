<?php
namespace Clarity\Facades;

class Request extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'request';
    }
}
