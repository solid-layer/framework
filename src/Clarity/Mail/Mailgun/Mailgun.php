<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Mail\Mailgun;

use Mailgun\Mailgun as BaseMailgun;
use Clarity\Contracts\Mail\MailInterface;

/**
 * Mailgun Adapter.
 */
class Mailgun implements MailInterface
{
    /**
     * @var array
     */
    private $files;

    /**
     * @var string
     */
    private $encryption;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $to;

    /**
     * @var array|string
     */
    private $bcc;

    /**
     * @var array|string
     */
    private $cc;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $html;

    /**
     * {@inheritdoc}
     */
    public function attach($file)
    {
        $this->files[] = $file;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function encryption($encryption)
    {
        $this->encryption = $encryption;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function host($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function port($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function username($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function password($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function from($email)
    {
        $this->from = $email;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function to(array $emails)
    {
        $this->to = implode(', ', $emails);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function bcc(array $emails)
    {
        $this->bcc = $emails;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function cc(array $emails)
    {
        $this->cc = $emails;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function subject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function body($body)
    {
        $this->html = $body;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        $mailgun = new BaseMailgun($this->getSecretKey());

        return $mailgun->sendMessage(
            $this->getDomain(), $this->getData(), $this->getFiles()
        );
    }

    /**
     * Get the data.
     *
     * @return array
     */
    private function getData()
    {
        $ret = [
            'from'    => $this->from,
            'subject' => $this->subject,
            'html'    => $this->html,
        ];

        if (! empty($this->to)) {
            $ret['to'] = $this->to;
        }

        if (! empty($this->cc)) {
            $ret['cc'] = $this->cc;
        }

        if (! empty($this->bcc)) {
            $ret['bcc'] = $this->bcc;
        }

        return $ret;
    }

    /**
     * Get files.
     *
     * @return array
     */
    private function getFiles()
    {
        $ret = [];

        if (count($this->files)) {
            foreach ($this->files as $file) {
                $ret['attachment'][] = $file;
            }
        }

        return $ret;
    }

    /**
     * Get the secret-key from config.
     *
     * @return string
     */
    private function getSecretKey()
    {
        return config()->services->mailgun->secret;
    }

    /**
     * Get the domain from config.
     *
     * @return string
     */
    private function getDomain()
    {
        return config()->services->mailgun->domain;
    }
}
