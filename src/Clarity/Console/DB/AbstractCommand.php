<?php
namespace Clarity\Console\DB;

use Clarity\Console\Brood;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Phinx\Config\Config;
use Phinx\Config\ConfigInterface;
use Phinx\Migration\Manager;
use Phinx\Db\Adapter\AdapterInterface;

abstract class AbstractCommand extends Brood
{
    private $adapters = [
        \Phalcon\Db\Adapter\Pdo\Mysql::class      => 'mysql',
        \Phalcon\Db\Adapter\Pdo\Postgresql::class => 'pgsql',
        \Phalcon\Db\Adapter\Pdo\Sqlite::class     => 'sqlite',
        // 'sqlsrv',
    ];

    const DEFAULT_MIGRATION_TEMPLATE = '/../../Migration/Migration.template.php.dist';

    const DEFAULT_SEED_TEMPLATE = '/../../Seed/Seed.template.php.dist';

    protected $config;

    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * {@inheritdoc}
     */
    // protected function configure()
    // {
    //     $this->addOption('--configuration', '-c', InputOption::VALUE_REQUIRED, 'The configuration file to load');
    //     $this->addOption('--parser', '-p', InputOption::VALUE_REQUIRED, 'Parser used to read the config file. Defaults to YAML');
    // }

    /**
     * Bootstrap Phinx.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    public function bootstrap(InputInterface $input, OutputInterface $output)
    {
        // if (!$this->getConfig()) {
        //     $this->loadConfig($input, $output);
        // }

        // $this->loadManager($output);
        // // report the paths
        // $output->writeln('<info>using migration path</info> ' . $this->getConfig()->getMigrationPath());
        // try {
        //     $output->writeln('<info>using seed path</info> ' . $this->getConfig()->getSeedPath());
        // } catch (\UnexpectedValueException $e) {
        //     // do nothing as seeds are optional
        // }
    }

    /**
     * Sets the config.
     *
     * @param  ConfigInterface $config
     * @return AbstractCommand
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * Gets the config.
     *
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Sets the database adapter.
     *
     * @param AdapterInterface $adapter
     * @return AbstractCommand
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }

    /**
     * Gets the database adapter.
     *
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
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
     * Returns config file path
     *
     * @param InputInterface $input
     * @return string
     */
    // protected function locateConfigFile(InputInterface $input)
    // {
    //     $configFile = $input->getOption('configuration');

    //     $useDefault = false;

    //     if (null === $configFile || false === $configFile) {
    //         $useDefault = true;
    //     }

    //     $cwd = getcwd();

    //     // locate the phinx config file (default: phinx.yml)
    //     // TODO - In future walk the tree in reverse (max 10 levels)
    //     $locator = new FileLocator(array(
    //         $cwd . DIRECTORY_SEPARATOR
    //     ));

    //     if (!$useDefault) {
    //         // Locate() throws an exception if the file does not exist
    //         return $locator->locate($configFile, $cwd, $first = true);
    //     }

    //     $possibleConfigFiles = array('phinx.php', 'phinx.json', 'phinx.yml');
    //     foreach ($possibleConfigFiles as $configFile) {
    //         try {
    //             return $locator->locate($configFile, $cwd, $first = true);
    //         } catch (\InvalidArgumentException $exception) {
    //             $lastException = $exception;
    //         }
    //     }
    //     throw $lastException;
    // }

    /**
     * Parse the config file and load it into the config object
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \InvalidArgumentException
     * @return void
     */

    protected function loadConfig(InputInterface $input, OutputInterface $output)
    {
        $env = config()->environment;
        $selected_adapter = config()->app->db_adapter;
        $adapters = config()->database->adapters->toArray();

        if (! isset($adapters[$selected_adapter])) {
            throw new Exception(
                "Adapter [$selected_adapter] not found ".
                'on config/database.adapters'
            );
        }

        $adapter = $adapters[$selected_adapter];

        $settings = $this->getSettings($adapter);

        $config = new Config(
            [
                'paths'        => [
                    'migrations' => config()->path->migrations,
                    'seeds'      => config()->path->seeders,
                ],
                'environments' => [
                    'default_migration_table' => 'migrations',
                    'default_database'        => $env,
                    $env                      => $settings,
                ],
            ]
        );

        $this->setConfig($config);
    }

    private function getSettings($adapter)
    {
        return [
            'adapter'  => $this->adapters[$adapter['class']],
            'host'     => null,
            'name'     => null,
            'user'     => null,
            'pass'     => null,
            'port'     => null,
            'charset'  => null,
        ];
    }

    /**
     * Load the migrations manager and inject the config
     *
     * @param OutputInterface $output
     * @return void
     */
    protected function loadManager(OutputInterface $output)
    {
        if (null === $this->getManager()) {
            $manager = new Manager($this->getConfig(), $output);
            $this->setManager($manager);
        }
    }

    /**
     * Verify that the seed directory exists and is writable.
     *
     * @throws InvalidArgumentException
     * @return void
     */
    protected function verifySeedDirectory($path)
    {
        if (!is_dir($path)) {
            throw new \InvalidArgumentException(sprintf(
                'Seed directory "%s" does not exist',
                $path
            ));
        }

        if (!is_writable($path)) {
            throw new \InvalidArgumentException(sprintf(
                'Seed directory "%s" is not writable',
                $path
            ));
        }
    }

    /**
     * Returns the migration template filename.
     *
     * @return string
     */
    protected function getMigrationTemplateFilename()
    {
        return __DIR__ . self::DEFAULT_MIGRATION_TEMPLATE;
    }

    /**
     * Returns the seed template filename.
     *
     * @return string
     */
    protected function getSeedTemplateFilename()
    {
        return __DIR__ . self::DEFAULT_SEED_TEMPLATE;
    }



















    protected function getMigrationPath()
    {
        return config()->path->migrations;
    }

    /**
     * Verify that the migration directory exists and is writable.
     *
     * @throws InvalidArgumentException
     * @return void
     */
    protected function verifyMigrationDirectory($path)
    {
        if (!is_dir($path)) {
            throw new \InvalidArgumentException(sprintf(
                'Migration directory "%s" does not exist',
                $path
            ));
        }

        if (!is_writable($path)) {
            throw new \InvalidArgumentException(sprintf(
                'Migration directory "%s" is not writable',
                $path
            ));
        }
    }
}
