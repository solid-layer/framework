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
namespace Clarity\View\Blade;

use Phalcon\DiInterface;
use Jenssegers\Blade\Blade;
use Phalcon\Mvc\View\Engine;
use Phalcon\Mvc\ViewBaseInterface;
use Phalcon\Mvc\View\EngineInterface;

class BladeAdapter extends Engine implements EngineInterface
{
    private $blade;

    public function __construct(ViewBaseInterface $view, DiInterface $di = null)
    {
        parent::__construct($view, $di);

        $this->blade = new Blade(
            $this->getView()->getViewsDir(),
            storage_path('views').'/'
        );
    }

    private function buildPath($path)
    {
        $path = str_replace($this->getView()->getViewsDir(), '', $path);
        $path = str_replace('.blade.php', '', $path);

        return $path;
    }

    protected function getBlade()
    {
        return $this->blade;
    }

    public static function blade()
    {
        return (new static)->getBlade();
    }

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
