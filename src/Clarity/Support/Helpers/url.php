<?php

if (!function_exists('base_uri')) {
    function base_uri($extend_path = null)
    {
        return url()->getScheme().url_trimmer(
            url()->getHost().'/'.$extend_path
        );
    }
}

if (!function_exists('back')) {
    function back()
    {
        return di()->get('url')->previous();
    }
}
