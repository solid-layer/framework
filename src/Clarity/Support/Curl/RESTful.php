<?php
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
