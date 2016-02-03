<?php
namespace Clarity\Support\Phinx\Console\Command\Traits;

trait SeedTrait
{
    public function getSeedTemplateFilename()
    {
        $file = url_trimmer(config()->path->storage.'/stubs/db/SeedCreate.stub');

        if ( file_exists($file) ) {
            return $file;
        }

        return parent::getSeedTemplateFilename();
    }
}