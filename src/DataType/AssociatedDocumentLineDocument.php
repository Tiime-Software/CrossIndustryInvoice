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
    private InvoiceLineIdentifier $lineID;

    /**
     * BT-127-00.
     */
    private ?LineIncludedNote $includedNote;

    public function __construct(InvoiceLineIdentifier $lineID)
    {
        $this->lineID = $lineID;
    }

    public function getLineID(): InvoiceLineIdentifier
    {
        return $this->lineID;
    }

    public function getIncludedNote(): ?LineIncludedNote
    {
        return $this->includedNote;
    }

    public function setIncludedNote(?LineIncludedNote $includedNote): void
    {
        $this->includedNote = $includedNote;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:AssociatedDocumentLineDocument');

        $element->appendChild($document->createElement('ram:LineID', $this->lineID->value));

        if ($this->includedNote instanceof LineIncludedNote) {
            $element->appendChild($this->includedNote->toXML($document));
        }

        return $element;
    }
}
