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
namespace Clarity\Console\Make;

use Clarity\Console\Brood;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * A console command that generates a model template.
 */
class ModelCommand extends Brood
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'make:model';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Generate a database model';

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $arg_name = ucfirst($this->input->getArgument('model'));

        $stub = file_get_contents(__DIR__.'/stubs/makeModel.stub');
        $stub = str_replace('{modelName}', $arg_name, $stub);

        $source_name = $this->input->getOption('table');
        if (strlen($source_name) == 0) {
            $source_name = strtolower($arg_name);
        }

        $stub = str_replace('{table}', $source_name, $stub);

        $file_name = $arg_name.'.php';
        chdir(config()->path->models);
        $this->comment('Crafting Model...');

        if (file_exists($file_name)) {
            $this->error('   Model already exists!');
        } else {
            file_put_contents($file_name, $stub);

            $this->info('   Model has been created!');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function arguments()
    {
        return [
            [
                'model',
                InputArgument::REQUIRED,
                'Model name to be use e.g(User)',
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
                'table',
                null,
                InputOption::VALUE_OPTIONAL,
                'The table to use',
                false,
            ],
        ];
    }
}
