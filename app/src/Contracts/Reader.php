<?php

namespace App\Contracts;

interface Reader
{
    /**
     * Obtain the contents of the last read operation
     *
     * @return string
     */
    public function getContents();

    /**
     * Read a source object into a usable state
     *
     * @param mixed $source object to be read
     */
    public function read($source);
}
