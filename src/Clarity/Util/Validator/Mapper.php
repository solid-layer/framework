<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Util\Validator;

use Illuminate\Support\Str;

/**
 * This maps all the available rules and creates a map to get the extracted
 * methods and parameters.
 */
class Mapper
{
    /**
     * @var array
     */
    private $rules;

    /**
     * Set the rules.
     *
     * @param array $rules
     * @return \Clarity\Util\Validator\Mapper
     */
    public function setRules($rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Handle the rule sequence builder.
     *
     * @param array $explicit_rules
     * @param bool $merge
     * @return array
     */
    public function handle($explicit_rules = [], $merge = false)
    {
        $rules = $this->rules;

        # you could pass a custom rules to override the existing provided rules.
        # yet you could specify to merge or not.
        if (count($explicit_rules) > 0) {
            if ($merge) {
                $rules = array_merge($rules, $explicit_rules);
            } else {
                $rules = $explicit_rules;
            }
        }

        return $this->parse($this->rules);
    }

    /**
     * Parse the rules into well formed array.
     *
     * @param array $rules
     * @return array
     */
    public function parse($rules)
    {
        $maps = [];

        foreach ($rules as $field => $rule) {
            if (is_string($rule)) {
                $rule = [$rule];
            }

            foreach ($rule as $key => $val) {
                $must_be = true;
                $method = $val;
                $params = [];

                # check if the key is string, then that's an associative
                # array to parse the remaining method and params.
                if (is_string($key)) {
                    $method = $key;
                    $params = $rule[$key];
                }

                # check weither the method has exclamation point
                # that means we need to reverse the expected value by
                # changing the $must_be to false
                if ($method{0} === '!') {
                    $must_be = false;
                    $method = substr($method, 1);
                }

                $maps[] = [
                    'field' => $field,
                    'must_be' => $must_be,
                    'method' => lcfirst(Str::studly($method)),
                    'params' => $params,
                ];
            }
        }

        return $maps;
    }
}
