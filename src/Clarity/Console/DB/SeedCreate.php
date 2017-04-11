<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Console\DB;

use Symfony\Component\Console\Input\InputArgument;

/**
 * Create a database seeder.
 */
class SeedCreate extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'seed:create';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Create a new database seeder';

    /**
     * {@inheritdoc}
     */
    protected $help = "\nCreates a new database seeder\n";

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        # get the seed path from the config
        $path = realpath($this->getDefaultConfig()->getSeedPath());

        if (! file_exists($path)) {
            if ($this->confirm('Create migrations directory? [y]/n ', true)) {
                mkdir($path, 0755, true);
            }
        }

        $this->verifySeedDirectory($path);

        $class_name = $this->getInput()->getArgument('name');

        $this->checkValidPhinxClassName($class_name);

        // Compute the file path
        $file_path = $path.'/'.$class_name.'.php';

        if (is_file($file_path)) {
            throw new \InvalidArgumentException(sprintf(
                'The file "%s" already exists',
                basename($file_path)
            ));
        }

        # inject the class names appropriate to this seeder
        $contents = file_get_contents($this->getSeedTemplateFilename());

        $classes = [
            '$useClassName'  => 'Clarity\Support\Phinx\Seed\AbstractSeed',
            '$className'     => $class_name,
            '$baseClassName' => 'AbstractSeed',
        ];

        $contents = strtr($contents, $classes);

        if (false === file_put_contents($file_path, $contents)) {
            throw new \RuntimeException(sprintf(
                'The file "%s" could not be written to',
                $path
            ));
        }

        $this->getOutput()->writeln('<info>using seed base class</info> '.$classes['$useClassName']);
        $this->getOutput()->writeln('<info>created</info> .'.str_replace(getcwd(), '', $file_path));
    }

    /**
     * {@inheritdoc}
     */
    public function arguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'What is the name of the seeder?'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getSeedTemplateFilename()
    {
        $file = url_trimmer(config()->path->storage.'/stubs/db/SeedCreate.stub');

        if (! file_exists($file)) {
            throw new \RuntimeException("Seed Template [$file] not found.");
        }

        return $file;
    }
}
