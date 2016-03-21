<?php
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
