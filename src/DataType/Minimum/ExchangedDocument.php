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
    protected const string XML_NODE = 'rsm:ExchangedDocument';

    /**
     * @param InvoiceIdentifier $identifier    - BT-1
     * @param InvoiceTypeCode   $typeCode      - BT-3
     * @param IssueDateTime     $issueDateTime - BT-2-00
     */
    public function __construct(
        private InvoiceIdentifier $identifier,
        private InvoiceTypeCode $typeCode,
        private IssueDateTime $issueDateTime,
    ) {
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
        $element = $document->createElement(self::XML_NODE);

        $element->appendChild($document->createElement('ram:ID', $this->identifier->value));
        $element->appendChild($document->createElement('ram:TypeCode', $this->typeCode->value));

        $element->appendChild($this->issueDateTime->toXML($document));

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $exchangedDocumentElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $exchangedDocumentElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $exchangedDocumentElement */
        $exchangedDocumentElement = $exchangedDocumentElements->item(0);

        $identifierElements = $xpath->query('./ram:ID', $exchangedDocumentElement);
        $typeCodeElements   = $xpath->query('./ram:TypeCode', $exchangedDocumentElement);

        if (1 !== $identifierElements->count()) {
            throw new \Exception('Malformed');
        }

        if (1 !== $typeCodeElements->count()) {
            throw new \Exception('Malformed');
        }

        $identifier = $identifierElements->item(0)->nodeValue;

        $typeCode = InvoiceTypeCode::tryFrom($typeCodeElements->item(0)->nodeValue);

        if (null === $typeCode) {
            throw new \Exception('Wrong currency code');
        }

        $issueDateTime = IssueDateTime::fromXML($xpath, $exchangedDocumentElement);

        return new self(new InvoiceIdentifier($identifier), $typeCode, $issueDateTime);
    }
}
