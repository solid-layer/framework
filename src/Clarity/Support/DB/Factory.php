<?php
namespace Clarity\Support\DB;

use Faker\Factory as FakerFactory;

class Factory
{
    private $seed_factory;

    public function __construct($seed_factory)
    {
        $this->seed_factory = $seed_factory;
    }

    public function define($class, $callback, $loop = 1)
    {
        for ($i = 1; $i <= $loop; $i++) {

            $data = call_user_func($callback, FakerFactory::create());
            $instance = new $class;
            $instance->create($data);

            $this->seed_factory->comment("\nLoop #".$i.": \n   ".json_encode($data)."\n");
        }

        return $this;
    }
}
