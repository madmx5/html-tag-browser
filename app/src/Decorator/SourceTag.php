<?php

namespace App\Decorator;

use App\Contracts\Decorator as DecoratorContract;

class SourceTag implements DecoratorContract
{
    protected $classPrefix = 'source-tag';

    public function setPrefix($prefix)
    {
        $this->classPrefix = $prefix;
    }

    public function decorate($source)
    {
        // Convert HTML source to a safe format
        $safe = htmlentities($source);

        // Prepend markup to safe source to allow highlighting by tag name
        return preg_replace(
            '@&lt;(\s*)([a-z0-9_\-\.]+)@i',
            '&lt;\1<span class="' . $this->classPrefix . ' ' . $this->classPrefix . '-\2">\2</span>',
            $safe
        );
    }
}
