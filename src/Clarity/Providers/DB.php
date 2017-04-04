<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

use Exception;
use Monolog\Logger;
use Phalcon\Events\Manager as EventsManager;
use Monolog\Handler\StreamHandler;

/**
 * This provider handles the relational database adapters, that lives inside the
 * configuration file.
 *
 * @see \Phalcon\Db and its related classes provide a simple SQL database interface for Phalcon Framework.
 * The @see \Phalcon\Db is the basic class you use to connect your PHP application to an RDBMS.
 * There is a different adapter class for each brand of RDBMS.
 * This component is intended to lower level database operations.
 * If you want to interact with databases using higher level of abstraction use Phalcon\Mvc\Model.
 * @see \Phalcon\Db is an abstract class.
 * You only can use it with a database adapter like @see \Phalcon\Db\Adapter\Pdo
 */
class DB extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    protected $alias = 'db';

    /**
     * {@inheridoc}.
     */
    protected $shared = true;

    /**
     * Magic method call.
     *
     * Since we're passing the class itself as dependency, when calling
     * a model, the connection is empty. In that moment, we could rely
     * by getting the default connection and do the request method.
     *
     * @param  string $method
     * @param  array $args
     * @return void
     */
    public function __call($method, $args)
    {
        if (method_exists($default = $this->getDefaultConnection(), $method)) {
            return call_user_func_array([$default, $method], $args);
        }
    }

    /**
     * Pull all configurations and return the database connection.
     *
     * @return mixed
     */
    private function getDefaultConnection()
    {
        # get the selected adapter to be our basis
        $selected_adapter = config()->app->db_adapter;

        # here, check selected adapter if empty, then
        # disable this provider
        if (strlen($selected_adapter) == 0 || $selected_adapter === false) {
            return $this;
        }

        return $this->connection($selected_adapter);
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        if (! $this->getDI()->has($this->alias)) {
            $db = $this->getDefaultConnection();

            $this->getDI()->set($this->alias, function () use ($db) {
                return $db;
            }, $this->shared);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        foreach ($this->connections() as $adapter => $options) {
            $db = $this->connection($adapter);

            $this->subRegister($adapter, function () use ($db) {
                return $db;
            }, $this->shared);
        }

        return $this;
    }

    /**
     * Instantiate the class and get the adapter.
     *
     * @param  string $selected_adapter The adapter name
     * @return mixed An adapter to use you
     */
    public function connection($selected_adapter = null)
    {
        if ($selected_adapter === null) {
            return $this->getDefaultConnection();
        }

        $adapters = $this->connections();

        $has_adapter = isset($adapters[$selected_adapter]);

        # here, we must check the adapter, if it does not
        # exists, we should throw an exception error
        if (! $has_adapter) {
            throw new Exception(
                'Database adapter '.$selected_adapter.
                ' not found'
            );
        }

        $adapter = $adapters[$selected_adapter];

        if (isset($adapter['active']) && $adapter['active'] === false) {
            return false;
        }

        $class = $adapter['class'];

        $instance = new $class($adapter['options']);

        $instance->setEventsManager($this->getEventLogger());

        return $instance;
    }

    /**
     * Get the database adapters/connections.
     *
     * @return array
     */
    public function connections()
    {
        return config()
            ->database
            ->adapters
            ->toArray();
    }

    /**
     * An event to log our queries.
     *
     * @return mixed Instatiated event manager
     */
    protected function getEventLogger()
    {
        $event_manager = new EventsManager;

        $event_manager->attach($this->alias, function ($event, $conn) {
            if ($event->getType() == 'beforeQuery') {
                $logging_name = 'db';

                if (logging_extension()) {
                    $logging_name = 'db-'.logging_extension();
                }

                $logger = new Logger('DB');
                $logger->pushHandler(
                    new StreamHandler(
                        storage_path('logs').'/'.$logging_name.'.log',
                        Logger::INFO
                    )
                );

                $variables = $conn->getSQLVariables();

                if ($variables) {
                    $logger->info(
                        $conn->getSQLStatement().
                        ' ['.implode(',', $variables).']'
                    );
                } else {
                    $logger->info($conn->getSQLStatement());
                }
            }
        });

        return $event_manager;
    }
}
