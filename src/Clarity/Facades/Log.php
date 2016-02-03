<?php
namespace Clarity\Facades;

class Log extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'log';
    }
}
