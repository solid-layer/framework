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

use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Clarity\Exceptions\ControllerNotFoundException;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;

class Dispatcher extends ServiceProvider
{
    protected $alias = 'dispatcher';
    protected $shared = true;

    public function boot()
    {
        $dispatcher = di()->get('dispatcher');

        $event_manager = new EventsManager;

        $event_manager->attach('dispatch:beforeException',
            function ($event, $dispatcher, $exception) {

                if ( $exception instanceof DispatchException ) {

                    throw new ControllerNotFoundException(
                        $exception->getMessage()
                    );
                }
            }
        );

        $dispatcher->setEventsManager($event_manager);
    }

    public function register()
    {
        $dispatcher = new MvcDispatcher();

        $dispatcher->setDefaultNamespace('App\Controllers');

        $dispatcher->setActionSuffix('');

        return $dispatcher;
    }
}
