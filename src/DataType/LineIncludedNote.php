<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\CrossIndustryInvoice\Utils\XPath;

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
        private readonly string $content,
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

    /**
     * @return array<int, LineIncludedNote>
     */
    public static function fromXML(XPath $xpath, \DOMElement $currentElement): array
    {
        $lineIncludedNoteElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $lineIncludedNoteElements->count()) {
            return [];
        }

        $lineIncludedNotes = [];

        foreach ($lineIncludedNoteElements as $lineIncludedNoteElement) {
            $contentElements = $xpath->query('./ram:Content', $lineIncludedNoteElement);

            if (1 !== $contentElements->count()) {
                throw new \Exception('Malformed');
            }

            $lineIncludedNotes[] = new self($contentElements->item(0)->nodeValue);
        }

        return $lineIncludedNotes;
    }
}
