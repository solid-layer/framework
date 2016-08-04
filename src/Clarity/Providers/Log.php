<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

/**
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
     * {@inheridoc}.
     */
    protected $alias = 'log';

    /**
     * {@inheridoc}.
     */
    protected $shared = true;

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $logger = new Logger('slayer');

        $logger_name = 'slayer';

        if (logging_extension()) {
            $logger_name = 'slayer-'.logging_extension();
        }

        $logger->pushHandler(
            new StreamHandler(
                storage_path('logs').'/'.$logger_name.'.log',
                Logger::DEBUG
            )
        );

        return $logger;
    }
}
