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
namespace Clarity\Support\Phinx\Migration;

use Clarity\Support\Phinx\Db\Table;
use Phinx\Migration\AbstractMigration as BaseAbstractMigration;

/**
 * This class extends the package @see robmorgan\phinx AbstractMigration.
 *
 * We extended this to wrap the parent class, this will be used for future
 * modifications if needed, while the stub generated when calling db:migrate
 * through brood, extends this class as well.
 */
abstract class AbstractMigration extends BaseAbstractMigration
{
    /**
     * {@inheritdoc}
     *
     * @param string $table_name The table name to be created/updated
     * @param mixed $options The options when migrating a tabke
     * @return \Clarity\Support\Phinx\Db\Table
     */
    public function table($table_name, $options = [])
    {
        return new Table($table_name, $options, $this->getAdapter());
    }
}
