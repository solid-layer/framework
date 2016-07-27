<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phalconslayer.readme.io
 */

/**
 */
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
