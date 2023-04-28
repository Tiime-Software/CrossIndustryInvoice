<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Reference\PrecedingInvoiceReference;

/**
 * BG-3.
 */
class InvoiceReferencedDocument
{
    /**
     * BT-25.
     */
    private PrecedingInvoiceReference $issuerAssignedIdentifier;

    /**
     * BT-26-00.
     */
    private ?FormattedIssueDateTime $formattedIssueDateTime;

    public function __construct(PrecedingInvoiceReference $issuerAssignedIdentifier)
    {
        $this->issuerAssignedIdentifier = $issuerAssignedIdentifier;
        $this->formattedIssueDateTime   = null;
    }

    public function getIssuerAssignedIdentifier(): PrecedingInvoiceReference
    {
        return $this->issuerAssignedIdentifier;
    }

    public function getFormattedIssueDateTime(): ?FormattedIssueDateTime
    {
        return $this->formattedIssueDateTime;
    }

    public function setFormattedIssueDateTime(?FormattedIssueDateTime $formattedIssueDateTime): static
    {
        $this->formattedIssueDateTime = $formattedIssueDateTime;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:InvoiceReferencedDocument');

        $element->appendChild($document->createElement('ram:IssuerAssignedID', $this->issuerAssignedIdentifier->value));

        if ($this->formattedIssueDateTime instanceof FormattedIssueDateTime) {
            $element->appendChild($this->formattedIssueDateTime->toXML($document));
        }

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?static
    {
        // todo
    }
}
