<?php
/**
 * PhalconSlayer\Framework
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phalconslayer.readme.io
 */

/**
 * @package Clarity
 * @subpackage Clarity\Console\Vendor
 */
namespace Clarity\Console\Vendor;

use Exception;
use Clarity\Console\SlayerCommand;
use Clarity\Util\Composer\Builder as Composer;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * A console command that creates a new package
 */
class NewCommand extends SlayerCommand
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'vendor:new';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Create a new vendor package';


    protected function otherComposerKeys($composer)
    {
        $composer->set(
            'description',
            $this->ask('Description []: ', '')
        );

        return $composer;
    }

    protected function getSandboxPath()
    {
        return config()->path->sandbox;
    }

    protected function getFlysystem()
    {
        return flysystem_manager($this->getSandboxPath());
    }

    protected function stubContent()
    {
        return file_get_contents(__DIR__.'/stubs/ServiceProvider.stub');
    }

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        # introduction
        $this->block('Welcome to the New Vendor config generator');

        $composer = new Composer;

        $package = '';
        $default = 'root/'.basename(realpath(''));

        $composer->set(
            'name',
            $package = $this->ask(
                'Package name (<vendor>/<name>) ['.$default.']: ',
                $default
            )
        );

        $composer = $this->otherComposerKeys($composer);

        $composer->set(
            'autoload', [
                'psr-4' => [
                    path_to_namespace($package)."\\" => 'src/',
                ],
            ]
        );

        $validation = $composer->validate();
        if ($validation['valid'] === false) {
            $this->error(json_encode($validation['errors']));
            return;
        }



        # get the file/folder writer
        $sandbox = $this->getFlysystem();



        # craft vendor folder
        $generated_path = url_trimmer($this->getSandboxPath().$package);

        if ($sandbox->has($package) === false) {

            $this->comment("Crafting vendor folder at {$generated_path}");
            $sandbox->createDir($package);
        } else {
            $this->comment("Re-using vendor folder at {$generated_path}");
        }



        # build src folder
        if ($sandbox->has($path = $package.'/src') === false) {
            $this->comment("    - building /src folder");
            $sandbox->createDir($path);
        }



        # build the composer.json file
        if ($sandbox->has($path = url_trimmer($package.'/composer.json')) === false) {
            $this->comment("    - building composer.json file");
            $sandbox->put($path, $composer->render());
        }



        # craft <Package>ServiceProvider.php inside src/ folder
        $content = stubify($this->stubContent(), [
            'namespace' => path_to_namespace($package),
            'serviceFile' => $service_file = path_to_namespace(basename($package)).'ServiceProvider',
        ]);

        if ($sandbox->has($path = $package.'/src/'.$service_file.'.php') === false) {
            $this->comment("    - building service provider class");
            $sandbox->put($path, $content);
        }



        # rebuild the base composer.json
        $composer->config(file_get_contents(base_path('composer.json')));

        if (isset($composer->toArray()['require'][$package])) {
            $this->error('Vendor already exists');
            return;
        }

        $composer->merge('require', [
            $package => '*',
        ]);

        $composer->merge('repositories', [
            [
                'type' => 'path',
                'url'  => str_replace(realpath('').'/', '', $this->getSandboxPath()).$package
            ]
        ]);

        $validation = $composer->validate();

        if ($validation['valid'] === false) {
            $this->error(json_encode($validation['errors']));
            return;
        }

        $this->comment("    - updating base composer.json");
        file_put_contents(base_path('composer.json'), $composer->render());
        $this->info("New vendor loaded, please run the following command:");
        $this->info(" - composer update");
    }
}
