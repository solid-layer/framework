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
 * @subpackage Clarity\View\Volt
 */
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
        'lang',      'log',       'queue',
        'redirect',  'request',   'response',
        'route',     'security',  'session',
        'tag',       'url',       'view',

        # path
        'base_uri',

        # php
        'strtotime',
    ];

    public function __construct(
        ViewBaseInterface $view,
        DiInterface $di = null
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
