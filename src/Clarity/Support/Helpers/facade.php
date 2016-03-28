<?php

if (!function_exists('application')) {
    function application()
    {
        return di()->get('application');
    }
}

if (!function_exists('auth')) {
    function auth()
    {
        return di()->get('auth');
    }
}

if (!function_exists('cache')) {
    function cache($option = null)
    {
        $cache = di()->get('cache');

        if (is_string($option)) {
            return $cache->get($option);
        }

        if (is_array($option)) {

            if (!isset($option[0]) || !isset($option[1])) {
                throw new InvalidArgumentException("Array must have index[0] for cache alias and index[1] for the value");
            }

            $cache->save($option[0], $option[1]);

            return true;
        }

        return $cache;
    }
}

if (!function_exists('config')) {
    function config($option = null, $merge = true)
    {
        $config = di()->get('config');

        # here, if the $option is null
        # we should directly pass the di 'config'
        if ($option === null) {
            return $config;
        }

        # here, if the option is array
        # it should interpreted as updating the di 'config'
        # current structure
        if (is_array($option)) {

            $new_config = [];

            if ($merge === true) {
                $config->merge(new Phalcon\Config($option));
                $new_config = $config->toArray();
            } else {
                $new_config = array_replace_recursive(
                    $config ? $config->toArray() : [],
                    $option
                );
            }

            # we need to re-initialize the config
            di()->set('config', function () use ($new_config) {
                return new Phalcon\Config($new_config);
            });

            return true;
        }

        # recursively point to the last config
        # by iterating the config and applying object
        # method chaining call
        $exploded_path = explode('.', $option);

        $last = $config;

        foreach ($exploded_path as $p) {
            $last = $last->{$p};
        }

        return $last;
    }
}

if (!function_exists('db')) {
    function db()
    {
        return di()->get('db');
    }
}

if (!function_exists('dispatcher')) {
    function dispatcher()
    {
        return di()->get('dispatcher');
    }
}

if (!function_exists('filter')) {
    function filter()
    {
        return di()->get('filter');
    }
}

if (!function_exists('flash')) {
    function flash()
    {
        return di()->get('flash');
    }
}

if (!function_exists('flash_bag')) {
    function flash_bag()
    {
        return di()->get('flash_bag');
    }
}

if (!function_exists('flysystem')) {
    function flysystem($path = null)
    {
        $flysystem = di()->get('flysystem');

        # here, if there is assigned path
        # it is the path to access the requested file
        if ($path !== null) {
            return $flysystem->get($path);
        }

        return $flysystem;
    }
}

if (!function_exists('flysystem_manager')) {
    function flysystem_manager($path = null)
    {
        # here, if there is assigned path
        # we should directly create an instance
        # based on the $path provided
        # whilist the adapter is 'local'
        if ($path !== null) {
            return new League\Flysystem\Filesystem(
                new League\Flysystem\Adapter\Local($path, 0)
            );
        }

        return di()->get('flysystem_manager');
    }
}

if (!function_exists('log')) {
    function log()
    {
        return di()->get('log');
    }
}

if (!function_exists('queue')) {
    function queue()
    {
        return di()->get('queue');
    }
}

if (!function_exists('redirect')) {
    function redirect($to = null)
    {
        $redirect = di()->get('redirect');
        if ($to === null) {
            return $redirect;
        }

        return $redirect->to($to);
    }
}

if (!function_exists('request')) {
    function request()
    {
        return di()->get('request');
    }
}

if (!function_exists('response')) {
    function response()
    {
        return di()->get('response');
    }
}

if (!function_exists('route')) {
    function route($name = null, $params = [])
    {
        if ($name === null) {
            return di()->get('router');
        }

        return url()->route($name, $params);
    }
}

if (!function_exists('security')) {
    function security()
    {
        return di()->get('security');
    }
}

if (!function_exists('session')) {
    function session()
    {
        return di()->get('session');
    }
}

if (!function_exists('tag')) {
    function tag()
    {
        return di()->get('tag');
    }
}

if (!function_exists('url')) {
    function url($href = null, $params = [])
    {
        $url = di()->get('url');

        if ($href === null) {
            return $url;
        }

        return $url->get($href, $params);
    }
}

if (!function_exists('view')) {
    function view($path = null, $params = [])
    {
        $view = di()->get('view');

        if ($path === null) {
            return $view;
        }

        return $view->make($path, $params);
    }
}
