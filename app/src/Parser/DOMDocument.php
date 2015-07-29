<?php

namespace App\Parser;

use App\Contracts\Parser as ParserContract;
use App\Contracts\Reader as ReaderContract;

class DOMDocument implements ParserContract
{
    protected $document;

    public function __construct(ReaderContract $reader)
    {
        $this->reader = $reader;

        $this->document = new \DOMDocument;
    }

    public function parse($source)
    {
        // libxml can be very noisy, turn it off
        $level = error_reporting(0);

        $this->document->loadHTML($this->reader->read($source), LIBXML_NOERROR | LIBXML_NOWARNING);

        // Restore previous error_reporting level
        error_reporting($level);
    }

    public function getCountByTagName()
    {
        $elements = $this->document->getElementsByTagName('*');

        $results = [ ];

        // Create a list of unique tags in the document and count each occurrance
        foreach ($elements as $element)
        {
            $nodeName = strtolower((string) $element->nodeName);

            if (empty($results[$nodeName])) {
                $results[$nodeName] = 1;
            }
            else {
                $results[$nodeName]++;
            }
        }

        return $results;
    }
}
