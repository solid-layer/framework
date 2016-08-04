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
namespace Clarity\Console\Server;

use Clarity\Console\Brood;
use Symfony\Component\Console\Input\InputOption;

/**
 * A console command that serves a module.
 */
class ServeCommand extends Brood
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'serve';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Serve the application on the PHP development server';

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        chdir(url_trimmer(config()->path->root.'public'));
        $current_dir = getcwd();

        $host = $this->input->getOption('host');
        $port = $this->input->getOption('port');
        $file = $this->input->getOption('file');

        $this->info("Phalcon Slayer development server started on http://{$host}:{$port}/");

        passthru(PHP_BINARY." -S {$host}:{$port} -t {$current_dir} -F {$file}");
    }

    /**
     * {@inheritdoc}
     */
    protected function options()
    {
        $host = '0.0.0.0';
        $port = 8080;

        if (getenv('SERVE_HOST')) {
            $host = getenv('SERVE_HOST');
        }

        if (getenv('SERVE_PORT')) {
            $port = getenv('SERVE_PORT');
        }

        return [
            [
                'host',
                null,
                InputOption::VALUE_OPTIONAL,
                'The host address to serve the application on.',
                $host,
            ],
            [
                'port',
                null,
                InputOption::VALUE_OPTIONAL,
                'The port to serve the application on.',
                $port,
            ],
            [
                'file',
                null,
                InputOption::VALUE_OPTIONAL,
                'The php file to be used.',
                'index.php',
            ],
        ];
    }
}
