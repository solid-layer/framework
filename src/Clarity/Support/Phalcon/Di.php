<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Support\Phalcon;

use Phalcon\Di as BaseDi;

/**
 * Override the existing Phalcon\DI class.
 */
class Di extends BaseDi implements \Phalcon\DiInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($name, $parameters = null)
    {
        try {
            return parent::get($name, $parameters);
        } catch (\Phalcon\Di\Exception $e) {
            return resolve($name);
        }
    }
}
