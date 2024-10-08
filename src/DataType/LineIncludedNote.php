<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BT-127-00.
 */
class LineIncludedNote
{
    protected const string XML_NODE = 'ram:IncludedNote';

    /**
     * @param string $content - BT-127
     */
    public function __construct(
        private string $content,
    ) {
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

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $lineIncludedNoteElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $lineIncludedNoteElements->count()) {
            return null;
        }

        if ($lineIncludedNoteElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $lineIncludedNoteElement */
        $lineIncludedNoteElement = $lineIncludedNoteElements->item(0);

        $contentElements = $xpath->query('./ram:Content', $lineIncludedNoteElement);

        if (1 !== $contentElements->count()) {
            throw new \Exception('Malformed');
        }

        return new self($contentElements->item(0)->nodeValue);
    }
}
