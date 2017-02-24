<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */
if (! function_exists('env')) {

    /**
     * This handles the the global environment variables, it acts as getenv()
     * that handles the .env file in the root folder of a project.
     *
     * @param string $const The constant variable
     * @param string|bool|mixed $default The default value if it is empty
     * @return mixed The value based on requested variable
     */
    function env($const, $default = null)
    {
        $val = getenv($const);

        if (empty($val)) {
            $val = $default;
        }

        switch (strtolower($val)) {
            case 'true':
                return true;
            break;

            case 'false':
                return false;
            break;

            case 'empty':
                return '';
            break;

            case 'null':
                return;
            break;
        }

        return $val;
    }
}

if (! function_exists('csrf_field')) {

    /**
     * This generates a csrf field for html forms.
     *
     * @return string
     */
    function csrf_field()
    {
        return tag()->hiddenField([
            security()->getTokenKey(),
            'value' => security()->getToken(),
        ]);
    }
}

if (! function_exists('processing_time')) {

    /**
     * This calculates the processing time based on the starting time.
     *
     * @param int $starting_time The microtime it starts
     * @return string
     */
    function processing_time($starting_time = 0)
    {
        return microtime(true) - $starting_time;
    }
}

if (! function_exists('iterate_require')) {

    /**
     * This iterates and require a php files, useful along folder_files().
     *
     * @param mixed $files
     * @return mixed
     */
    function iterate_require(array $files)
    {
        $results = [];

        foreach ($files as $file) {
            $results[basename($file, '.php')] = require $file;
        }

        return $results;
    }
}

if (! function_exists('stubify')) {

    /**
     * This changes a stub format content.
     *
     * @return string
     */
    function stubify($content, $params)
    {
        foreach ($params as $key => $value) {
            $content = str_replace('{'.$key.'}', $value, $content);
        }

        return $content;
    }
}

if (! function_exists('path_to_namespace')) {

    /**
     * This converts a path into a namespace.
     *
     * @return string
     */
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

if (! function_exists('url_trimmer')) {

    /**
     * This trims a url that has multiple slashes and trimming slash at the end.
     *
     * @return string
     */
    function url_trimmer($url)
    {
        return rtrim(preg_replace('/([^:])(\/{2,})/', '$1/', $url), '/');
    }
}

if (! function_exists('logging_extension')) {

    /**
     * This returns an extension name based on the requested logging time.
     *
     * @return string
     */
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
                throw new Exception('Logging time['.$logging_time.'] not found');
            break;
        }

        return $ext;
    }
}

if (! function_exists('is_cli')) {
    function is_cli()
    {
        if (php_sapi_name() === 'cli') {
            return true;
        }

        return false;
    }
}
