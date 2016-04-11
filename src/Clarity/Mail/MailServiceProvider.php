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
 * @subpackage Clarity\Mail
 */
namespace Clarity\Mail;

use Exception;
use Clarity\Providers\ServiceProvider;

class MailServiceProvider extends ServiceProvider
{
    protected $alias  = 'mail';
    protected $shared = false;

    public function register()
    {
        $adapter = config()->app->mail_adapter;

        $settings = config()->mail->{$adapter};

        if ( !$settings ) {
            throw new Exception('Adapter not found.');
        }

        $settings = $settings->toArray();

        $class = $settings['class'];

        unset($settings['class']);

        return new Mail(new $class, $settings);
    }
}
