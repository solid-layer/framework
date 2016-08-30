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
namespace Clarity\Support\Phalcon\Mvc;

use Phalcon\Mvc\Url as BaseURL;

class URL extends BaseURL
{
    public static function getInstance()
    {
        $instance = new static;

        $instance->setBaseUri($instance->getFullUrl().'/');

        return $instance;
    }

    protected function hasHttps()
    {
        if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] === 'https') {
            return true;
        }

        if (
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https'
        ) {
            return true;
        }

        if (
            isset($_SERVER['REQUEST_SCHEME']) &&
            $_SERVER['REQUEST_SCHEME'] === 'https'
        ) {
            return true;
        }

        return false;
    }

    public function getScheme($module = null)
    {
        if ($module === null) {
            $module = di()->get('application')->getDefaultModule();

            if ($this->hasHttps()) {
                return 'https://';
            }
        }

        # if still null, return http://
        if ($module === null) {
            return 'http://';
        }

        $ssl_modules = config('app.ssl')->toArray();

        if (isset($ssl_modules[$module]) && $ssl_modules[$module] === true) {
            return 'https://';
        }

        return 'http://';
    }

    public function getHost($module = null)
    {
        if ($module === null) {
            $module = di()->get('application')->getDefaultModule();

            if (isset($_SERVER['HTTP_HOST'])) {
                return $_SERVER['HTTP_HOST'];
            }
        }

        # if still null, return localhost
        if ($module === null) {
            return 'localhost';
        }

        # get all url's
        $uri_modules = config()->app->base_uri->toArray();

        if (isset($uri_modules[$module])) {
            return $uri_modules[$module];
        }

        return 'localhost';
    }

    public function getFullUrl($module = null)
    {
        return url_trimmer(
            $this->getScheme($module).'/'.$this->getHost($module)
        );
    }

    public function getRequestUri()
    {
        return url_trimmer($_SERVER['REQUEST_URI']);
    }

    public function previous()
    {
        return url_trimmer($_SERVER['HTTP_REFERER']);
    }

    public function route($for, $params = [], $pres = [])
    {
        $params['for'] = $for;

        return $this->get($params, $pres);
    }

    public function current()
    {
        return url_trimmer($this->getBaseUri().'/'.$this->getRequestUri());
    }

    public function to($path)
    {
        return url_trimmer($this->getBaseUri().'/'.$path);
    }
}
