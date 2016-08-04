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
namespace Clarity\Console\Make;

use Clarity\Console\Brood;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * A console command that generates a collection template.
 */
class CollectionCommand extends Brood
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'make:collection';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Create a new collection';

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $arg_name = ucfirst($this->input->getArgument('collection'));

        $stub = file_get_contents(__DIR__.'/stubs/makeCollection.stub');
        $stub = str_replace('{collectionName}', $arg_name, $stub);

        $source_name = $this->input->getOption('source');
        if (strlen($source_name) == 0) {
            $source_name = strtolower($arg_name);
        }

        $stub = str_replace('{sourceName}', $source_name, $stub);

        $file_name = $arg_name.'.php';
        chdir(config()->path->collections);
        $this->comment('Crafting Collection...');

        if (file_exists($file_name)) {
            $this->error('   Collection already exists!');
        } else {
            file_put_contents($file_name, $stub);

            $this->info('   Collection has been created!');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function arguments()
    {
        return [
            [
                'collection',
                InputArgument::REQUIRED,
                'Model name to be use e.g(Robot)',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function options()
    {
        return [
            [
                'source',
                null,
                InputOption::VALUE_OPTIONAL,
                'The source name to use',
                false,
            ],
        ];
    }
}
