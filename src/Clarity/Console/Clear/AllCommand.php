<?php
namespace Clarity\Console\Clear;

use Clarity\Console\CLI;
use Clarity\Console\SlayerCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AllCommand extends SlayerCommand
{
    use ClearTrait;

    protected $name = 'clear:all';
    protected $description = 'Clear all listed';

    public function slash()
    {
        CLI::bash([
            'php brood clear:cache',
            'php brood clear:compiled',
            'php brood clear:logs',
            'php brood clear:session',
            'php brood clear:views',
        ]);
    }
}
