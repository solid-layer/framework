<?php

namespace Clarity\Console\Server;

use Psy\Shell;
use Psy\Configuration;
use Clarity\Console\Brood;
use Symfony\Component\Console\Input\InputArgument;

class ClutchCommand extends Brood
{
    /**
     * brood commands to include in the clutch shell.
     *
     * @var array
     */
    protected $commandWhitelist = [
        'env',
        'optimize',
        'clear:all', 'clear:cache', 'clear:compiled', 'clear:logs', 'clear:session', 'clear:views',
        'db:migrate', 'db:status',
    ];

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'clutch';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Interact with your application';

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $this->getApplication()->setCatchExceptions(false);

        $config = new Configuration;

        $config->getPresenter()->addCasters(
            $this->getCasters()
        );

        $shell = new Shell($config);
        $shell->addCommands($this->getCommands());
        $shell->setIncludes($this->getInput()->getArgument('include'));

        $shell->run();
    }

    /**
     * Get clutch commands to pass through PsySH.
     *
     * @return array
     */
    protected function getCommands()
    {
        $commands = [];

        foreach ($this->getApplication()->all() as $name => $command) {
            if (in_array($name, $this->commandWhitelist)) {
                $commands[] = $command;
            }
        }

        return $commands;
    }

    /**
     * Get all casters
     *
     * @return array
     */
    protected function getCasters()
    {
        // todo
        return [];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function arguments()
    {
        return [
            ['include', InputArgument::IS_ARRAY, 'Include file(s) before starting clutch'],
        ];
    }
}
