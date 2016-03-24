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
        $this->adapters = static::adapters();
    }

    /**
     * Get the database adapters
     *
     * @return mixed
     */
    public static function adapters()
    {
        return config()
            ->database
            ->adapters
            ->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        di($this->alias)
            ->setEventsManager(
                $this->getEventLogger()
            );
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        # get the selected adapter to be our basis
        $selected_adapter = config()->app->db_adapter;

        # here, check selected adapter if empty, then
        # disable this provider
        if (
            strlen($selected_adapter) == 0 ||
            $selected_adapter === 'false'
        ) {
            return $this;
        }

        return static::connection($selected_adapter);
    }

    /**
     * Instantiate the class and get the adapter
     *
     * @return mixed An adapter to use you
     */
    public static function connection($selected_adapter)
    {
        $adapters = static::adapters();

        $has_adapter = isset($adapters[$selected_adapter]);

        # here, we must check the adapter, if it does not
        # exists, we should throw an exception error
        if (!$has_adapter) {
            throw new Exception(
                'Database adapter '.$selected_adapter.
                ' not found'
            );
        }

        $options = $adapters[$selected_adapter];
        $class = $options['class'];
        unset($options['class']);

        return new $class($options);
    }

    /**
     * An event to log our queries
     *
     * @return mixed Instatiated event manager
     */
    protected function getEventLogger()
    {
        $event_manager = new EventsManager;

        $event_manager->attach($this->alias, function ($event, $conn) {

            if ( $event->getType() == 'beforeQuery' ) {

                $logger = new Logger('DB');
                $logger->pushHandler(
                    new StreamHandler(
                        storage_path('logs').'/db-'.logging_extension().'.log',
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
