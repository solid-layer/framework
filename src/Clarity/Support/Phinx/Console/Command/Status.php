<?php
namespace Clarity\Support\Phinx\Console\Command;

use Phinx\Console\Command\Status as BaseStatus;
use Clarity\Support\Phinx\Console\Command\Traits\ConfigurationTrait;

class Status extends BaseStatus
{
    use ConfigurationTrait;

    protected function configure()
    {
        parent::configure();

        $this->setName('db:status');
    }
}
