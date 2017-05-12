<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

use Clarity\Exceptions\ControllerNotFoundException;
use Clarity\Support\Phalcon\Events\Manager as PhalconEventsManager;
use Clarity\Support\Phalcon\Mvc\Dispatcher as PhalconMvcDispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;

/**
 * This provider dispatch/process of taking the request object, extracting the
 * module name, controller name, action name, and optional parameters
 * contained in it, and then instantiating a controller and calling an
 * action of that controller.
 */
class Dispatcher extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    protected $alias = 'dispatcher';

    /**
     * {@inheridoc}.
     */
    protected $shared = true;

    /**
     * {@inheridoc}.
     */
    public function boot()
    {
        $dispatcher = $this->getDI()->get('dispatcher');

        $event_manager = new PhalconEventsManager;

        $event_manager->attach('dispatch:beforeException',
            function ($event, $dispatcher, $exception) {
                if ($exception instanceof DispatchException) {
                    throw new ControllerNotFoundException(
                        $exception->getMessage()
                    );
                }
            }
        );

        $dispatcher->setEventsManager($event_manager);
    }

    /**
     * Override the default controller suffix.
     *
     * @return string
     */
    public function getControllerSuffix()
    {
        return 'Controller';
    }

    /**
     * Override the default action suffix.
     *
     * @return string
     */
    public function getActionSuffix()
    {
        return 'Action';
    }

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $this->app->singleton('dispatcher', function () {
            $dispatcher = new PhalconMvcDispatcher();

            $dispatcher->setDefaultNamespace('App\Controllers');
            $dispatcher->setControllerSuffix($this->getControllerSuffix());
            $dispatcher->setActionSuffix($this->getActionSuffix());

            return $dispatcher;
        });
    }
}
