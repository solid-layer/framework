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
     * @var string
     */
    protected $alias = 'mail';

    /**
     * @var bool
     */
    protected $shared = false;

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $selected_adapter = config()->app->mail_adapter;

        $adapter = config()->mail->{$selected_adapter};

        if (! $adapter) {
            throw new Exception('Adapter not found.');
        }

        if (! $adapter['active']) {
            return $this;
        }

        $adapter = $adapter->toArray();

        $class = $adapter['class'];

        return new Mail(new $class, $adapter['options']);
    }
}
