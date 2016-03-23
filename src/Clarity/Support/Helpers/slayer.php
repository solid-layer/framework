<?php

if (!function_exists('di')) {
    function di($alias = null)
    {
        $default = Phalcon\DI::getDefault();

        if (is_string($alias)) {
            return $default->get($alias);
        }

        # if the alias is array then we must check the array
        # passed in
        if (is_array($alias)) {

            if (
                !isset($alias[0]) ||
                !isset($alias[1])
            ) {
                throw new InvalidArgumentException("Provider alias or callback not found");
            }

            $default->set(
                $alias[0],
                $alias[1],
                isset($alias[2]) ? $alias[2] : false
            );

            return $default->get($alias[0]);
        }

        # or just return the default thing
        return $default;
    }
}
