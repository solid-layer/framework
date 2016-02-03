<?php
namespace Clarity\Support\Phinx\Console\Command;

use Phinx\Console\Command\SeedCreate as BaseSeedCreate;
use Clarity\Support\Phinx\Console\Command\Traits\SeedTrait;

class SeedCreate extends BaseSeedCreate
{
    use SeedTrait;

    protected function configure()
    {
        parent::configure();

        $this->setName('db:seed:create');
    }
}
