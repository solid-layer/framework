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
namespace Clarity\Support\Curl;

use GuzzleHttp\Client;

class RESTful
{
    private $client;

    public function __construct($base_uri)
    {
        $this->client = new Client([
            'base_uri' => $base_uri,
        ]);
    }

    public function getClient()
    {
        return $this->client;
    }

    public function __call($method, $params)
    {
        return call_user_func_array([$this->client, $method], $params);
    }
}
