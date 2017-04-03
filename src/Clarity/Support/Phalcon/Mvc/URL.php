<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Support\Phalcon\Mvc;

use Phalcon\Mvc\Url as BaseURL;

/**
 * {@inheritdoc}
 */
class URL extends BaseURL
{
    /**
     * Create an instance of this class via static call.
     *
     * @return mixed URL
     */
    public static function getInstance()
    {
        $instance = new static;

        $instance->setBaseUri($instance->getFullUrl().'/');

        return $instance;
    }

    /**
     * Check if it request is an https.
     *
     * @return bool
     */
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

    /**
     * Get the scheme.
     *
     * @param  string $module
     * @return string
     */
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

    /**
     * Get the host.
     *
     * @param  string $module
     * @return string
     */
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

    /**
     * Get the full url.
     *
     * Combining getScheme() and getHost()
     *
     * @param  string $module
     * @return string
     */
    public function getFullUrl($module = null)
    {
        return url_trimmer(
            $this->getScheme($module).'/'.$this->getHost($module)
        );
    }

    /**
     * Get the request uri.
     *
     * @return string
     */
    public function getRequestUri()
    {
        return url_trimmer($_SERVER['REQUEST_URI']);
    }

    /**
     * Get the previous url.
     *
     * @return string
     */
    public function previous()
    {
        return url_trimmer($_SERVER['HTTP_REFERER']);
    }

    /**
     * The url builder based on your route's name.
     *
     * @param string $name The route name
     * @param mixed $params A uri parameters for this route
     * @param mixed $raw A raw parameters for your route
     * @return string
     */
    public function route($for, $params = [], $raw = [])
    {
        # inject the $for inside params
        $params['for'] = $for;

        # build the pretty uri's
        $generated = $this->get($params);

        # then get the $raw too
        return $this->get($generated, $raw);
    }

    /**
     * Get the current url.
     *
     * @return string
     */
    public function current()
    {
        return url_trimmer($this->getBaseUri().'/'.$this->getRequestUri());
    }

    /**
     * Append a path to your base uri.
     *
     * @param  string $path
     * @return string
     */
    public function to($path)
    {
        return url_trimmer($this->getBaseUri().'/'.$path);
    }
}
