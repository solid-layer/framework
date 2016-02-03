<?php
namespace Clarity\Providers;

use Exception;
use Clarity\Support\Mail\Mail as SupportMail;

class Mail extends ServiceProvider
{
    protected $alias  = 'mail';
    protected $shared = false;

    public function register()
    {
        $adapter = config()->app->mail_adapter;

        $settings = config()->mail->{$adapter};

        if ( !$settings ) {
            throw new Exception('Adapter not found.');
        }

        $settings = $settings->toArray();

        $class = $settings['class'];

        unset($settings['class']);

        return new SupportMail(new $class, $settings);
    }
}
