<?php
namespace Clarity\Support\Phalcon\Mvc;

use Phalcon\Mvc\Url as BaseURL;

class URL extends BaseURL
{
    private $app;

    public function __construct()
    {
        $this->app = di()->get('app');
        $this->setBaseUri($this->getScheme() . $this->getHost() . '/');
    }

    public function getScheme()
    {
        if ( config()->app->ssl->{$this->app->getDefaultModule()} ) {
            return 'https://';
        }

        return 'http://';
    }

    public function getHost()
    {
        if ( isset($_SERVER['HTTP_HOST']) ) {
            return $_SERVER['HTTP_HOST'];
        }

        return config()->app->base_uri->{$this->app->getDefaultModule()};
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
        return url_trimmer($this->getBaseUri() . $this->getRequestUri());
    }

    public function to($path)
    {
        return url_trimmer($this->getBaseUri() . '/' . $path);
    }
}
