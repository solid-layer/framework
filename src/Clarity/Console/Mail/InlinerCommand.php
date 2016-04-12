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
 * @subpackage Clarity\Console\Mail
 */
namespace Clarity\Console\Mail;

use Clarity\Console\SlayerCommand;
use Symfony\Component\Console\Input\InputOption;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

/**
 * A console command that converts templates into inlined
 */
class InlinerCommand extends SlayerCommand
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'mail:inliner';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Inline templates to make it suitable for emails';

    /**
     * It combines all the css provided so that the system could
     * analyze which class/ids will be used and will be inlined
     *
     * @param mixed $css_files
     * @return string
     */
    protected function combineCss($css_files)
    {
        $combined_css = null;

        foreach ($css_files as $css) {
            $combined_css .=
                file_get_contents(
                    url_trimmer($css)
                );
        }

        return $combined_css;
    }

    /**
     * A parser function or rebuilder to inline original file
     * into an email based html
     *
     * @param mixed $record assigned key from inliner config
     * @return void
     */
    protected function parse($record)
    {
        # instatiate the package inliner
        $inliner = new CssToInlineStyles;


        # let's get the views dir combine the record file
        $base_file = url_trimmer(
            di()->get('view')->getViewsDir().$record->file.'.*'
        );


        # now get all related glob
        $related_files = glob($base_file);
        if (empty($related_files) === true) {
            $this->comment('   System can\'t find the file: '.$base_file);

            return;
        }


        # set the html
        $inliner->setHTML(
            file_get_contents($related_files[0])
        );


        # set the css files
        $inliner->setCSS(
            $this->combineCss($record['css'])
        );


        #  get the dirname and file name
        $dirname = dirname($related_files[0]);
        $converted_name = basename($record->file).'-inlined.volt';


        # overwrite or create a file based on the dirname and file name
        file_put_contents(
            $dirname.'/'.$converted_name,
            rawurldecode($inliner->convert())
        );


        # log, show some sucess
        $this->comment('   '.basename($record->file).' inlined! saved as '.$converted_name);
    }

    /**
     * {@inheritDoc}
     */
    public function slash()
    {
        # show some pretty comments that we're now inlining
        $this->comment('Inlining...');


        # let's get if there's an option assigned to 'record'
        $record = $this->input->getOption('record');


        # get all the records in inliner.php file
        $records = config()->inliner->toArray();


        # determine if option 'record' is not empty
        # then we should get the specific inline key
        if (strlen($record) != 0) {

            if (isset($records[$record]) === false) {
                $this->error($record.' not found!');

                return;
            }

            $this->parse(config()->inliner->{$record});
        }

        # or, else parse all the inliner
        else {
            foreach (config()->inliner as $record) {
                $this->parse($record, true);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function options()
    {
        return [
            [
                'record',
                null,
                InputOption::VALUE_OPTIONAL,
                'The record key to be parsed.',
                null,
            ],
        ];
    }
}
