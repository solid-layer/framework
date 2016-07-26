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

use Clarity\Contracts\Mail\MailInterface;

class Mail
{
    private $adapter;

    private $config;

    public function __construct(MailInterface $adapter, $config)
    {
        $this->adapter = $adapter;
        $this->config = $config;
    }

    public function initialize($view, $records)
    {
        # we require our mail to auto-set the configurations
        # in the functions, so we need to call the possible
        # functions that doesn't require human calls
        $functions = [
            'host',
            'port',
            'username',
            'password',
            'encryption',
        ];

        foreach ($functions as $function) {

            # if the provided config is empty, turn next loop
            if (
                isset($this->config[$function]) &&
                empty($this->config[$function])
            ) {
                continue;
            }

            # now call the functions
            $this
                ->adapter
                ->{$function}($this->config[$function]);
        }

        # render the view as partial
        $body = di()->get('view')->take($view, $records);

        # we need to insert the global mailer 'from'
        # and insert the body
        $this
            ->adapter
            ->from(isset($this->config['from']) ? $this->config['from'] : '')
            ->body($body);

        # now return the adapter, so that they could still pre-modify
        # the function values
        return $this->adapter;
    }

    /**
     * This will trigger the adapter's send function
     *
     * @param string $view The view path
     * @param array $records The variables will be used on the view path
     * @param mixed $callback
     *
     * @return boolean
     */
    public function send($view, $records, $callback)
    {
        # we will pass the view path and records
        $init = $this->initialize($view, $records);

        # we will call the initialize function
        call_user_func($callback, $init);

        # we lastly triggering the send function
        $init->send();

        return true;
    }
}
