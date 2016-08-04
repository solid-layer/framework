<?php

namespace Clarity\Support\Queue\Beanstalkd;

use Phalcon\Queue\Beanstalk as BaseBeanstalk;
use Clarity\Support\Queue\DriverInterface;

class Beanstalkd implements DriverInterface
{
    private $config;
    private $instance;

    public function __construct($config)
    {
        $this->config = $config;
        $this->instance = new BaseBeanstalk($config);
    }

    public function __call($func, $params)
    {
        return call_user_func_array([$this->instance, $func], $params);
    }
}
