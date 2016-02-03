<?php
namespace Clarity\Support\Phinx\Console\Command;

use Phinx\Console\Command\Init as BaseInit;

class Init extends BaseInit
{
    protected function configure()
    {
        parent::configure();

        $this->setName('db:init');
    }
}
