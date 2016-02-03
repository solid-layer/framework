<?php
namespace Clarity\Support\Phinx\Console\Command\Traits;

trait MigrationTrait
{
    public function getMigrationTemplateFilename()
    {
        $file = url_trimmer(config()->path->storage.'/stubs/db/MigrationCreate.stub');

        if ( file_exists($file) ) {
            return $file;
        }

        return parent::getMigrationTemplateFilename();
    }
}