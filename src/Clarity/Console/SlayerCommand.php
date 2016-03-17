<?php
namespace Clarity\Console;

use Phalcon\Config;
use Clarity\Services\ServiceMagicMethods;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Exception\InvalidOptionException;

abstract class SlayerCommand extends Command
{
    use ServiceMagicMethods;

    protected $input;
    protected $output;
    protected $environment_option = true;
    protected $timeout_option = true;

    abstract public function slash();

    const TIMEOUT = 60;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this->loadEnv();

        $this->loadTimeout();

        $this->slash();
    }

    protected function loadEnv()
    {
        $env = $this->getInput()->getOption('env');

        config()->merge(new Config(['environment' => $env]));

        $folder = '';

        if ( $env !== 'production') {
            $folder = $env;
        }

        $folder_path = url_trimmer(config()->path->config.'/'.$folder);

        if ( file_exists($folder_path) === false ) {
            throw new InvalidOptionException("Environment [$env] not found.");
        }

        config()->merge(
            new Config(
                iterate_require(folder_files($folder_path))
            )
        );

        return $this;
    }

    protected function loadTimeout()
    {
        $timeout = $this->getInput()->getOption('timeout');

        if ( $timeout !== static::TIMEOUT ) {
            set_time_limit($timeout);
        }

        return $this;
    }

    protected function getInput()
    {
        return $this->input;
    }

    protected function getOutput()
    {
        return $this->output;
    }

    protected function configure()
    {
        $this
            ->setName($this->name)
            ->setDescription($this->description);

        if ( !empty($this->arguments()) ) {

            foreach ( $this->arguments() as $arg ) {

                $this->addArgument(
                    isset($arg[0]) ? $arg[0] : null,
                    isset($arg[1]) ? $arg[1] : null,
                    isset($arg[2]) ? $arg[2] : null,
                    isset($arg[3]) ? $arg[3] : null
                );
            }
        }

        if ( $this->environment_option ) {
            $this->addOption(
                'env',
                'e',
                InputOption::VALUE_OPTIONAL,
                'The environment to be used',
                'production'
            );
        }

        if ( $this->timeout_option ) {
            $this->addOption(
                'timeout',
                't',
                InputOption::VALUE_OPTIONAL,
                'Set timeout to bypass default execution time',
                static::TIMEOUT
            );
        }


        if ( !empty($this->options()) ) {

            foreach ( $this->options() as $opt ) {

                $this->addOption(
                    isset($opt[0]) ? $opt[0] : null,
                    isset($opt[1]) ? $opt[1] : null,
                    isset($opt[2]) ? $opt[2] : null,
                    isset($opt[3]) ? $opt[3] : null,
                    isset($opt[4]) ? $opt[4] : null
                );
            }
        }

        return $this;
    }

    protected function arguments()
    {
        return [];
    }

    protected function options()
    {
        return [];
    }

    public function info($string)
    {
        $this->output->writeln("<info>$string</info>");
    }

    public function line($string)
    {
        $this->output->writeln($string);
    }

    public function comment($string)
    {
        $this->output->writeln("<comment>$string</comment>");
    }

    public function error($string)
    {
        $this->output->writeln("<error>$string</error>");
    }

    public function exception($e)
    {
        $message = sprintf(
            '%s: %s (uncaught exception) at %s line %s',
            get_class($e),
            $e->getMessage(),
            $e->getFile(),
            $e->getLine()
        );

        $this->error("\n".$message."\n");
    }

    public function ask($message, $default)
    {
        $helper = $this->getHelper('question');

        $question = new Question($message, $default);

        return $helper->ask($this->input, $this->output, $question);
    }

    public function confirm($message)
    {
        $helper = $this->getHelper('question');

        $question = new ConfirmationQuestion($message, false);

        return $helper->ask($this->input, $this->output, $question);
    }

    public function callDumpAutoload()
    {
        CLI::bash([
            'composer dumpautoload',
        ]);
    }
}
