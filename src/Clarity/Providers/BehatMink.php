<?php
namespace Clarity\Providers;

use Clarity\TestSuite\Behat\Mink\Mink;

class BehatMink extends ServiceProvider
{
    protected $alias = 'behat_mink';
    protected $shared = false;

    public function register()
    {
        $adapters = config()->test_suite->behat->adapters->toArray();

        return new Mink($adapters);
    }
}
