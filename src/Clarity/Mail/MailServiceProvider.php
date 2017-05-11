<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Mail;

use Exception;
use Clarity\Providers\ServiceProvider;

/**
 * The 'mail' service provider.
 */
class MailServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * Get all this service provider provides.
     *
     * @return array
     */
    public function provides()
    {
        return ['mail.selected_adapter', 'mail'];
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton('mail.selected_adapter', function () {
            $selected_adapter = config()->app->mail_adapter;

            return config()->mail->{$selected_adapter};
        });

        $this->app->singleton('mail', function ($app) {
            $adapter = $app->make('mail.selected_adapter')->toArray();

            if (! $adapter) {
                throw new Exception('Adapter not found.');
            }

            if (! $adapter['active']) {
                return $this;
            }

            $class = $adapter['class'];

            return new Mail(new $class, $adapter['options']);
        });
    }
}
