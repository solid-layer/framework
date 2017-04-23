<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Mail\SwiftMailer;

/**
 * A swift sendmail adapter.
 */
class SendmailMailer extends Swift
{
    /**
     * {@inheritdoc}
     */
    protected function getTransport()
    {
        $path = config('services.sendmail', '/usr/sbin/sendmail -bs');

        return \Swift_SendmailTransport::newInstance($path);
    }

    /**
     * {@inheritdoc}
     */
    public function encryption($encryption)
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function host($host)
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function port($port)
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function username($username)
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function password($password)
    {
        return $this;
    }
}
