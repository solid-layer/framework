<?php
namespace Clarity\Mail;

use Clarity\Facades\Facade;

class MailFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mail';
    }
}
