<?php

namespace Clarity\Support\Queue;

/**
 * The queue handler.
 */
class Queue
{
    /**
     * @var mixed|\Clarity\Support\Queue\DriverInterface $adapter
     */
    private $adapter;

    /**
     * Constructor.
     *
     * @param mixed|\Clarity\Support\Queue\DriverInterface $adapter
     */
    public function __construct(DriverInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Callable.
     *
     * @param string $func
     * @param array $params
     */
    public function __call($func, $params)
    {
        return call_user_func_array([$this->adapter, $func], $params);
    }
}
