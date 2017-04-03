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

/**
 * Handle the session via file based.
 */
class Files extends Adapter implements AdapterInterface
{
    /**
     * @var array
     */
    private $options;

    /**
     * Contructor.
     *
     * @param array $options
     */
    public function __construct($options = [])
    {
        parent::__construct($options);

        $this->options = $options;
    }

    /**
     * Get the session file path.
     *
     * @param string $session_id
     * @return string
     */
    protected function getPath($session_id = null)
    {
        if ($session_id === null) {
            $session_id = session_id();
        }

        return $this->options['session_storage'].'/'.base64_encode($session_id);
    }

    /**
     * Load the session based on the path.
     *
     * @param string $path
     * @return array
     */
    protected function loadStorage($path)
    {
        $session = file_get_contents(url_trimmer($path));

        return json_decode($session, true) ?: [];
    }

    /**
     * Check if session index exists.
     *
     * @param int $index
     * @return bool
     */
    public function has($index)
    {
        if (! file_exists($this->getPath(session_id()))) {
            return false;
        }

        $session = $this->loadStorage($this->getPath(session_id()));

        return isset($session[$index]) ? true : false;
    }

    /**
     * Get session data based on index.
     *
     * @param int $index
     * @param int|string|null $default_value
     * @param bool $remove
     * @return int|string
     */
    public function get($index, $default_value = null, $remove = null)
    {
        if ($unique_id = $this->_uniqueId) {
            $index = $unique_id.'#'.$index;
        }

        if (! file_exists($this->getPath(session_id()))) {
            return false;
        }

        $session = $this->loadStorage($this->getPath(session_id()));

        $val = isset($session[$index]) ? $session[$index] : null;

        if (
            isset($this->options['encrypted']) &&
            $this->options['encrypted'] === true
        ) {
            $val = Crypt::decrypt($val);

            json_decode($val);
            if (json_last_error() === 0) {
                $val = json_decode($val, true);
            }
        }

        if ($remove) {
            unset($session[$index]);
        }

        if (empty($val) || (! is_array($val) && ! strlen($val))) {
            return $default_value;
        }

        return $val;
    }

    /**
     * Set session data.
     *
     * @param int $index
     * @param int|string|null|array $data
     * @return bool
     */
    public function set($index, $data)
    {
        $data = is_array($data) ? json_encode($data) : $data;
        $session = [];

        if (file_exists($this->getPath(session_id()))) {
            $session = $this->loadStorage($this->getPath(session_id()));
        }

        $session[$index] = $data;

        if (
            isset($this->options['encrypted']) &&
            $this->options['encrypted'] === true
        ) {
            $session[$index] = Crypt::encrypt($data);
        }

        file_put_contents($this->getPath(session_id()), json_encode($session));

        return true;
    }

    /**
     * Remove session data based on index.
     *
     * @param int $index
     * @return bool
     */
    public function remove($index)
    {
        if ($unique_id = $this->_uniqueId) {
            $index = $unique_id.'#'.$index;
        }

        if (! file_exists($this->getPath(session_id()))) {
            return false;
        }

        $session = $this->loadStorage($this->getPath(session_id()));

        unset($session[$index]);

        file_put_contents($this->getPath(session_id()), json_encode($session));

        return true;
    }

    /**
     * Destroy the session.
     *
     * @param bool $remove_file To remove entirely the session file
     * @return bool
     */
    public function destroy($remove_file = false)
    {
        if ($remove_file) {
            if (! file_exists($this->getPath(session_id()))) {
                return false;
            }

            unlink($this->getPath(session_id()));
        }

        session_destroy();

        return true;
    }

    /**
     * Set the session name.
     *
     * @param string $name
     * @return void
     */
    public function setName($name = null)
    {
        session_name($name);
    }
}
