<?php
namespace Clarity\Support\Phalcon\Mvc;

use Phalcon\Mvc\Router as BaseRouter;

class Router extends BaseRouter
{
    public function __construct($bool)
    {
        parent::__construct($bool);
    }

    public function style($class, $remove_action_suffix = true)
    {
        $class = "\\Clarity\\Support\\Phalcon\\Mvc\\RouteStyler\\$class\\$class";

        return new $class($this, $remove_action_suffix);
    }
}
