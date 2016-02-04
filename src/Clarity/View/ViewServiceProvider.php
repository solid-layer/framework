<?php
namespace Clarity\View;

use Phalcon\Events\Event;
use Phalcon\Events\Manager;
use Phalcon\Mvc\View\Engine\Php;
use Clarity\View\Volt\VoltAdapter;
use Clarity\View\Blade\BladeAdapter;
use Clarity\Support\Phalcon\Mvc\View;
use Clarity\Providers\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    protected $alias  = 'view';
    protected $shared = true;

    public function boot()
    {
        $event_manager = new Manager;

        $event_manager->attach("view:afterRender",
            function (
                Event $event,
                View $dispatcher,
                $exception
            ) {
                $flash = $dispatcher->getDI()->get('flash');
                $flash->destroy();
            }
        );

        di()->get('view')->setEventsManager($event_manager);

        return $this;
    }

    public function register()
    {
        $view = new View;

        $view->setViewsDir(config()->path->views);

        $view->registerEngines([
            '.phtml'     => Php::class,
            '.volt'      => VoltAdapter::class,
            '.blade.php' => BladeAdapter::class,
        ]);

        return $view;
    }
}
