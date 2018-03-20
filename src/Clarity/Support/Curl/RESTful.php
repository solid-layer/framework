<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Support\Curl;

use GuzzleHttp\Client;

/**
 * A basic restful request.
 */
class RESTful
{
    /**
     * @var mixed|\GuzzleHttp\Client
     */
    private $client;

    /**
     * Contructor.
     *
     * @param string $base_uri
     */
    public function __construct($base_uri)
    {
        $this->client = new Client([
            'base_uri' => $base_uri,
        ]);
    }

    /**
     * Get the client.
     *
     * @return mixed|\GuzzleHttp\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Callable.
     *
     * @param string $method
     * @param array $params
     */
    public function __call($method, $params)
    {
        return call_user_func_array([$this->client, $method], $params);
    }
}
