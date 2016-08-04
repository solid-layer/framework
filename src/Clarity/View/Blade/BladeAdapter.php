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

use Jenssegers\Blade\Blade;
use Phalcon\Mvc\View\Engine;

class BladeAdapter extends Engine
{
    public function render($path, $params = [])
    {
        $path = str_replace($this->getView()->getViewsDir(), '', $path);
        $path = str_replace('.blade.php', '', $path);

        $blade = new Blade(
            $this->getView()->getViewsDir(),
            storage_path('views').'/'
        );

        di()
            ->get('view')
            ->setContent(
                $blade
                    ->make($path, $params)
                    ->render()
            );
    }
}
