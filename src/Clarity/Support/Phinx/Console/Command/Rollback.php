<?php
namespace Clarity\Support\Phinx\Console\Command;

use Phinx\Console\Command\Rollback as BaseRollback;

class Rollback extends BaseRollback
{
    protected function configure()
    {
        parent::configure();

        $this->setName('db:rollback');
    }
}
