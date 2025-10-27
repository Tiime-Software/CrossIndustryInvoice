<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Flux1;

use Tiime\CrossIndustryInvoice\DataType\LineIncludedNote;
use Tiime\CrossIndustryInvoice\Utils\XPath;

/**
 * BT-126-00.
 */
class AssociatedDocumentLineDocument
{
    protected const string XML_NODE = 'ram:AssociatedDocumentLineDocument';

    /**
     * BT-127-00.
     *
     * @var array<int, LineIncludedNote>
     */
    private array $includedNotes;

    public function __construct(
    ) {
        $this->includedNotes = [];
    }

    /**
     * @return LineIncludedNote[]
     */
    public function getIncludedNotes(): array
    {
        return $this->includedNotes;
    }

    /**
     * @param LineIncludedNote[] $includedNotes
     */
    public function setIncludedNotes(array $includedNotes): static
    {
        foreach ($includedNotes as $includedNote) {
            if (!($includedNote instanceof LineIncludedNote)) {
                throw new \TypeError('Array elements must be of type ' . LineIncludedNote::class);
            }
        }

        $this->includedNotes = $includedNotes;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE);

        foreach ($this->includedNotes as $includedNote) {
            $element->appendChild($includedNote->toXML($document));
        }

        return $element;
    }

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): self
    {
        $associatedDocumentLineDocumentElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $associatedDocumentLineDocumentElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $associatedDocumentLineDocumentElement */
        $associatedDocumentLineDocumentElement = $associatedDocumentLineDocumentElements->item(0);

        $includedNotes = LineIncludedNote::fromXML($xpath, $associatedDocumentLineDocumentElement);

        $associatedDocumentLineDocument = new self();

        if (!empty($includedNotes)) {
            $associatedDocumentLineDocument->setIncludedNotes($includedNotes);
        }

        return $associatedDocumentLineDocument;
    }
}
