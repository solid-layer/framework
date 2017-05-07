<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Lang;

use Clarity\Providers\ServiceProvider;

/**
 * The 'lang' service provider.
 */
class LangServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton('lang', function () {
            $language = config()->app->lang;

            $translation = new Lang();
            $translation
                ->setLanguage($language)
                ->setLangDir(config()->path->lang);

            return $translation;
        });
    }
}
