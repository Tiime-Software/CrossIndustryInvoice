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
        $xpath = new \DOMXPath($document);

        $identifierElements    = $xpath->query('//ram:ID');
        $typeCodeElements      = $xpath->query('//ram:TypeCode');
        $issueDateTimeElements = $xpath->query('//ram:IssueDateTime');

        if (1 !== $identifierElements->count()) {
            throw new \Exception('Malformed');
        }

        if (1 !== $typeCodeElements->count()) {
            throw new \Exception('Malformed');
        }

        if (1 !== $issueDateTimeElements->count()) {
            throw new \Exception('Malformed');
        }

        $identifier = $identifierElements->item(0)->nodeValue;
        $typeCode   = $typeCodeElements->item(0)->nodeValue;

        $issueDateTimeDocument = new \DOMDocument();
        $issueDateTimeDocument->appendChild($issueDateTimeDocument->importNode($issueDateTimeElements->item(0), true));
        $issueDateTime = IssueDateTime::fromXML($issueDateTimeDocument);

        return new static($identifier, $typeCode, $issueDateTime);
    }
}
