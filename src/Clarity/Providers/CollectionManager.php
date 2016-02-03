<?php
namespace Clarity\Providers;

use Phalcon\Mvc\Collection\Manager;

class CollectionManager extends ServiceProvider
{
    protected $shared = true;
    protected $alias = 'collectionManager';

    public function register()
    {
        return new Manager;
    }
}
