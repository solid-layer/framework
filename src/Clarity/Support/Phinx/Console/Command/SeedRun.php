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

use Phinx\Console\Command\SeedRun as BaseSeedRun;
use Clarity\Support\Phinx\Console\Command\Traits\ConfigurationTrait;

class SeedRun extends BaseSeedRun
{
    use ConfigurationTrait;

    protected function configure()
    {
        parent::configure();

        $this->setName('db:seed:run');
    }
}
