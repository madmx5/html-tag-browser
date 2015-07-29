<?php

namespace App\Contracts;

interface Decorator
{
    /**
     * Decorate a source object
     *
     * @param mixed $source object to decorate
     * @return mixed
     */
    public function decorate($source);
}
