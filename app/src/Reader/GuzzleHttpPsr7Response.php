<?php

namespace App\Reader;

use App\Contracts\Reader as ReaderContract;
use GuzzleHttp\Psr7\StreamWrapper;

class GuzzleHttpPsr7Response implements ReaderContract
{
    protected $contents;

    public function getContents()
    {
        return $this->contents;
    }

    public function read($source)
    {
        $resource = StreamWrapper::getResource($source->getBody());

        return $this->contents = stream_get_contents($resource);
    }
}
