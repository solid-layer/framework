<?php
namespace Clarity\Facades;

class Mail extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mail';
    }
}
