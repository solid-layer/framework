<?php
/**
 * PhalconSlayer\Framework
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phalconslayer.readme.io
 */

/**
 * @package Clarity
 * @subpackage Clarity\Providers
 */
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
                storage_path('logs').'/slayer-'.logging_extension().'.log',
                Logger::DEBUG
            )
        );

        return $logger;
    }
}
