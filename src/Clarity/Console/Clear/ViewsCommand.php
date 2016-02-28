<?php
namespace Clarity\Console\Clear;

use Clarity\Console\SlayerCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ViewsCommand extends SlayerCommand
{
    use ClearTrait;

    protected $name = 'clear:views';
    protected $description = 'Clear the storage/views folder';

    public function slash()
    {
        $this->clear(
            url_trimmer(storage_path('views'))
        );
    }
}
