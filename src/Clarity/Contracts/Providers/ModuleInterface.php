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
namespace Clarity\Contracts\Providers;

use Phalcon\Di\FactoryDefault;

/**
 * A provider interface, dedicated for module insertion
 */
interface ModuleInterface
{
    /**
     * Closure passed under the application module
     *
     * @param  FactoryDefault $di
     * @return void
     */
    public function module(FactoryDefault $di);

    /**
     * Execute scripts after module run
     *
     * @return void
     */
    public function afterModuleRun();
}
