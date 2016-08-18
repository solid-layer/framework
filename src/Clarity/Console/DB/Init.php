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
namespace Clarity\Console\DB;

use Phinx\Console\Command\Init as BaseInit;

class Init extends BaseInit
{
    protected function configure()
    {
        parent::configure();

        $this->setName('db:init');
    }
}
