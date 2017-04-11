<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Console\DB;

use Symfony\Component\Console\Input\InputOption;

/**
 * Check the database status.
 */
class Status extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'db:status';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Show migration status';

    /**
     * {@inheritdoc}
     */
    protected $help = <<<EOT
The <info>status</info> command prints a list of all migrations, along with their current status

<info>php brood db:status</info>
<info>php brood db:status --format="json"</info>;
<info>php brood db:status --env="staging"</info>;
EOT;

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $environment = $this->getInput()->getOption('env');
        $format = $this->getInput()->getOption('format');

        if (null === $environment) {
            $environment = config()->environment;
            $this->getOutput()->writeln('<comment>warning</comment> no environment specified, defaulting to: '.$environment);
        } else {
            $this->getOutput()->writeln('<info>using environment</info> '.$environment);
        }

        if (null !== $format) {
            $this->getOutput()->writeln('<info>using format</info> '.$format);
        }

        $this->loadManager();

        return $this->getManager()->printStatus($environment, $format);
    }

    /**
     * {@inheritdoc}
     */
    public function options()
    {
        return [
            ['--format', null, InputOption::VALUE_REQUIRED, 'The output format: text or json. Defaults to text.'],
        ];
    }
}
