<?php
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
