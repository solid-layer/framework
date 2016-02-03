<?php
namespace Clarity\Contracts\RouteStyler;

interface RouteStylerInterface
{
    /**
     * The constructor that initialize every data
     *
     * @param mixed $router the passed di()-get('router') object
     */
    public function __construct($router);

    /**
     * Your function to parse the properties provided in the
     *
     * @param  string $directive  the url style
     * @param  array  $properties your router propertity style
     * @param  string $verb       the header property such as GET, POST
     *
     * @return array return a Phalcon 'properties' and the 'name'
     */
    public function parse($directive, $properties, $verb);

    /**
     * @return mixed the base property $router
     */
    public function getRouter();
}
