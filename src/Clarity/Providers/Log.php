<?php
namespace Clarity\Providers;

use Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log extends ServiceProvider
{
    protected $alias = 'log';
    protected $shared = true;

    public function register()
    {
        $logger = new Logger('slayer');

        $logger->pushHandler(
            new StreamHandler(
                config()->path->logs . 'slayer-'.logging_extension().'.log',
                Logger::DEBUG
            )
        );

        return $logger;
    }
}
