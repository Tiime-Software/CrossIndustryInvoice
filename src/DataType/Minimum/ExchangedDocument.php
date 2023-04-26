<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Minimum;

use Tiime\CrossIndustryInvoice\DataType\IssueDateTime;
use Tiime\EN16931\DataType\Identifier\InvoiceIdentifier;
use Tiime\EN16931\DataType\InvoiceTypeCode;

/**
 * BT-1-00.
 */
class ExchangedDocument
{
    /**
     * BT-1.
     */
    private InvoiceIdentifier $identifier;

    /**
     * BT-3.
     */
    private InvoiceTypeCode $typeCode;

    /**
     * BT-2-00.
     */
    private IssueDateTime $issueDateTime;

    public function __construct(InvoiceIdentifier $identifier, InvoiceTypeCode $typeCode, IssueDateTime $issueDateTime)
    {
        $this->identifier    = $identifier;
        $this->typeCode      = $typeCode;
        $this->issueDateTime = $issueDateTime;
    }

    public function getIdentifier(): InvoiceIdentifier
    {
        return $this->identifier;
    }

    public function getTypeCode(): InvoiceTypeCode
    {
        return $this->typeCode;
    }

    public function getIssueDateTime(): IssueDateTime
    {
        return $this->issueDateTime;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('rsm:ExchangedDocument');

        $element->appendChild($document->createElement('ram:ID', $this->identifier->value));
        $element->appendChild($document->createElement('ram:TypeCode', $this->typeCode->value));
        $element->appendChild($this->issueDateTime->toXML($document));

        return $element;
    }

    public static function fromXML(\DOMDocument $document): static
    {
        // todo identifier
        // todo typeCode
        $issueDateTime = IssueDateTime::fromXML($document);

//        return new static($identifier, $typeCode, $issueDateTime);
    }
}
