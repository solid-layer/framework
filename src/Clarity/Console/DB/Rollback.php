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

use Phinx\Util\Util;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class Rollback extends AbstractCommand
{

    /**
     * {@inheritdoc}
     */
    protected $name = 'db:rollback';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Rollback the last or to a specific migration';

    protected $help = <<<EOT
The <info>rollback</info> command reverts the last migration, or optionally up to a specific version

<info>php brood db:rollback</info>
<info>php brood db:rollback --target-version="20110103081132"</info>
<info>php brood db:rollback --date="20110103"</info>
<info>php brood db:rollback --env="staging"</info>
<info>php brood db:rollback -v</info>
EOT;

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $version     = $this->getInput()->getOption('target-version');
        $environment = $this->getInput()->getOption('env');
        $date        = $this->getInput()->getOption('date');

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

        $this->loadManager();

        $start = microtime(true);
        if (null !== $date) {
            $this->getManager()->rollbackToDateTime($environment, new \DateTime($date));
        } else {
            $this->getManager()->rollback($environment, $version);
        }
        $end = microtime(true);

        $this->getOutput()->writeln('');
        $this->getOutput()->writeln('<comment>All Done. Took ' . sprintf('%.4fs', $end - $start) . '</comment>');

        return 0;
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
            ['--target-version', '-tv', InputOption::VALUE_REQUIRED, 'The version number to rollback to'],
            ['--date', '-d', InputOption::VALUE_REQUIRED, 'The date to rollback to'],
        ];
    }
}
