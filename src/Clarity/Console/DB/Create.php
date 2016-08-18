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

use Phinx\Util\Util;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
// use Phinx\Console\Command\Create as BaseCreate;
// use Clarity\Support\Phinx\Console\Command\Traits\MigrationTrait;
// use Clarity\Support\Phinx\Console\Command\Traits\ConfigurationTrait;

class Create extends AbstractCommand
{
    const CREATION_INTERFACE = 'Phinx\Migration\CreationInterface';

    /**
     * {@inheritdoc}
     */
    protected $name = 'db:create';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Create a new migration';

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $path = realpath($this->getMigrationPath());

        if (! file_exists($path)) {
            if ($this->confirm('Create migrations directory? [y]/n ', true)) {
                mkdir($path, 0755, true);
            }
        }

        $this->verifyMigrationDirectory($path);

        $class_name = $this->getInput()->getArgument('name');

        $this->checkValidPhinxClassName($class_name);

        $this->checkUniqueMigrationClassName($class_name, $path);

        $file_name = $this->mapClassNameToFileName($class_name);
        $file_path = $path.'/'.$file_name;

        $contents = file_get_contents($this->getMigrationTemplateFilename());

        $dump_config = new \Phinx\Config\Config([]);

        $contents = strtr($contents, [
            '$useClassName'  => $dump_config->getMigrationBaseClassName(false),
            '$className'     => $class_name,
            '$version'       => Util::getVersionFromFileName($file_name),
            '$baseClassName' => $dump_config->getMigrationBaseClassName(true),
        ]);

        dd($contents);
    }

    /**
     * {@inheritdoc}
     */
    public function arguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'What is the name of the migration?']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function options()
    {
        return [
            // ['template', null, InputOption::VALUE_REQUIRED, 'Use an alternative template'],
            // ['class', null, InputOption::VALUE_REQUIRED, 'Use a class implementing "' . self::CREATION_INTERFACE . '" to generate the template'],
        ];
    }

    protected function getMigrationTemplateFilename()
    {
        $file = url_trimmer(config()->path->storage.'/stubs/db/MigrationCreate.stub');

        if (file_exists($file)) {
            return $file;
        }

        return parent::getMigrationTemplateFilename();
    }

    protected function checkValidPhinxClassName($class_name)
    {
        if (!Util::isValidPhinxClassName($class_name)) {
            throw new \InvalidArgumentException(sprintf(
                'The migration class name "%s" is invalid. Please use CamelCase format.',
                $class_name
            ));
        }
    }

    protected function checkUniqueMigrationClassName($class_name, $path)
    {
        if (!Util::isUniqueMigrationClassName($class_name, $path)) {
            throw new \InvalidArgumentException(sprintf(
                'The migration class name "%s" already exists',
                $class_name
            ));
        }
    }

    protected function mapClassNameToFileName($class_name)
    {
        return Util::mapClassNameToFileName($class_name);
    }

}
