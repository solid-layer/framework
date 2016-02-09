<?php
namespace Clarity\View\Volt;

use Phalcon\DiInterface;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Mvc\ViewBaseInterface;

class VoltAdapter extends Volt
{
    private $functions = [
        # misc
        'di', 'env', 'csrf_field',
        'dd', 'config',

        # facades
        'security', 'tag', 'route',
        'response', 'view', 'config',
        'config', 'url', 'request',

        # path
        'base_uri',
    ];

    public function __construct(
        ViewBaseInterface $view,
        DiInterface $di = NULL
    ) {
        parent::__construct($view, $di);

        $debug = false;

        if (
            config()->app->debug === 'true' ||
            config()->app->debug === true
        ) {
            $debug = true;
        }

        $this->setOptions([
            'compiledSeparator' => '_',
            'compiledPath'      => config()->path->storage_views,
            'compileAlways'     => $debug,
        ]);

        foreach ($this->functions as $func) {
            $this->getCompiler()->addFunction($func, $func);
        }
    }
}
