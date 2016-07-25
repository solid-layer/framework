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
 * @subpackage Clarity\Support\Phinx\Console\Command\Traits
 */
namespace Clarity\Support\Phinx\Console\Command\Traits;

trait MigrationTrait
{
    public function getMigrationTemplateFilename()
    {
        $file = url_trimmer(config()->path->storage.'/stubs/db/MigrationCreate.stub');

        if (file_exists($file)) {
            return $file;
        }

        return parent::getMigrationTemplateFilename();
    }
}
