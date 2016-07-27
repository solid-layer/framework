<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phalconslayer.readme.io
 */

/**
 */
namespace Clarity\Support\Phalcon\Mvc;

use Phalcon\Tag;
use Phalcon\Mvc\View as BaseView;
use Clarity\Support\WithMagicMethodTrait;
use Clarity\Exceptions\ViewFileNotFoundException;

/**
 * This class extends the existing Phalcon\Mvc\View.
 *
 * We wrap the parent class to be able to create/inject new functions
 */
class View extends BaseView
{
    use WithMagicMethodTrait;

    const LEVEL_NO_RENDER = 0;
    const LEVEL_ACTION_VIEW = 1;
    const LEVEL_BEFORE_TEMPLATE = 2;
    const LEVEL_LAYOUT = 3;
    const LEVEL_AFTER_TEMPLATE = 4;
    const LEVEL_MAIN_LAYOUT = 5;

    /**
     * Replacing dots into slashes.
     *
     * @param  string $path The dotted path
     * @return string
     */
    protected function changeDotToSlash($path)
    {
        $path = str_replace('.', '/', $path);

        return $path;
    }

    /**
     * This validates template if exists.
     *
     * @param  string $path The path needed to validate if
     * atleast a template file exists
     * @return bool
     */
    protected function checkViewPath($path)
    {
        $full_path = di()->get('view')->getViewsDir().$path;

        $result = glob($full_path.'.*');

        if (! $result) {
            throw new ViewFileNotFoundException(
                'Views file path('.$full_path.') not found.'
            );
        }
    }

    /**
     * This calls the pick() function which we basically wrap it based
     * on our needs.
     *
     * @param  string $path The template path to use
     * @param  mixed $records The data to be passed going to the template
     * @return mixed
     */
    public function make($path, $records = [])
    {
        $path = $this->changeDotToSlash($path);
        $this->checkViewPath($path);

        $this->batch($records);

        return $this->pick($path);
    }

    /**
     * This injects a variable going to view.
     *
     * @param  string $key The variable name
     * @param  string|bool|int|mixed $val The value of variable
     * @return mixed
     */
    public function with($key, $val)
    {
        return $this->setVar($key, $val);
    }

    /**
     * This injects an array going to view to set as variable in it.
     *
     * @param  string $array The data to be passed going to the template
     * @return mixed
     */
    public function batch($array)
    {
        return $this->setVars($array);
    }

    /**
     * This will fill an existing form element to set a default/persist
     * form value.
     *
     * @param string $key The variable name
     * @param string $val The value of variable
     * @return mixed
     */
    public function formDefault($key, $val)
    {
        Tag::setDefault($key, $val);

        return $this;
    }

    /**
     * This will fill an existing form element to set a default/persist
     * form values.
     *
     * @param array $values An array of variables with values in it
     * @param bool $merge To override/merge an existing tag value
     * @return mixed
     */
    public function formDefaults($values, $merge = false)
    {
        Tag::setDefaults($values, $merge);

        return $this;
    }

    /**
     * This returns a raw php/html.
     *
     * @param  string $path The template path to use
     * @param  mixed $records The data to be passed going to the template
     * @return string
     */
    public function take($path, $records = [])
    {
        $view = $this->changeDotToSlash($path);

        ob_start();
        $this->partial($view, $records);

        return ob_get_contents();
        // return $this->getRender(null, $view, $records);
    }
}
