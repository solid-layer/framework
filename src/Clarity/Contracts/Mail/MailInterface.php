<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phalconslayer.readme.io
 */

/**
 */
namespace Clarity\Contracts\Mail;

/**
 * A mail interface for adapter handling.
 */
interface MailInterface
{
    /**
     * Attach a file.
     *
     * @param string $file The file to be attached
     */
    public function attach($file);

    /**
     * Set the encryption type.
     *
     * @param string $encryption The encryption method
     */
    public function encryption($encryption);

    /**
     * Set the host of your mail provider.
     *
     * @param string $host The smtp host
     */
    public function host($host);

    /**
     * Set the port of your mail provider.
     *
     * @param string $port The smtp port
     */
    public function port($port);

    /**
     * Set the username of your mail provider.
     *
     * @param string $username The smtp username
     */
    public function username($username);

    /**
     * Set the password of your mail provider.
     *
     * @param string $password The smtp password
     */
    public function password($password);

    /**
     * The email who acts as the sender.
     *
     * @param string $email The sender email
     */
    public function from($email);

    /**
     * The email(s) who acts as the receiver(s).
     *
     * @param mixed $emails The lists of emails to send
     */
    public function to(array $emails);

    /**
     * The email(s) who acts as the blind carbon copy receiver(s).
     *
     * @param mixed $emails The lists of emails to send as blind carbon copy
     */
    public function bcc(array $emails);

    /**
     * The email(s) who acts as the carbon copy receiver(s).
     *
     * @param mixed $emails The lists of emails to send as carbon copy
     */
    public function cc(array $emails);

    /**
     * Set the subject of your email.
     *
     * @param string $subject The mail subject or title
     */
    public function subject($subject);

    /**
     * Set the content of your email.
     *
     * @param string $body The mail content or body
     */
    public function body($body);

    /**
     * This function will be triggered upon sending.
     */
    public function send();
}
