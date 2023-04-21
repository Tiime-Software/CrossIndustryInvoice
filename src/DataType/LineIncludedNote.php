<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BT-127-00.
 */
class LineIncludedNote
{
    /**
     * BT-127.
     */
    private string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:IncludedNote');

        $element->appendChild($document->createElement('ram:Content', $this->content));

        return $element;
    }
}
