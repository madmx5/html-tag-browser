<?php

namespace App\Contracts;

interface Parser
{
    /**
     * Parse a source object into a usable product
     *
     * @param string $source HTML source to be parsed
     */
    public function parse($source);

    /**
     * Obtain list of unique tags and their count
     *
     * @return array
     */
    public function getCountByTagName();
}
