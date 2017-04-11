<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Support\Auth;

use InvalidArgumentException;
use Phalcon\DiInterface;
use Phalcon\Di\InjectionAwareInterface;

/**
 * Authentication handler.
 */
class Auth implements InjectionAwareInterface
{
    /**
     * @var \Phalcon\DiInterface
     */
    protected $_di;

    /**
     * {@inheritdoc}
     */
    public function setDI(DiInterface $di)
    {
        $this->_di = $di;
    }

    /**
     * {@inheritdoc}
     */
    public function getDI()
    {
        return $this->_di;
    }

    /**
     * Attempt to login using the provided records and the password field.
     *
     * @param  array $records
     * @return bool
     */
    public function attempt($records)
    {
        $password_field = config()->app->auth->password_field;

        if (isset($records[$password_field]) === false) {
            throw new InvalidArgumentException('Invalid argument for password field.');
        }

        # get the password information

        $password = $records[$password_field];
        unset($records[$password_field]);

        # build the conditions

        $first = true;
        $conditions = null;

        foreach ($records as $key => $record) {
            if (! $first) {
                $conditions .= 'AND';
            }

            $conditions .= " {$key} = :{$key}: ";

            $first = false;
        }

        # find the informations provided in the $records

        $auth_model = config()->app->auth->model;

        $records = $auth_model::find([
            $conditions,
            'bind' => $records,
        ])->getFirst();

        # check if there is no record, then return false

        if (! $records) {
            return false;
        }

        # now check if the password given is matched with the
        # existing password recorded.

        if ($this->getDI()->get('security')->checkHash($password, $records->{$password_field})) {
            $this->getDI()->get('session')->set('isAuthenticated', true);
            $this->getDI()->get('session')->set('user', $records);

            return true;
        }

        return false;
    }

    /**
     * Redirect based on the key provided in the url.
     *
     * @return mixed|bool
     */
    public function redirectIntended()
    {
        $redirect_key = config()->app->auth->redirect_key;

        $redirect_to = $this->getDI()->get('request')->get($redirect_key);

        if ($redirect_to) {
            return $this->getDI()->get('response')->redirect($redirect_to);
        }

        return false;
    }

    /**
     * To determine if the user is logged in.
     *
     * @return bool
     */
    public function check()
    {
        if ($this->getDI()->get('session')->has('isAuthenticated')) {
            return true;
        }

        return false;
    }

    /**
     * Get the stored user information.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->getDI()->get('session')->get('user');
    }

    /**
     * Destroy the current auth.
     *
     * @return bool
     */
    public function destroy()
    {
        $this->getDI()->get('session')->remove('isAuthenticated');
        $this->getDI()->get('session')->remove('user');

        return true;
    }
}
