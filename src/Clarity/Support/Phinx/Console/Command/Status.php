<?php
namespace Clarity\Support\Phinx\Console\Command;

use Phinx\Console\Command\Status as BaseStatus;

class Status extends BaseStatus
{
    protected function configure()
    {
        parent::configure();

        $this->setName('db:status');
    }
}
