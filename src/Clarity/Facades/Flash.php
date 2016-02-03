<?php
namespace Clarity\Facades;

class Flash extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'flash';
    }
}
