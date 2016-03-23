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
    function cache()
    {
        return di()->get('cache');
    }
}

if (!function_exists('config')) {
    function config($option = null)
    {
        $config = di()->get('config');

        if (is_array($option)) {

            $new_config = array_replace_recursive(
                config() ? config()->toArray() : [],
                $option
            );

            # we need to re-initialize the config
            # config()->merge is not a recursive process
            # it will always add record that is
            # non-associative array
            di()->set('config', function () use ($new_config) {
                return new Phalcon\Config($new_config);
            });

            return true;
        }

        if ($option === null) {
            return $config;
        }

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
    function flysystem()
    {
        return di()->get('flysystem');
    }
}

if (!function_exists('flysystem_manager')) {
    function flysystem_manager()
    {
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
