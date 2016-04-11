<?php

if (!function_exists('base_uri')) {

    /**
     * This returns the base uri of the current module, if passed an argument
     * it automatically appended as uri
     *
     * @param $extend_path To provide uri
     * @return string
     */
    function base_uri($extend_path = null)
    {
        return url()->getScheme().url_trimmer(
            url()->getHost().'/'.$extend_path
        );
    }
}

if (!function_exists('back')) {

    /**
     * This returns the previous request url
     *
     * @return string
     */
    function back()
    {
        return di()->get('url')->previous();
    }
}
