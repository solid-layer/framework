<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Support\Phalcon\Session;

use Clarity\Facades\Crypt;
use Phalcon\Session\Adapter;
use Phalcon\Session\AdapterInterface;

class Files extends Adapter implements AdapterInterface
{
    private $options;

    public function __construct($options = [])
    {
        parent::__construct($options);

        $this->options = $options;
    }

    protected function getPath($session_id = null)
    {
        if ($session_id === null) {
            $session_id = session_id();
        }

        return $this->options['session_storage'].'/'.base64_encode($session_id);
    }

    protected function loadStorage($path)
    {
        $session = file_get_contents(url_trimmer($path));

        return json_decode($session, true) ?: [];
    }

    public function has($text)
    {
        if (! file_exists($this->getPath(session_id()))) {
            return false;
        }

        $session = $this->loadStorage($this->getPath(session_id()));

        return isset($session[$text]) ? true : false;
    }

    public function get($text, $default_value = null)
    {
        if (! file_exists($this->getPath(session_id()))) {
            return false;
        }

        $session = $this->loadStorage($this->getPath(session_id()));

        $val = $session[$text];

        if (
            isset($this->options['encrypted']) &&
            $this->options['encrypted'] === true
        ) {
            $val = Crypt::decrypt($session[$text]);
        }

        if (empty($val) || ! strlen($val)) {
            return $default_value;
        }

        return $val;
    }

    public function set($text, $data)
    {
        $session = [];

        if (file_exists($this->getPath(session_id()))) {
            $session = $this->loadStorage($this->getPath(session_id()));
        }

        $session[$text] = $data;

        if (
            isset($this->options['encrypted']) &&
            $this->options['encrypted'] === true
        ) {
            $session[$text] = Crypt::encrypt($data);
        }

        file_put_contents($this->getPath(session_id()), json_encode($session));

        return true;
    }

    public function getName()
    {
        return config()->app->session;
    }
}
