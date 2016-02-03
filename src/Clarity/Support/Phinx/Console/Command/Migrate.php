<?php
namespace Clarity\Support\Phinx\Console\Command;

use Phinx\Console\Command\Migrate as BaseMigrate;

class Migrate extends BaseMigrate
{
    protected function configure()
    {
        parent::configure();

        $this->setName('db:migrate');
    }
}
