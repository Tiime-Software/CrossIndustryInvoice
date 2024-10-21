<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BasicWL;

use Tiime\CrossIndustryInvoice\DataType\DocumentIncludedNote;
use Tiime\CrossIndustryInvoice\DataType\IssueDateTime;
use Tiime\EN16931\Codelist\InvoiceTypeCodeUNTDID1001;
use Tiime\EN16931\DataType\Identifier\InvoiceIdentifier;

/**
 * BT-1-00.
 */
class ExchangedDocument extends \Tiime\CrossIndustryInvoice\DataType\Minimum\ExchangedDocument
{
    protected const string XML_NODE = 'rsm:ExchangedDocument';

    /**
     * BG-1.
     *
     * @var array<int, DocumentIncludedNote>
     */
    private array $includedNotes;

    public function __construct(InvoiceIdentifier $identifier, InvoiceTypeCodeUNTDID1001 $typeCode, IssueDateTime $issueDateTime)
    {
        parent::__construct($identifier, $typeCode, $issueDateTime);
        $this->includedNotes = [];
    }

    /**
     * @return DocumentIncludedNote[]
     */
    public function getIncludedNotes(): array
    {
        return $this->includedNotes;
    }

    public function setIncludedNotes(array $includedNotes): static
    {
        foreach ($includedNotes as $includedNote) {
            if (!$includedNote instanceof DocumentIncludedNote) {
                throw new \TypeError();
            }
        }

        $this->includedNotes = $includedNotes;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = parent::toXML($document);

        foreach ($this->includedNotes as $includedNote) {
            $element->appendChild($includedNote->toXML($document));
        }

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

        $typeCode = InvoiceTypeCodeUNTDID1001::tryFrom($typeCodeElements->item(0)->nodeValue);

        if (null === $typeCode) {
            throw new \Exception('Wrong currency code');
        }

        $issueDateTime = IssueDateTime::fromXML($xpath, $exchangedDocumentElement);
        $includedNotes = DocumentIncludedNote::fromXML($xpath, $exchangedDocumentElement);

        $exchangedDocument = new self(new InvoiceIdentifier($identifier), $typeCode, $issueDateTime);

        if (\count($includedNotes) > 0) {
            $exchangedDocument->setIncludedNotes($includedNotes);
        }

        return $exchangedDocument;
    }
}
