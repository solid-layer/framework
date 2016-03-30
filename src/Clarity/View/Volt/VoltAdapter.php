<?php
namespace Clarity\View\Volt;

use Phalcon\DiInterface;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Mvc\ViewBaseInterface;

class VoltAdapter extends Volt
{
    private $functions = [
        # misc
        'di', 'env',    'csrf_field',
        'dd', 'config',

        # facades
        'auth',      'cache',     'config',
        'db',        'filter',    'flash',
        'flash_bag', 'flysystem', 'flysystem_manager',
        'log',       'queue',     'redirect',
        'request',   'response',  'route',
        'security',  'session',   'tag',
        'url',       'view',

        # path
        'base_uri',

        # php
        'strtotime',
    ];

    public function __construct(
        ViewBaseInterface $view,
        DiInterface $di = NULL
    ) {
        parent::__construct($view, $di);

        $debug = false;

        if (config()->app->debug) {
            $debug = true;
        }

        $this->setOptions([
            'compiledSeparator' => '_',
            'compiledPath'      => storage_path('views').'/',
            'compileAlways'     => $debug,
        ]);

        foreach ($this->functions as $func) {
            $this->getCompiler()->addFunction($func, $func);
        }
    }
}
