<?php
namespace Clarity\Support\Phalcon\Mvc;

use InvalidArgumentException;
use Phalcon\Mvc\Url as BaseURL;

class URL extends BaseURL
{
    public static function getInstance()
    {
        $instance = new static;

        $instance->setBaseUri($instance->getFullUrl().'/');

        return $instance;
    }

    public function getScheme($module = null)
    {
        if ( $module === null ) {
            $module = di()->get('application')->getDefaultModule();
        }

        $https = false;

        $ssl_modules = config()->app->ssl->toArray();

        if (
            isset($ssl_modules[$module]) &&
            $ssl_modules[$module] === true
        ) {
            return 'https://';
        }

        return 'http://';
    }

    public function getHost($module = null)
    {
        # only successful if we're not passing any parameter
        # and the server found an index 'HTTP_HOST'
        if (
            isset($_SERVER['HTTP_HOST']) &&
            $module === null
        ) {
            return $_SERVER['HTTP_HOST'];
        }

        if ( $module === null ) {
            $module = di()->get('application')->getDefaultModule();
        }

        # get all url's
        $uri_modules = config()->app->base_uri->toArray();

        if ( !isset($uri_modules[$module]) ) {
            throw new InvalidArgumentException("Module [$module] not found.");
        }

        return config()->app->base_uri->{$module};
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
