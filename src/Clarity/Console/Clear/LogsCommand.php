<?php
namespace Clarity\Console\Clear;

use Clarity\Console\SlayerCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class LogsCommand extends SlayerCommand
{
    use ClearTrait;

    protected $name = 'clear:logs';
    protected $description = 'Clear the storage/logs folder';

    public function slash()
    {
        $this->clear(storage_path('logs'));
    }
}
