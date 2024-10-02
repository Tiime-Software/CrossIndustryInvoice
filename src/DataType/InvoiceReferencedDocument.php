<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Reference\PrecedingInvoiceReference;
use Tiime\EN16931\Invoice;

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

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): array
    {
        $invoiceReferencedDocumentElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $invoiceReferencedDocumentElements->count()) {
            return [];
        }

        $invoiceReferencedDocuments = [];

        /** @var \DOMElement $invoiceReferencedDocumentElements */
        foreach ($invoiceReferencedDocumentElements as $invoiceReferencedDocumentElement) {
            $issuerAssignedIdentifierElements = $xpath->query('./ram:IssuerAssignedID', $invoiceReferencedDocumentElement);

            if (1 !== $issuerAssignedIdentifierElements->count()) {
                throw new \Exception('Malformed');
            }

            $issuerAssignedIdentifier = $issuerAssignedIdentifierElements->item(0)->nodeValue;

            $formattedIssueDateTime = FormattedIssueDateTime::fromXML($xpath, $invoiceReferencedDocumentElement);

            $invoiceReferencedDocument = new self(new PrecedingInvoiceReference($issuerAssignedIdentifier));

            if ($formattedIssueDateTime instanceof FormattedIssueDateTime) {
                $invoiceReferencedDocument->setFormattedIssueDateTime($formattedIssueDateTime);
            }

            $invoiceReferencedDocuments[] = $invoiceReferencedDocument;
        }

        return $invoiceReferencedDocuments;
    }

    public static function fromEN16931(Invoice $invoice): array
    {
        $precedingInvoices = $invoice->getPrecedingInvoices();

        $invoiceReferencedDocuments = [];

        foreach ($precedingInvoices as $precedingInvoice) {
            $invoiceReferencedDocuments[] = (new self($precedingInvoice->getReference()))
                ->setFormattedIssueDateTime(new FormattedIssueDateTime($precedingInvoice->getIssueDate()));
        }

        return $invoiceReferencedDocuments;
    }
}
