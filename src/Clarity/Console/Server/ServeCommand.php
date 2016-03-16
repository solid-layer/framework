<?php
namespace Clarity\Console\Server;

use Clarity\Console\SlayerCommand;
use Symfony\Component\Console\Input\InputOption;

class ServeCommand extends SlayerCommand
{
    protected $name = 'serve';

    protected $description = "Serve the application on the PHP development server";

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

    protected function options()
    {
        $host = 'localhost';
        $port = 8000;

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
                null,
            ]
        ];
    }
}
