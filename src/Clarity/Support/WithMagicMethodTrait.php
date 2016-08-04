<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

/**
 */
namespace Clarity\Support;

use BadMethodCallException;

trait WithMagicMethodTrait
{
    /**
     * Magic methods that uses 'withVarName'.
     *
     * @return string
     */
    public function __call($method, $parameters)
    {
        if (starts_with($method, 'with')) {
            return $this->with(snake_case(substr($method, 4)),
                $parameters[ 0 ]);
        }

        throw new BadMethodCallException("Method [$method] does not exist on view.");
    }
}
