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
use Symfony\Component\Console\Input\InputArgument;

/**
 * A console command that generates a brood console template.
 */
class ConsoleCommand extends Brood
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'make:console';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Generate a new console';

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $arg_name = ucfirst($this->input->getArgument('name'));

        $stub = file_get_contents(__DIR__.'/stubs/makeConsole.stub');
        $stub = stubify(
            $stub, [
                'consoleName' => $arg_name,
            ]
        );

        $file_name = $arg_name.'.php';
        chdir(config()->path->console);
        $this->comment('Crafting Console...');

        if (file_exists($file_name)) {
            $this->error('   Console already exists!');
        } else {
            file_put_contents($file_name, $stub);
            $this->info('   Console has been created!');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function arguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Console name to be used'],
        ];
    }
}
