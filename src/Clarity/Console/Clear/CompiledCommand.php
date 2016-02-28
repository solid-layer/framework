<?php
namespace Clarity\Console\Clear;

use Clarity\Console\SlayerCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CompiledCommand extends SlayerCommand
{
    use ClearTrait;

    protected $name = 'clear:compiled';
    protected $description = 'Clear the compiled classes';

    public function slash()
    {
        $this->clear(
            url_trimmer(storage_path('slayer'))
        );
    }
}
