<?php
namespace Clarity\Providers;

use Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Phalcon\Events\Manager as EventsManager;

class DB extends ServiceProvider
{
    private $adapters;
    protected $alias = 'db';
    protected $shared = false;

    public function __construct()
    {
        $this->adapters = config()->database->adapters;
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        # - If empty, then disable DB by just returning itself

        $db_adapter = config()->app->db_adapter;

        if (
            strlen($db_adapter) == 0 ||
            $db_adapter === 'false'
        ) {
            return $this;
        }


        # - loop the adapters and create a service for each
        # to be used in the model classes to switch over

        foreach ($this->adapters as $alias => $adapter) {

            di()->set($alias, function() use($alias) {

                return $this->connection($alias);
            });
        }


        # - check if the selected driver is in the lists

        $selected_adapter = strtolower(config()->app->db_adapter);

        if ( !isset($this->adapters[$selected_adapter]) ) {

            throw new Exception('Database adapter '.$selected_adapter.' not found');
        }


        return $this->connection($selected_adapter);
    }


    /**
     * Instantiate the class and get the adapter
     *
     * @return mixed An adapter to use you
     */
    protected function connection($selected_adapter)
    {
        $conn = new $this->adapters[$selected_adapter]['class'](
            config()
                ->database
                ->adapters
                ->{$selected_adapter}
                ->toArray()
        );

        $conn->setEventsManager($this->getEventLogger());

        return $conn;
    }

    /**
     * An event to log our queries
     *
     * @return  mixed Instatiated event manager
     */
    protected function getEventLogger()
    {
        $event_manager = new EventsManager;

        $event_manager->attach($this->alias, function ($event, $conn) {

            if ( $event->getType() == 'beforeQuery' ) {

                $logger = new Logger('DB');
                $logger->pushHandler(
                    new StreamHandler(
                        config()->path->logs.'db-'.logging_extension().'.log',
                        Logger::INFO
                    )
                );

                $variables = $conn->getSQLVariables();

                if ( $variables ) {
                    $logger->info(
                        $conn->getSQLStatement() .
                        ' ['. join(',', $variables) . ']'
                    );
                } else {
                    $logger->info($conn->getSQLStatement());
                }
            }
        });

        return $event_manager;
    }
}
