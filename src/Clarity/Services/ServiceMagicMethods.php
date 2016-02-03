<?php
namespace Clarity\Services;

use InvalidArgumentException;

trait ServiceMagicMethods
{
    public function __get($name)
    {
        if ( di()->has($name) === false ) {
            throw new InvalidArgumentException("Dependency Injection [$name] not found");
        }

        return di()->get($name);
    }
}
