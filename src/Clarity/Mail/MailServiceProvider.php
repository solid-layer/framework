<?php
namespace Clarity\Mail;

use Exception;
use Clarity\Providers\ServiceProvider;

class MailServiceProvider extends ServiceProvider
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

        return new Mail(new $class, $settings);
    }
}
