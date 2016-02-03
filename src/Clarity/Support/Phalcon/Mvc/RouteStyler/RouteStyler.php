<?php
namespace Clarity\Support\Phalcon\Mvc\RouteStyler;

class RouteStyler
{
    protected function createRoute($directive, $properties, $verb = null)
    {
        $parsed = $this->parse($directive, $properties, $verb);


        # now extract the parsed route
        # the $parsed should contain
        # - phalcon 'verb'
        $function = 'add'.$parsed['verb'];

        # - phalcon 'directive'
        $directive = $parsed['directive'];

        # - phalcon 'properties'
        $properties = $parsed['properties'];

        # - and the phalcon 'setName'
        $se_name = null;

        if ( isset($parsed['setName']) ) {
            $set_name = $parsed['setName'];
        }


        # now, build the route using the 'router' provided object

        $route = $this->getRouter()->{$function}(
            url_trimmer($directive),
            $properties
        );

        if ( strlen($set_name) != 0 ) {
            $route->setName($set_name);
        }

        return $route;
    }
}
