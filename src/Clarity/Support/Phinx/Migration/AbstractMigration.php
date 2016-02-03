<?php
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
