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

use Symfony\Component\Console\Application as ConsoleApplication;

/**
 * This provider register all the assigned consoles which basically
 * manages them and injecting those to be part of the commands.
 */
class Console extends ServiceProvider
{
    /**
     * The current system version.
     */
    const VERSION = 'v1.4.5';

    /**
     * The console description which holds the copywright.
     */
    const DESCRIPTION = 'Brood (c) Daison Cariño';

    /**
     * {@inheridoc}.
     */
    protected $alias = 'console';

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $app = new ConsoleApplication(self::DESCRIPTION, self::VERSION);

        if (is_cli()) {
            foreach (config()->consoles as $console) {
                $app->add(new $console);
            }
        }

        return $app;
    }
}
