<?php
namespace Clarity\Providers;

use Symfony\Component\Console\Application as ConsoleApplication;

class Console extends ServiceProvider
{
    const VERSION = 'v1.4.0';
    const DESCRIPTION = 'Brood (c) Daison Cariño';

    protected $alias = 'console';

    public function register()
    {
        $app = new ConsoleApplication(self::DESCRIPTION, self::VERSION);

        if ( php_sapi_name() === 'cli' ) {
            foreach (config()->consoles as $console) {
                $app->add(new $console);
            }
        }

        return $app;
    }
}
