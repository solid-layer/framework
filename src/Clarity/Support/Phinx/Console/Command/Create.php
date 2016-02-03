<?php
namespace Clarity\Support\Phinx\Console\Command;

use Phinx\Console\Command\Create as BaseCreate;
use Clarity\Support\Phinx\Console\Command\Traits\MigrationTrait;

class Create extends BaseCreate
{
    use MigrationTrait;

    protected function configure()
    {
        parent::configure();

        $this->setName('db:create');
    }
}
