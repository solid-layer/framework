<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

use MongoClient;

/**
 * This provider instantiates the @see \MongoClient.
 */
class Mongo extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $this->app->singleton('mongo.selected_adapter', function () {
            $adapters = config('database.nosql_adapters');

            $selected_adapter = config()->app->nosql_adapter;

            if (empty($selected_adapter)) {
                return false;
            }

            if (! isset($adapters[$selected_adapter])) {
                return false;
            }

            return $adapters[$selected_adapter];
        });

        $this->app->singleton('mongo', function ($app) {
            if (! class_exists(MongoClient::class)) {
                return $this;
            }

            $adapter = $app->make('mongo.selected_adapter');

            if (! $adapter) {
                return $this;
            }

            $host = $adapter->host;
            $port = $adapter->port;
            $username = $adapter->username;
            $password = $adapter->password;

            $str = 'mongodb://'.$username.':'.$password.'@'.$host.':'.$port;

            if (strlen($username) < 1 && strlen($password) < 1) {
                $str = 'mongodb://'.$host.':'.$port;
            }

            $mongo = new MongoClient($str);

            return $mongo->selectDB($adapter->dbname);
        });
    }
}
