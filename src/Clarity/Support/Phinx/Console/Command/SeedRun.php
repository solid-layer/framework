<?php
namespace Clarity\Support\Phinx\Console\Command;

use Phinx\Console\Command\SeedRun as BaseSeedRun;
use Clarity\Support\Phinx\Console\Command\Traits\ConfigurationTrait;

class SeedRun extends BaseSeedRun
{
    use ConfigurationTrait;

    protected function configure()
    {
        parent::configure();

        $this->setName('db:seed:run');
    }
}
