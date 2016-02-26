<?php
namespace Clarity\Console\Server;

use Clarity\Console\CLI;
use Clarity\Console\SlayerCommand;

class EnvCommand extends SlayerCommand
{
    protected $name = 'env';
    protected $description = 'Get current environment';

    public function slash()
    {
        $timeout = $this->getInput()->getOption('timeout');

        $this->info(
            "\n".'Your current environment ['.config()->environment.']'."\n"
            // .' | Timeout: '.$timeout
        );
    }
}
