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
