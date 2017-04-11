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
    protected $alias = 'mongo';

    /**
     * {@inheridoc}.
     */
    protected $shared = false;

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        if (! class_exists(MongoClient::class)) {
            return $this;
        }

        $adapters = config()->database->nosql_adapters;

        $selected_adapter = config()->app->nosql_adapter;

        if (
            empty($selected_adapter) ||
            ! isset($adapters[$selected_adapter])
        ) {
            return $this;
        }

        $adapter = $adapters[$selected_adapter];

        $host = $adapter->host;
        $port = $adapter->port;
        $username = $adapter->username;
        $password = $adapter->password;
        $dbname = $adapter->dbname;

        $str = 'mongodb://'.$username.':'.$password.'@'.$host.':'.$port;

        if (strlen($username) < 1 && strlen($password) < 1) {
            $str = 'mongodb://'.$host.':'.$port;
        }

        $mongo = new MongoClient($str);

        return $mongo->selectDB($dbname);
    }
}
