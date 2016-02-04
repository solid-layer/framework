<?php
namespace Clarity\Support\Http\Middleware;

use InvalidArgumentException;

class Kernel
{
    protected $middlewares = [];

    public function __construct($middlewares = [])
    {
        $this->middlewares = $middlewares;
    }

    public function get($alias)
    {
        if ( ! isset($this->middlewares[$alias]) ) {
            throw new InvalidArgumentException(
                "Middleware based on alias [$alias] not found."
            );
        }

        return $this->middlewares[$alias];
    }

    public function set($middlewares)
    {
        $this->middlewares = $middlewares;

        return $this;
    }
}
