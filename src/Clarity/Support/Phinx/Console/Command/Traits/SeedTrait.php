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
namespace Clarity\Support\Phinx\Console\Command\Traits;

trait SeedTrait
{
    public function getSeedTemplateFilename()
    {
        $file = url_trimmer(config()->path->storage.'/stubs/db/SeedCreate.stub');

        if (file_exists($file)) {
            return $file;
        }

        return parent::getSeedTemplateFilename();
    }
}
