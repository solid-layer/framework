<?php
namespace Clarity\Lang;

use Clarity\Providers\ServiceProvider;

class LangServiceProvider extends ServiceProvider
{
    protected $alias  = 'lang';
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
