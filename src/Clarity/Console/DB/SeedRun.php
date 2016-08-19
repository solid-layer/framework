<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

/**
 */
namespace Clarity\Console\DB;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class SeedRun extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'seed:run';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Run database seeders';

    protected $help = <<<EOT
The <info>seed:run</info> command runs all available or individual seeders

<info>php brood seed:run</info>
<info>php brood seed:run --seed="UserSeeder"</info>
<info>php brood seed:run --seed="UserSeeder" --seed="PermissionSeeder" --seed="LogSeeder"</info>
<info>php brood seed:run --seed="UserSeeder" --seed="PermissionSeeder" --seed="LogSeeder"</info>
<info>php brood seed:run --seed="UserSeeder" --env="staging"</info>
<info>php brood seed:run -v</info>

EOT;

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $seed_set    = $this->getInput()->getOption('seed');
        $environment = $this->getInput()->getOption('env');

        if (null === $environment) {
            $environment = config()->environment;
            $this->getOutput()->writeln('<comment>warning</comment> no environment specified, defaulting to: ' . $environment);
        } else {
            $this->getOutput()->writeln('<info>using environment</info> ' . $environment);
        }

        $config = $this->getDefaultConfig();

        $env_options = $config->getEnvironment($environment);

        if (isset($env_options['adapter'])) {
            $this->getOutput()->writeln('<info>using adapter</info> ' . $env_options['adapter']);
        }

        if (isset($env_options['wrapper'])) {
            $this->getOutput()->writeln('<info>using wrapper</info> ' . $env_options['wrapper']);
        }

        if (isset($env_options['name'])) {
            $this->getOutput()->writeln('<info>using database</info> ' . $env_options['name']);
        } else {
            $this->getOutput()->writeln('<error>Could not determine database name! Please specify a database name in your config file.</error>');
            return 1;
        }

        if (isset($env_options['table_prefix'])) {
            $this->getOutput()->writeln('<info>using table prefix</info> ' . $env_options['table_prefix']);
        }
        if (isset($env_options['table_suffix'])) {
            $this->getOutput()->writeln('<info>using table suffix</info> ' . $env_options['table_suffix']);
        }

        $this->loadManager();

        $start = microtime(true);
        if (empty($seed_set)) {
            // run all the seed(ers)
            $this->getManager()->seed($environment);
        } else {
            // run seed(ers) specified in a comma-separated list of classes
            foreach ($seed_set as $seed) {
                $this->getManager()->seed($environment, trim($seed));
            }
        }
        $end = microtime(true);

        $this->getOutput()->writeln('');
        $this->getOutput()->writeln('<comment>All Done. Took ' . sprintf('%.4fs', $end - $start) . '</comment>');
    }

    /**
     * {@inheritdoc}
     */
    public function arguments()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function options()
    {
        return [
            ['--seed', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'What is the name of the seeder?'],
        ];
    }
}
