<?php
namespace Clarity\Support\Phinx\Console\Command;

use Phinx\Console\Command\Create as BaseCreate;
use Clarity\Support\Phinx\Console\Command\Traits\MigrationTrait;
use Clarity\Support\Phinx\Console\Command\Traits\ConfigurationTrait;

class Create extends BaseCreate
{
    use MigrationTrait;
    use ConfigurationTrait;

    protected function configure()
    {
        parent::configure();

        $this->setName('db:create');
    }
}
