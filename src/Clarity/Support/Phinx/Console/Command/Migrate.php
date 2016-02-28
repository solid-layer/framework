<?php
namespace Clarity\Support\Phinx\Console\Command;

use Phinx\Console\Command\Migrate as BaseMigrate;
use Clarity\Support\Phinx\Console\Command\Traits\ConfigurationTrait;

class Migrate extends BaseMigrate
{
    use ConfigurationTrait;

    protected function configure()
    {
        parent::configure();

        $this->setName('db:migrate');
    }
}
