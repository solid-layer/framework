<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Util\Validator;

use Respect\Validation as ResVal;
use Respect\Validation\Exceptions\NestedValidationException;

/**
 * This class handles the validations.
 */
class Validator
{
    /**
     * @var array
     */
    private $messages = [];

    /**
     * @var \Respect\Validation\Validator
     */
    private $validator;

    /**
     * @var array
     */
    private $records;

    /**
     * @var array
     */
    private $errors;

    /**
     * @var array
     */
    private $data;

    /**
     * Build the rules into well transformed data.
     *
     * @param array $rules
     * @return array
     */
    public function lists($rules = [])
    {
        $mapper = new Mapper();

        return $mapper->setRules($rules)->handle();
    }

    /**
     * Create a validation based on the data provided and rules.
     *
     * @param array $data
     * @param array $rules
     *
     * @return \Clarity\Util\Validator\Validator
     */
    public function make($records = [], $rules = [], $messages = [])
    {
        $this->validator = new ResVal\Validator;
        $this->records = $records;
        $this->messages = $messages;

        foreach ($this->lists($rules) as $rule) {
            $field = $rule['field'];

            $result = forward_static_call_array(
                [ResVal\Validator::class, $rule['method']],
                $rule['params']
            );

            if ($rule['must_be'] === false) {
                $result = ResVal\Validator::not($result);
            }

            $this->validator->key($field, $result);
        }

        return $this;
    }

    /**
     * Check if there was an error found.
     *
     * @return bool
     */
    public function fails()
    {
        return ! $this->validator->validate($this->records);
    }

    /**
     * Get the response messages.
     *
     * @return array
     */
    protected function messages()
    {
        $messages = [];

        foreach ($this->records as $field => $val) {
            $messages[$field] = null;
        }

        return array_merge(array_merge($messages, $this->messages));
    }

    /**
     * Get all the errors.
     *
     * @return array
     */
    public function errors()
    {
        $ret = [];

        # assert the records and extract all the errors
        try {
            $this->validator->assert($this->records);
        } catch (NestedValidationException $e) {
            $errors = $e->findMessages($this->messages());

            foreach ($errors as $field => $msg) {
                if ($msg !== '') {
                    $ret[] = [$field => $msg];
                }
            }
        }

        return $ret;
    }

    /**
     * Call static.
     *
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        return ResVal\Validator::__callStatic($method, $args);
    }
}
