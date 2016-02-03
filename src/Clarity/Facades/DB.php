<?php
namespace Clarity\Facades;

class DB extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'db';
    }
}
