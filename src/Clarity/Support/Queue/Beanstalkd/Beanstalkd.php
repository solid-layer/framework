<?php

namespace Clarity\Support\Queue\Beanstalkd;

use Phalcon\Queue\Beanstalk as BaseBeanstalk;
use Clarity\Support\Queue\DriverInterface;

/**
 * {@inheritdoc}
 */
class Beanstalkd implements DriverInterface
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var mixed|\Phalcon\Queue\Beanstalk
     */
    private $instance;

    /**
     * Contructor.
     *
     * @param array $config
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->instance = new BaseBeanstalk($config);
    }

    /**
     * Callable.
     *
     * @param string $func
     * @param array $params
     */
    public function __call($func, $params)
    {
        return call_user_func_array([$this->instance, $func], $params);
    }
}
