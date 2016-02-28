<?php
namespace Clarity\Support\Phinx\Console\Command;

use Phinx\Console\Command\Rollback as BaseRollback;
use Clarity\Support\Phinx\Console\Command\Traits\ConfigurationTrait;

class Rollback extends BaseRollback
{
    use ConfigurationTrait;

    protected function configure()
    {
        parent::configure();

        $this->setName('db:rollback');
    }
}
