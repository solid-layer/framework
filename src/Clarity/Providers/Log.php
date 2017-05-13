<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * This provider handles the logging, which by default logs the errors, database
 * transactions.
 */
class Log extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * Get all this service provider provides.
     *
     * @return array
     */
    public function provides()
    {
        return ['logger'];
    }

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $this->app->singleton('logger', function () {
            $logger = new Logger('slayer');

            $logger_name = 'slayer';

            if ($ext = logging_extension()) {
                $logger_name .= '-'.$ext;
            }

            $logger->pushHandler(
                new StreamHandler(
                    storage_path('logs').'/'.$logger_name.'.log',
                    Logger::DEBUG
                )
            );

            return $logger;
        });
    }
}
