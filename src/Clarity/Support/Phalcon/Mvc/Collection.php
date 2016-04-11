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
 * @subpackage Clarity\Support\Phalcon\Mvc
 */
namespace Clarity\Support\Phalcon\Mvc;

use Phalcon\Mvc\Collection as BaseCollection;

class Collection extends BaseCollection
{
    /**
     * A shortcut way when creating a new document
     *
     * @param  array $data
     * @return boolean
     */
    public function create($data)
    {
        foreach ($data as $key => $val) {
            $this->{$key} = $val;
        }

        return $this->save();
    }
}
