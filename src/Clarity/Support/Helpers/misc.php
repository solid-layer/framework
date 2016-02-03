<?php

if (!function_exists('env')) {
    function env($const, $default = '')
    {
        $val = getenv($const);
        if (empty( $val )) {
            $val = $default;
        }

        return $val;
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field()
    {
        return tag()->hiddenField([
            security()->getTokenKey(),
            'value' => security()->getToken(),
        ]);
    }
}

if (!function_exists('slayer_process_time')) {
    function slayer_process_time()
    {
        # TODO: remove the SLAYER_START, it should be passed on the
        # parameter, and the function name should be renamed to
        # "compute_processing_time(<microtime>)"

        return microtime(true) - SLAYER_START;
    }
}

if (!function_exists('iterate_require')) {
    function iterate_require(array $files)
    {
        $results = [];

        foreach ($files as $file) {
            $results[basename($file, '.php')] = require $file;
        }

        return $results;
    }
}

if (!function_exists('stubify')) {
    function stubify($content, $params)
    {
        foreach ($params as $key => $value) {
            $content = str_replace('{'.$key.'}', $value, $content);
        }

        return $content;
    }
}

if (!function_exists('path_to_namespace')) {
    function path_to_namespace($path)
    {
        $path = trim(str_replace('/', ' ', $path));
        $exploded_path = explode(' ', $path);

        $ret = [];

        foreach ($exploded_path as $word) {
            $ret[] = ucfirst($word);
        }

        return studly_case(implode('\\', $ret));
    }
}

if (!function_exists('url_trimmer')) {
    function url_trimmer($url)
    {
        return rtrim(preg_replace('/([^:])(\/{2,})/', '$1/', $url), '/');
    }
}

if (!function_exists('logging_extension')) {
    function logging_extension()
    {
        $ext = '';

        switch ($logging_time = config()->app->logging_time) {
            case 'hourly':
                $ext = date('Y-m-d H-00-00');
            break;

            case 'daily':
                $ext = date('Y-m-d 00-00-00');
            break;

            case 'monthly':
                $ext = date('Y-m-0 00-00-00');
            break;

            case '':
            case null:
            case false:
                return $ext;
            break;

            default:
                throw new Exception("Logging time[".$logging_time."] not found");
            break;
        }

        return $ext;
    }
}

if (!function_exists('str_last_remove')) {
    function str_last_remove($fullstring, $word_to_remove)
    {
        return preg_replace('/'.$fullstring.'$/', '', $word_to_remove);
    }
}
