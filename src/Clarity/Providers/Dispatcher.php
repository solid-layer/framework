<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Clarity\Exceptions\ControllerNotFoundException;
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
        $dispatcher = di()->get('dispatcher');

        $event_manager = new EventsManager;

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
     * Provide the action suffix to be used.
     *
     * @return string
     */
    protected function getActionSuffix()
    {
        return '';
    }

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $dispatcher = new MvcDispatcher();

        $dispatcher->setDefaultNamespace('App\Controllers');

        $dispatcher->setActionSuffix($this->getActionSuffix());

        return $dispatcher;
    }
}
