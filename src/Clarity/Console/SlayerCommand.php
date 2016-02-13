<?php
namespace Clarity\Console;

use Clarity\Services\ServiceMagicMethods;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

abstract class SlayerCommand extends Command
{
    use ServiceMagicMethods;

    protected $input;
    protected $output;

    abstract public function slash();

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this->slash();
    }

    protected function configure()
    {
        $this
            ->setName($this->name)
            ->setDescription($this->description);


        if ( count($this->arguments()) ) {

            foreach ( $this->arguments() as $arg ) {

                $this->addArgument(
                    isset($arg[0]) ? $arg[0] : null,
                    isset($arg[1]) ? $arg[1] : null,
                    isset($arg[2]) ? $arg[2] : null,
                    isset($arg[3]) ? $arg[3] : null
                );
            }
        }

        if ( count($this->options()) ) {

            foreach ($this->options() as $opt) {

                $this->addOption(
                    isset($opt[0]) ? $opt[0] : null,
                    isset($opt[1]) ? $opt[1] : null,
                    isset($opt[2]) ? $opt[2] : null,
                    isset($opt[3]) ? $opt[3] : null
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
