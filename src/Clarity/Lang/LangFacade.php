<?php
namespace Clarity\Lang;

use Clarity\Facades\Facade;

class LangFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'lang';
    }
}
