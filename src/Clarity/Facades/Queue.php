<?php
namespace Clarity\Facades;

class Queue extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'queue';
    }
}
