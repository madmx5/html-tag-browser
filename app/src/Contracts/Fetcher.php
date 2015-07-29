<?php

namespace App\Contracts;

interface Fetcher
{
    /**
     * Fetch the currently defined resource
     */
    public function fetch();

    /**
     * Obtain the response from fetch operation
     *
     * @return object
     */
    public function getResponse();

    /**
     * Define the resource that will be fetched
     *
     * @param mixed $resource the resource to be fetch()ed
     */
    public function setResource($resource);
}
