<?php

namespace Clarity\Support\Queue;

class Queue
{
    private $adapter;

    public function __construct(DriverInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function __call($func, $params)
    {
        return call_user_func_array([$this->adapter, $func], $params);
    }
}
