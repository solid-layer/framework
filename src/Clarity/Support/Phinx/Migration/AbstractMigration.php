<?php
/**
 * PhalconSlayer\Framework
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phalconslayer.readme.io
 */

/**
 * @package Clarity
 * @subpackage Clarity\Support\Phinx\Migration
 */
namespace Clarity\Support\Phinx\Migration;

use Clarity\Support\Phinx\Db\Table;
use Phinx\Migration\AbstractMigration as BaseAbstractMigration;

class AbstractMigration extends BaseAbstractMigration
{
    public function table($tableName, $options = [])
    {
        return new Table($tableName, $options, $this->getAdapter());
    }
}
