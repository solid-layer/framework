<?php
namespace Clarity\Support\Phinx\Console\Command;

use Phinx\Console\Command\SeedCreate as BaseSeedCreate;
use Clarity\Support\Phinx\Console\Command\Traits\SeedTrait;
use Clarity\Support\Phinx\Console\Command\Traits\ConfigurationTrait;

class SeedCreate extends BaseSeedCreate
{
    use SeedTrait;
    use ConfigurationTrait;

    protected function configure()
    {
        parent::configure();

        $this->setName('db:seed:create');
    }
}
