<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\BusinessTermsGroup\InvoiceLine;
use Tiime\EN16931\DataType\Identifier\InvoiceLineIdentifier;

/**
 * BT-126-00.
 */
class AssociatedDocumentLineDocument
{
    protected const XML_NODE = 'ram:AssociatedDocumentLineDocument';

    /**
     * BT-126.
     */
    private InvoiceLineIdentifier $lineIdentifier;

    /**
     * BT-127-00.
     */
    private ?LineIncludedNote $includedNote;

    public function __construct(InvoiceLineIdentifier $lineIdentifier)
    {
        $this->lineIdentifier = $lineIdentifier;
        $this->includedNote   = null;
    }

    public function getLineIdentifier(): InvoiceLineIdentifier
    {
        return $this->lineIdentifier;
    }

    public function getIncludedNote(): ?LineIncludedNote
    {
        return $this->includedNote;
    }

    public function setIncludedNote(?LineIncludedNote $includedNote): static
    {
        $this->includedNote = $includedNote;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE);

        $element->appendChild($document->createElement('ram:LineID', $this->lineIdentifier->value));

        if ($this->includedNote instanceof LineIncludedNote) {
            $element->appendChild($this->includedNote->toXML($document));
        }

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $associatedDocumentLineDocumentElements = $xpath->query(sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $associatedDocumentLineDocumentElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $associatedDocumentLineDocumentElement */
        $associatedDocumentLineDocumentElement = $associatedDocumentLineDocumentElements->item(0);

        $lineIdentifierElements = $xpath->query('./ram:LineID', $associatedDocumentLineDocumentElement);

        if (1 !== $lineIdentifierElements->count()) {
            throw new \Exception('Malformed');
        }

        $lineIdentifier = $lineIdentifierElements->item(0)->nodeValue;
        $includedNote   = LineIncludedNote::fromXML($xpath, $associatedDocumentLineDocumentElement);

        $associatedDocumentLineDocument = new self(new InvoiceLineIdentifier($lineIdentifier));

        if ($includedNote instanceof LineIncludedNote) {
            $associatedDocumentLineDocument->setIncludedNote($includedNote);
        }

        return $associatedDocumentLineDocument;
    }

    public static function fromEN16931(InvoiceLine $invoiceLine): self
    {
        return (new self($invoiceLine->getIdentifier()))
            ->setIncludedNote(\is_string($invoiceLine->getNote()) ? new LineIncludedNote($invoiceLine->getNote()) : null);
    }
}
