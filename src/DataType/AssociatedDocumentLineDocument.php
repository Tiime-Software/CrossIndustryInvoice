<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Identifier\InvoiceLineIdentifier;

/**
 * BT-126-00.
 */
class AssociatedDocumentLineDocument
{
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
        $element = $document->createElement('ram:AssociatedDocumentLineDocument');

        $element->appendChild($document->createElement('ram:LineID', $this->lineIdentifier->value));

        if ($this->includedNote instanceof LineIncludedNote) {
            $element->appendChild($this->includedNote->toXML($document));
        }

        return $element;
    }
}
