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
namespace Clarity\Lang;

use Clarity\Providers\ServiceProvider;

class LangServiceProvider extends ServiceProvider
{
    protected $alias = 'lang';
    protected $shared = false;

    public function register()
    {
        $language = config()->app->lang;

        $translation = new Lang($dir);
        $translation
            ->setLanguage($language)
            ->setLangDir(config()->path->lang);

        return $translation;
    }
}
