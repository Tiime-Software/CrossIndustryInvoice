<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Reference\PrecedingInvoiceReference;

/**
 * BG-3.
 */
class InvoiceReferencedDocument
{
    protected const XML_NODE = 'ram:InvoiceReferencedDocument';

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
        $element = $document->createElement(self::XML_NODE);

        $element->appendChild($document->createElement('ram:IssuerAssignedID', $this->issuerAssignedIdentifier->value));

        if ($this->formattedIssueDateTime instanceof FormattedIssueDateTime) {
            $element->appendChild($this->formattedIssueDateTime->toXML($document));
        }

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?static
    {
        $invoiceReferencedDocumentElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $invoiceReferencedDocumentElements->count()) {
            return null;
        }

        if ($invoiceReferencedDocumentElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $invoiceReferencedDocumentElement */
        $invoiceReferencedDocumentElement = $invoiceReferencedDocumentElements->item(0);

        $issuerAssignedIdentifierElements = $xpath->query('.//ram:IssuerAssignedID', $invoiceReferencedDocumentElement);

        if (1 !== $issuerAssignedIdentifierElements->count()) {
            throw new \Exception('Malformed');
        }

        $issuerAssignedIdentifier = $issuerAssignedIdentifierElements->item(0)->nodeValue;

        $formattedIssueDateTime = FormattedIssueDateTime::fromXML($xpath, $invoiceReferencedDocumentElement);

        $invoiceReferencedDocument = new self(new PrecedingInvoiceReference($issuerAssignedIdentifier));

        if (null !== $formattedIssueDateTime) {
            $invoiceReferencedDocument->setFormattedIssueDateTime($formattedIssueDateTime);
        }

        return $invoiceReferencedDocument;
    }
}
