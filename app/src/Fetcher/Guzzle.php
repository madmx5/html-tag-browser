<?php

namespace App\Fetcher;

use App\Contracts\Fetcher as FetcherContract;

class Guzzle implements FetcherContract
{
    protected $resource;

    protected $response;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function fetch()
    {
        return $this->response = $this->client->get($this->resource);
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;
        return $this;
    }
}
