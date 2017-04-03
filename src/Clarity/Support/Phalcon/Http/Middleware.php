<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Support\Phalcon\Http;

use InvalidArgumentException;

/**
 * {@inheritdoc}
 */
class Middleware
{
    /**
     * @var array
     */
    protected $middlewares = [];

    /**
     * Contructor.
     *
     * @param array $middlewares
     */
    public function __construct($middlewares = [])
    {
        $this->middlewares = $middlewares;
    }

    /**
     * Get a middleware.
     *
     * @param string $alias
     * @return string
     */
    public function get($alias)
    {
        if (! isset($this->middlewares[$alias])) {
            throw new InvalidArgumentException(
                "Middleware based on alias [$alias] not found."
            );
        }

        return $this->middlewares[$alias];
    }

    /**
     * Set a middleware.
     *
     * @param array $middlewares
     * @return mixed|\Clarity\Support\Phalcon\Http\Middleware
     */
    public function set($middlewares)
    {
        $this->middlewares = $middlewares;

        return $this;
    }
}
