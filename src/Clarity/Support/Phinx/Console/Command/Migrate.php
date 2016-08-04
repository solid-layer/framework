<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

/**
 */
namespace Clarity\Support\Phinx\Console\Command;

use Phinx\Console\Command\Migrate as BaseMigrate;
use Clarity\Support\Phinx\Console\Command\Traits\ConfigurationTrait;

class Migrate extends BaseMigrate
{
    use ConfigurationTrait;

    protected function configure()
    {
        parent::configure();

        $this->setName('db:migrate');
    }
}
