<?php
namespace Clarity\Facades;

class Flysystem extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'flysystem';
    }
}
