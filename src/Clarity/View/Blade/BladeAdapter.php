<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\View\Blade;

use Phalcon\DiInterface;
use Jenssegers\Blade\Blade;
use Phalcon\Mvc\View\Engine;
use Phalcon\Mvc\ViewBaseInterface;
use Phalcon\Mvc\View\EngineInterface;

/**
 * The blade adapter for View Templating/Engine.
 */
class BladeAdapter extends Engine implements EngineInterface
{
    /**
     * @var mixed
     */
    private $blade;

    /**
     * Contructor.
     *
     * @param mixed|\Phalcon\Mvc\ViewBaseInterface $view
     * @param mixed|\Phalcon\DiInterface $di
     */
    public function __construct(ViewBaseInterface $view, DiInterface $di = null)
    {
        parent::__construct($view, $di);

        $this->blade = new Blade(
            $this->getView()->getViewsDir(),
            storage_path('views').'/'
        );
    }

    /**
     * Build the path based on the provided string.
     *
     * @param string $path
     * @return string
     */
    private function buildPath($path)
    {
        $path = str_replace($this->getView()->getViewsDir(), '', $path);
        $path = str_replace('.blade.php', '', $path);

        return $path;
    }

    /**
     * Get the blade instance.
     *
     * @return mixed|\Jenssegers\Blade\Blade
     */
    protected function getBlade()
    {
        return $this->blade;
    }

    /**
     * Get the blade instance in static way.
     *
     * @return mixed|\Jenssegers\Blade\Blade
     */
    public static function blade()
    {
        return (new static)->getBlade();
    }

    /**
     * Render the path provided.
     *
     * @param string $path
     * @param array $params
     * @param bool $must_clean
     * @return void
     */
    public function render($path, $params, $must_clean = null)
    {
        $content = $this->getBlade()
            ->make($this->buildPath($path), $params)
            ->render();

        if ($must_clean) {
            $this->_view->setContent($content);
        } else {
            echo $content;
        }
    }
}
