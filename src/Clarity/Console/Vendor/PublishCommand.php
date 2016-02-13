<?php
namespace Clarity\Console\Vendor;

use Exception;
use Clarity\Console\SlayerCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PublishCommand extends SlayerCommand
{
    protected $name = 'vendor:publish';
    protected $description = 'Publish a vendor package';

    public function slash()
    {
        $tag_name = $this->input->getOption('tag');
        $alias = $this->input->getArgument('alias');

        foreach (config()->app->services as $service) {

            $obj = new $service;

            if ( $alias != $obj->getAlias() ) {
                continue;
            }

            $obj->boot();

            try {
                $tags = $obj->getToBePublished($tag_name);

                foreach ($tags as $tag) {

                    foreach ($tag as $source => $dest) {

                        if ( ! $this->confirm('Are you sure you want to run this? [y/n]: ') ) {
                            return;
                        }

                        cp($source, $dest);

                        $this->info("Publishing tag \"$tag_name\" from [$source] to [$dest]");
                    }
                }

            } catch (Exception $e) {

                $this->error($e->getMessage());
            }
        }
    }

    public function arguments()
    {
        return [
            ['alias', InputArgument::REQUIRED, 'Provider alias'],
        ];
    }

    protected function options()
    {
        return [
            [
                'tag',
                null,
                InputOption::VALUE_OPTIONAL,
                'Specify which tag you want to publish',
                null,
            ],
        ];
    }
}
