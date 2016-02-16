<?php
namespace Clarity\Providers;

use Phalcon\Mvc\Collection\Manager as BaseCollectionManager;

class CollectionManager extends ServiceProvider
{
    protected $alias = 'collectionManager';
    protected $shared = true;

    public function register()
    {
        return new BaseCollectionManager;
    }
}
