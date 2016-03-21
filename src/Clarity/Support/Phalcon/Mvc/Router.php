<?php
namespace Clarity\Support\Phalcon\Mvc;

use Phalcon\Mvc\Router as BaseRouter;

class Router extends BaseRouter
{
    public function __construct($bool)
    {
        parent::__construct($bool);
    }
}
