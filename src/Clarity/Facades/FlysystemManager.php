<?php
namespace Clarity\Facades;

class FlysystemManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'flysystem_manager';
    }
}
