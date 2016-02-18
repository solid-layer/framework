<?php
namespace Clarity\Support\Phinx\Console\Command\Traits;

use Phinx\Config\Config;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

trait ConfigurationTrait
{
    protected function loadConfig(InputInterface $input, OutputInterface $output)
    {
        $env = env('APP_ENV');

        $config = new Config(
            [
                'paths'        => [
                    'migrations' => config()->path->migrations,
                    'seeds'      => config()->path->seeders,
                ],
                'environments' => [
                    'default_migration_table' => 'migrations',
                    'default_database'        => $env,
                    $env                      => [
                        'adapter' => env('DB_ADAPTER', 'mysql'),
                        'host'    => env('DB_HOST', 'localhost'),
                        'name'    => env('DB_DATABASE'),
                        'user'    => env('DB_USERNAME'),
                        'pass'    => env('DB_PASSWORD'),
                        'port'    => env('DB_PORT'),
                        'charset' => env('DB_CHARSET'),
                    ],
                ],
            ]
        );

        $this->setConfig($config);
    }
}