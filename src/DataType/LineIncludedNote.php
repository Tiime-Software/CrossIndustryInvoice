<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BT-127-00.
 */
class LineIncludedNote
{
    protected const XML_NODE = 'ram:IncludedNote';

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
        $element = $document->createElement(self::XML_NODE);

        $element->appendChild($document->createElement('ram:Content', $this->content));

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?static
    {
        $lineIncludedNoteElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $lineIncludedNoteElements->count()) {
            return null;
        }

        if ($lineIncludedNoteElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $lineIncludedNoteElement */
        $lineIncludedNoteElement = $lineIncludedNoteElements->item(0);

        $content = $xpath->query('.//ram:Content', $lineIncludedNoteElement);

        return new self($content);
    }
}
