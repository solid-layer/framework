<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Mail\SwiftMailer;

use Swift_Mailer;
use Swift_Message;
use Swift_Attachment;
use Clarity\Contracts\Mail\MailInterface;

/**
 * A swift mailer adapter.
 */
abstract class Swift implements MailInterface
{
    /**
     * @var mixed|\Swift_Message
     */
    private $message;

    /**
     * @var \Swift_Transport
     */
    private $transport;

    /**
     * Contructor.
     */
    public function __construct()
    {
        $this->message = Swift_Message::newInstance();
        $this->transport = $this->getTransport();
    }

    /**
     * The transport to use.
     *
     * @return \Swift_Transport
     */
    abstract protected function getTransport();

    /**
     * {@inheritdoc}
     */
    public function attach($file)
    {
        $this->message->attach(
            Swift_Attachment::fromPath($file)
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function encryption($encryption)
    {
        $this->transport->setEncryption($encryption);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function host($host)
    {
        $this->transport->setHost($host);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function port($port)
    {
        $this->transport->setPort($port);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function username($username)
    {
        $this->transport->setUsername($username);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function password($password)
    {
        $this->transport->setPassword($password);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function from($email)
    {
        $this->message->setFrom($email);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function to(array $emails)
    {
        $this->message->setTo($emails);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function bcc(array $emails)
    {
        $this->message->setBcc($emails);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function cc(array $emails)
    {
        $this->message->setBcc($emails);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function subject($subject)
    {
        $this->message->setSubject($subject);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function body($body)
    {
        $this->message->addPart($body, 'text/html');

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        $mailer = Swift_Mailer::newInstance($this->transport);

        return $mailer->send($this->message);
    }
}
