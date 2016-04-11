<?php
/**
 * PhalconSlayer\Framework
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phalconslayer.readme.io
 */

/**
 * @package Clarity
 * @subpackage Clarity\Support\Phinx\Console\Command\Traits
 */
namespace Clarity\Support\Phinx\Console\Command\Traits;

use Exception;
use Phinx\Config\Config;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

trait ConfigurationTrait
{
    protected function loadConfig(InputInterface $input, OutputInterface $output)
    {
        $env = env('APP_ENV');

        $selected_adapter = config()->app->db_adapter;

        $adapters = config()->database->phinx_migrations->toArray();

        if ( !isset($adapters[$selected_adapter]) ) {
            throw new Exception(
                "Adapter [$selected_adapter] not found ".
                "on config/database.phinx_migrations"
            );
        }

        $settings = $adapters[$selected_adapter];

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
}