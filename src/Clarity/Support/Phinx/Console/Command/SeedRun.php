<?php
namespace Clarity\Support\Phinx\Console\Command;

use Phinx\Console\Command\SeedRun as BaseSeedRun;

class SeedRun extends BaseSeedRun
{
    protected function configure()
    {
        parent::configure();

        $this->setName('db:seed:run');
    }
}
