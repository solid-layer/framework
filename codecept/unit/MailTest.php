<?php

use Clarity\Mail\Mail;
use Clarity\Mail\Mailgun\Mailgun;
use Clarity\Mail\SwiftMailer\SwiftMailer;

class MailTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    protected function getMailInstance($class, $options)
    {
        return new Mail(new $class, $options);
    }

    public function testAdapters()
    {
        $adapters = [
            Mailgun::class => [
                'from' => env('MAILER_MAIL_FROM'),
            ],
            SwiftMailer::class => [
                'host'       => env('MAILER_HOST'),
                'port'       => env('MAILER_PORT'),
                'username'   => env('MAILER_USERNAME'),
                'password'   => env('MAILER_PASSWORD'),
                'encryption' => env('MAILER_ENCRYPTION', 'tls'),
                'from'       => env('MAILER_MAIL_FROM'),
            ],
        ];

        foreach ($adapters as $class => $options) {
            $adapter = $this->getMailInstance($class, $options);
            $adapter->send('welcome', [], function ($mail) {

            });
        }
    }
}
