<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Console\DB;

use Clarity\Console\Brood;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Phinx\Config\Config;
use Phinx\Migration\Manager;
use Phinx\Util\Util;

/**
 * Base code for the console command migration.
 */
abstract class AbstractCommand extends Brood
{
    /**
     * @var array
     */
    private $adapters = [
        \Phalcon\Db\Adapter\Pdo\Mysql::class      => 'mysql',
        \Phalcon\Db\Adapter\Pdo\Postgresql::class => 'pgsql',
        \Phalcon\Db\Adapter\Pdo\Sqlite::class     => 'sqlite',
        // 'sqlsrv',
    ];

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * Verify that the seed directory exists and is writable.
     *
     * @throws InvalidArgumentException
     * @return void
     */
    protected function verifySeedDirectory($path)
    {
        if (! is_dir($path)) {
            throw new \InvalidArgumentException(sprintf(
                'Seed directory "%s" does not exist',
                $path
            ));
        }

        if (! is_writable($path)) {
            throw new \InvalidArgumentException(sprintf(
                'Seed directory "%s" is not writable',
                $path
            ));
        }
    }

    /**
     * Sets the migration manager.
     *
     * @param Manager $manager
     * @return AbstractCommand
     */
    public function setManager(Manager $manager)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * Gets the migration manager.
     *
     * @return Manager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Parse the config file and load it into the config object.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \InvalidArgumentException
     * @return void
     */
    protected function getDefaultConfig()
    {
        $env = $this->getInput()->getOption('env');

        $database_config = url_trimmer(
            realpath(config('path.config')).'/'.$env.'/database.php'
        );

        if ($env === config('old_environment')) {
            $database_config = url_trimmer(
                realpath(config('path.config')).'/database.php'
            );
        }

        if (! file_exists($database_config)) {
            throw new \RunTimeException("Database config [$database_config] not found.");
        }

        $selected_adapter = config('app.db_adapter');

        # to safely migrate a database, just get the specific database config
        $database = new \Phalcon\Config(require $database_config);
        $adapters = $database->adapters->toArray();

        if (! isset($adapters[$selected_adapter])) {
            throw new \RunTimeException(
                "Adapter [$selected_adapter] not found ".
                'on config/database.adapters'
            );
        }

        $adapter = $adapters[$selected_adapter];

        # get the latest injected environment
        $env = config('environment');

        return new Config([
            'paths' => [
                'migrations' => realpath(config('path.migrations')),
                'seeds'      => realpath(config('path.seeders')),
            ],
            'environments' => [
                'default_migration_table' => 'migrations',
                'default_database'        => $env,
                $env                      => $this->getSettings($adapter),
            ],
        ]);
    }

    /**
     * Get the settings of an adapter.
     *
     * @param string $adapter
     * @return array
     */
    protected function getSettings($adapter)
    {
        $ret = [];

        switch ($alias = $this->adapters[$adapter['class']]) {
            case 'mysql':
                $ret = [
                    'adapter'  => $alias,
                    'host'     => $adapter['host'],
                    'name'     => $adapter['dbname'],
                    'user'     => $adapter['username'],
                    'pass'     => $adapter['password'],
                    'port'     => $adapter['port'],
                    'charset'  => $adapter['charset'],
                ];
            break;

            case 'pgsql':
                $ret = [
                    'adapter'  => $alias,
                    'host'     => $adapter['host'],
                    'name'     => $adapter['dbname'],
                    'user'     => $adapter['username'],
                    'pass'     => $adapter['password'],
                    'port'     => $adapter['port'],
                    'charset'  => $adapter['charset'],
                ];
            break;

            case 'sqlite':
                $ret = [
                    'adapter' => $alias,
                    'name' => $adapter['dbname'],
                ];
            break;
        }

        return $ret;
    }

    /**
     * Load the migrations manager and inject the config.
     *
     * @param OutputInterface $output
     * @return void
     */
    protected function loadManager()
    {
        if (null === $this->getManager()) {
            $manager = new Manager($this->getDefaultConfig(), $this->getOutput());
            $this->setManager($manager);
        }
    }

    /**
     * Get the migration path.
     *
     * @return string
     */
    protected function getMigrationPath()
    {
        return config('path.migrations');
    }

    /**
     * Verify that the migration directory exists and is writable.
     *
     * @throws InvalidArgumentException
     * @return void
     */
    protected function verifyMigrationDirectory($path)
    {
        if (! is_dir($path)) {
            throw new \InvalidArgumentException(sprintf(
                'Migration directory "%s" does not exist',
                $path
            ));
        }

        if (! is_writable($path)) {
            throw new \InvalidArgumentException(sprintf(
                'Migration directory "%s" is not writable',
                $path
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function checkValidPhinxClassName($class_name)
    {
        if (! Util::isValidPhinxClassName($class_name)) {
            throw new \InvalidArgumentException(sprintf(
                'The migration class name "%s" is invalid. Please use CamelCase format.',
                $class_name
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function checkUniqueMigrationClassName($class_name, $path)
    {
        if (! Util::isUniqueMigrationClassName($class_name, $path)) {
            throw new \InvalidArgumentException(sprintf(
                'The migration class name "%s" already exists',
                $class_name
            ));
        }
    }
}
