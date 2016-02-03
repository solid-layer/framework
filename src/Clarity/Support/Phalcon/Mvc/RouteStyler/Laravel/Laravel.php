<?php
namespace Clarity\Support\Phalcon\Mvc\RouteStyler\Laravel;

use Clarity\Contracts\RouteStyler\RouteStylerInterface;
use Clarity\Support\Phalcon\Mvc\RouteStyler\RouteStyler;

class Laravel extends RouteStyler implements RouteStylerInterface
{
    private $prefix;
    protected $router;

    public function __construct($router)
    {
        $this->router = $router;
    }

    public function any($directive, $properties, $verb = '')
    {
        return parent::createRoute(
            $this->prefix.'/'.$directive,
            $properties,
            $verb
        );
    }

    public function get($directive, $properties)
    {
        return parent::createRoute(
            $this->prefix.'/'.$directive,
            $properties,
            __FUNCTION__
        );
    }

    public function post($directive, $properties)
    {
        return parent::createRoute(
            $this->prefix.'/'.$directive,
            $properties,
            __FUNCTION__
        );
    }

    public function controller($directive, $controller)
    {
        $methods = get_class_methods($controller);

        $exempted_functions = [
            "__get",
            "setDI",
            "getDI",
            "middleware",
            "__construct",
            "setEventsManager",
            "getEventsManager",
        ];

        foreach ($methods as $idx => $method) {

            if ( in_array($method, $exempted_functions) ) {
                unset($methods[$idx]);
            }
        }

        $verbs = [
            'get'  => 'Get',
            'post' => 'Post',
            'any'  => '',
        ];

        $accepted_methods = [];

        foreach ($methods as $idx => $method) {

            # e.g ($verbs as 'get' => 'Get')
            foreach ($verbs as $verb => $route_directive) {

               $is_matched = substr($method, 0, strlen($verb)) === $verb;

               if ( $is_matched ) {

                    $method = new \ReflectionMethod($controller, $method);

                    $arguments = collect(
                        json_decode(
                            json_encode($method->getParameters()),
                            true
                        )
                    )
                    ->flatten()
                    ->toArray();

                    $extended_path = substr($method->getName(), strlen($verb));

                    $slugged_url = str_slug(
                        str_replace('_', ' ', snake_case(
                            $extended_path
                        )),
                        '-'
                    );


                    foreach ($arguments as $arg) {
                        $slugged_url .= '/{'.$arg.'}';
                    }

                    $accepted_methods[$method->getName()] = [
                        'directive'   => $route_directive,
                        'slugged_url' => url_trimmer($directive .'/'.$slugged_url),
                        'parameters'  => [
                            'uses' => class_basename($controller).'@'.$method->getName(),
                        ],
                    ];

                    continue 2;
               }
            }
        }

        foreach ($accepted_methods as $method => $prop) {

            $this->any(
                $prop['slugged_url'],
                $prop['parameters'],
                $prop['directive']
            );
        }

        return $accepted_methods;
    }

    public function prefix($prefix, $callback)
    {
        $self = new self($this->router);
        $self->setPrefix(url_trimmer($this->prefix . $prefix));

        return call_user_func($callback, $self);
    }

    protected function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function parse($directive, $properties, $verb)
    {
        $uses = [];
        $route_name = null;

        if ( is_string($properties) ) {

            $uses = explode('@', $properties);

        } elseif ( is_array($properties) ) {

            if ( isset($properties['as']) ) {
                $route_name = $properties['as'];
            }

            if (isset( $properties['uses'] )) {
                $uses = explode('@', $properties['uses']);
            }

        }

        if ( empty($uses) ) {
            throw new InvalidArgumentException("Invalid controller properties");
        }


        $module     = null;
        $controller = null;
        $action     = null;

        if ( count($uses) == 2 ) {

            $controller = $uses[0];
            $action = $uses[1];

        } elseif ( count($uses) == 3 ) {

            $module = $uses[0];
            $controller = $uses[1];
            $action = $uses[2];

        } else {
            throw new InvalidArgumentException("Invalid property count upon parsing");
        }


        # - this strips out all the word 'Controller' and 'Action'

        $controller = str_replace(
            'Controller',
            '',
            $controller
        );

        $action = str_replace(
            'Action',
            '',
            $action
        );


        unset($properties['as']);
        unset($properties['uses']);

        $properties['action'] = $action;
        $properties['controller'] = $controller;

        if ( !empty($module) ) {
            $properties['module'] = $module;
        }

        return [
            'verb'       => ucfirst($verb),
            'directive'  => $directive,
            'properties' => $properties,
            'setName'    => $route_name,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getRouter()
    {
        return $this->router;
    }
}